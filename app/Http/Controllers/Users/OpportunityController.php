<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\UserController;
use App\Http\Requests;
use App\Http\Requests\OpportunityRequest;
use App\Models\Opportunity;
use App\Models\Option;
use App\Models\Quotation;
use App\Models\Tag;
use App\Repositories\CompanyRepository;
use App\Repositories\OpportunityRepository;
use App\Repositories\OptionRepository;
use App\Repositories\SalesTeamRepository;
use App\Repositories\UserRepository;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Http\Request;
use Sentinel;
use yajra\Datatables\Datatables;

class OpportunityController extends UserController
{
    public $companyRepository;
    public $userRepository;
    /**
     * @var OpportunityRepository
     */
    private $opportunityRepository;
    /**
     * @var SalesTeamRepository
     */
    private $salesTeamRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;

    /**
     * OpportunityController constructor.
     * @param CompanyRepository $companyRepository
     * @param UserRepository $userRepository
     * @param OpportunityRepository $opportunityRepository
     * @param SalesTeamRepository $salesTeamRepository
     * @param OptionRepository $optionRepository
     */
    public function __construct(CompanyRepository $companyRepository,
                                UserRepository $userRepository,
                                OpportunityRepository $opportunityRepository,
                                SalesTeamRepository $salesTeamRepository,
                                OptionRepository $optionRepository)
    {
        $this->middleware('authorized:opportunities.read', ['only' => ['index', 'data']]);
        $this->middleware('authorized:opportunities.write', ['only' => ['create', 'store', 'update', 'edit']]);
        $this->middleware('authorized:opportunities.delete', ['only' => ['delete']]);

        parent::__construct();

        $this->opportunityRepository = $opportunityRepository;
        $this->companyRepository = $companyRepository;
        $this->userRepository = $userRepository;
        $this->salesTeamRepository = $salesTeamRepository;
        $this->optionRepository = $optionRepository;

        view()->share('type', 'opportunity');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('opportunity.opportunities');
        return view('user.opportunity.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('opportunity.new');
        $calls = 0;
        $meetings = 0;

        $this->generateParams();

        return view('user.opportunity.create', compact('title', 'meetings', 'calls'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(OpportunityRequest $request)
    {
        $this->opportunityRepository->create($request->all());

        return redirect("opportunity");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Opportunity $opportunity)
    {
        $calls = $opportunity->calls()->count();
        $meetings =  $opportunity->meetings()->count();

        $title = trans('opportunity.edit');

        $this->generateParams();

        return view('user.opportunity.edit', compact('title', 'calls', 'meetings', 'opportunity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(OpportunityRequest $request, Opportunity $opportunity)
    {
        $opportunity->update($request->all());

        return redirect("opportunity");
    }

    public function show(Opportunity $opportunity)
    {
        $title = trans('opportunity.show');
        $action = 'show';
        $this->generateParams();
        return view('user.opportunity.show', compact('title', 'opportunity','action'));
    }

    public function won(Opportunity $opportunity)
    {
        $title = trans('opportunity.won');
        $this->generateParams();
        $action = 'won';
        return view('user.opportunity.lost_won', compact('title', 'opportunity','action'));
    }

    public function lost(Opportunity $opportunity)
    {
        $title = trans('opportunity.lost');
        $this->generateParams();
        $action = 'lost';
        return view('user.opportunity.lost_won', compact('title', 'opportunity','action'));
    }

    public function updateLost(Request $request, Opportunity $opportunity)
    {
        $request->merge([
            'stages' => 'Lost',
        ]);
        $opportunity->update($request->all());

        return redirect("opportunity");
    }

    public function delete(Opportunity $opportunity)
    {
        $title = trans('opportunity.delete');
        $this->generateParams();
        return view('user.opportunity.delete', compact('title', 'opportunity'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Opportunity $opportunity)
    {
        $opportunity->delete();
        return redirect('opportunity');
    }

    public function data()
    {
        $opportunities = $this->opportunityRepository->getAll()
            ->with('salesTeam', 'customer', 'calls', 'meetings')
            ->get()
            ->map(function ($opportunity) {
                return [
                    'id' => $opportunity->id,
                    'opportunity' => $opportunity->opportunity,
                    'company' => isset($opportunity->customer) ? $opportunity->customer->name : '',
                    'next_action' => $opportunity->next_action,
                    'next_action_title' => $opportunity->next_action_title,
                    'stages' => $opportunity->stages,
                    'expected_revenue' => $opportunity->expected_revenue,
                    'probability' => $opportunity->probability,
                    'salesteam' => isset($opportunity->salesTeam) ? $opportunity->salesTeam->salesteam : '',
                    'calls' => $opportunity->calls->count(),
                    'meetings' => $opportunity->meetings->count()
                ];
            });
        return Datatables::of($opportunities)
            ->add_column('actions', ' @if(Sentinel::getUser()->hasAccess([\'opportunities.write\']) || Sentinel::inRole(\'admin\'))
                                         <a href="{{ url(\'opportunity/\' . $id . \'/edit\' ) }}" title="{{ trans(\'table.edit\') }}">
                                                <i class="fa fa-fw fa-pencil text-warning "></i></a>
                                         <a href="{{ url(\'opportunitycall/\' . $id .\'/\' ) }}" title="{{ trans(\'table.calls\') }}">
                                                <i class="fa fa-phone text-primary"></i><sup>{{ $calls }}</sup> </a>
                                         <a href="{{ url(\'opportunitymeeting/\' . $id .\'/calendar\' ) }}" title="{{ trans(\'table.meeting\') }}">
                                                <i class="fa fa-fw fa-users text-primary"></i> <sup>{{ $meetings }}</sup></a>
                                         <a href="{{ url(\'opportunity/\' . $id .\'/lost\' ) }}" title="{{ trans(\'opportunity.lost\') }}">
                                                <i class="fa fa-fw fa-thumbs-o-down text-danger"></i></a>
                                      @endif
                                       @if(Sentinel::getUser()->hasAccess([\'quotations.write\']) || Sentinel::getUser()->inRole(\'admin\'))
                                       <a href="{{ url(\'opportunity/\' . $id .\'/won\' ) }}" title="{{ trans(\'opportunity.won\') }}">
                                                <i class="fa fa-fw fa-thumbs-o-up text-success"></i></a>
                                       @endif
                                      @if(Sentinel::getUser()->hasAccess([\'opportunities.read\']) || Sentinel::inRole(\'admin\'))
                                     <a href="{{ url(\'opportunity/\' . $id . \'/show\' ) }}" title="{{ trans(\'table.details\') }}" >
                                            <i class="fa fa-fw fa-eye text-primary"></i> </a>
                                    @endif
                                      @if(Sentinel::getUser()->hasAccess([\'opportunities.delete\']) || Sentinel::inRole(\'admin\'))
                                        <a href="{{ url(\'opportunity/\' . $id . \'/delete\' ) }}" title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-times text-danger"></i></a>
                                      @endif')
            ->remove_column('id')
            ->remove_column('calls')
            ->remove_column('meetings')
            ->make();
    }



    private function generateParams()
    {
        $tags = Tag::lists('title', 'id');

        $stages = $this->optionRepository->getAll()
            ->where('category', 'stages')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value'   => $title->value,
                ];
            })->lists('title', 'value')->toArray();

        $priority = $this->optionRepository->getAll()
            ->where('category', 'priority')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value'   => $title->value,
                ];
            })->lists('title', 'value')->toArray();

        $lost_reason = ['' => trans('dashboard.select_lost_reason')] +
            $this->optionRepository->getAll()
                ->where('category', 'lost_reason')
                ->get()
                ->map(function ($title) {
                    return [
                        'title' => $title->title,
                        'value'   => $title->value,
                    ];
                })->lists('title', 'value')->toArray();

        $companies = ['' => trans('dashboard.select_company')] +
            $this->companyRepository->getAll()->orderBy("name", "asc")->lists('name', 'id')->toArray();

        $staffs = ['' => trans('dashboard.select_staff')] +
            $this->userRepository->getStaff()->lists('full_name', 'id')->toArray();

        $salesteams = ['' => trans('dashboard.select_sales_team')] +
            $this->salesTeamRepository->getAllOpportunities()
                ->orderBy("id", "asc")
                ->lists('salesteam', 'id')->toArray();

        view()->share('salesteams', $salesteams);
        view()->share('tags', $tags);
        view()->share('stages', $stages);
        view()->share('priority', $priority);
        view()->share('lost_reason', $lost_reason);
        view()->share('staffs', $staffs);
        view()->share('companies', $companies);
    }

    /**
     * @param Opportunity $opportunity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function convertToQuotation(Opportunity $opportunity)
    {
        $total_fields = Quotation::whereNull('deleted_at')->orWhereNotNull('deleted_at')->orderBy('id', 'desc')->first();
        $quotation_no = Settings::get('quotation_prefix') . (Settings::get('quotation_start_number') + (isset($total_fields) ? $total_fields->id : 0) + 1);
        $exp_date = date(Settings::get('date_format'), strtotime(' + ' . Settings::get('payment_term1') . ' days'));

        Quotation::create(array(
            'quotations_number' => $quotation_no,
            'customer_id' => $opportunity->customer_id,
            'date' => date(Settings::get('date_format')),
            'exp_date' => $exp_date,
            'payment_term' => Settings::get('payment_term1'),
            'sales_person_id' => $opportunity->sales_person_id,
            'sales_team_id' => $opportunity->sales_team_id,
            'status' => 'Draft Quotation',
            'user_id' => Sentinel::getUser()->id
        ));
        $opportunity->update(array('stages' => 'Won'));

        $opportunity->delete();

        return redirect('quotation');

    }
}
