<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\UserController;
use App\Http\Requests\CallRequest;
use App\Models\Call;
use App\Models\Company;
use App\Models\Opportunity;
use App\Models\User;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use Sentinel;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use yajra\Datatables\Datatables;

class OpportunityCallController extends UserController
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(CompanyRepository $companyRepository,
                                UserRepository $userRepository)
    {
        parent::__construct();

        $this->companyRepository = $companyRepository;
        $this->userRepository = $userRepository;

        view()->share('type', 'opportunitycall');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Opportunity $opportunity
     * @return \Illuminate\Http\Response
     */
    public function index(Opportunity $opportunity)
    {
        $title = trans('call.opportunity_calls');
        return view('user.opportunitycall.index', compact('title', 'opportunity'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Opportunity $opportunity)
    {
        $title = trans('call.opportunity_new');

        $this->generateParams();

        return view('user.opportunitycall.create', compact('title', 'opportunity'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Opportunity $opportunity
     * @param CallRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Opportunity $opportunity, CallRequest $request)
    {
        $opportunity->calls()->create($request->all(), ['user_id' => $this->user->id]);
        return redirect("opportunitycall/" . $opportunity->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Opportunity $opportunity , Call $call
     * @return \Illuminate\Http\Response
     */
    public function edit(Opportunity $opportunity, Call $call)
    {
        $title = trans('call.opportunity_edit');

        $this->generateParams();

        return view('user.opportunitycall.create', compact('title', 'call', 'opportunity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CallRequest|Request $request
     * @param Opportunity $opportunity
     * @param  Call $call
     * @return \Illuminate\Http\Response
     */
    public function update(CallRequest $request, Opportunity $opportunity, Call $call)
    {
        $call->update($request->all());

        return redirect("opportunitycall/" . $opportunity->id);
    }


    public function delete(Opportunity $opportunity, Call $call)
    {
        $title = trans('call.opportunity_delete');
        return view('user.opportunitycall.delete', compact('title', 'call', 'opportunity'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Opportunity $opportunity , Call $call
     * @return \Illuminate\Http\Response
     */
    public function destroy(Opportunity $opportunity, Call $call)
    {
        $call->delete();
        return redirect('opportunitycall/' . $opportunity->id);
    }

    public function data(Opportunity $opportunity)
    {
        $calls = $opportunity->calls()
            ->with('responsible', 'company')
            ->get()
            ->map(function ($call) use ($opportunity) {
                return [
                    'id' => $call->id,
                    'date' => $call->date,
                    'call_summary' => $call->call_summary,
                    'company' => isset($call->company) ?$call->company->name : '',
                    'call_type_id' => $opportunity->id,
                    'responsible' => isset($call->responsible->full_name) ?$call->responsible->full_name : '',
                ];
            });
        return Datatables::of($calls)
            ->add_column('actions', '<a href="{{ url(\'opportunitycall/\' . $call_type_id . \'/\' . $id . \'/edit\' ) }}" title="{{ trans(\'table.edit\') }}">
                                            <i class="fa fa-fw fa-pencil text-warning"></i>  </a>
                                     <a href="{{ url(\'opportunitycall/\' . $call_type_id . \'/\' . $id . \'/delete\' ) }}"  title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-times text-danger"></i> </a>')
            ->remove_column('id')
            ->remove_column('call_type_id')
            ->make();
    }

    private function generateParams()
    {
        $companies = ['' => trans('dashboard.select_company')] +
            $this->companyRepository->getAll()->orderBy("name", "asc")->lists('name', 'id')->toArray();

        $staffs = ['' => trans('dashboard.select_staff')] +
            $this->userRepository->getStaff()->lists('full_name', 'id')->toArray();

        view()->share('staffs', $staffs);
        view()->share('companies', $companies);
    }

}
