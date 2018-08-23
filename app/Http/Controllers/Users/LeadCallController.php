<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\UserController;
use App\Http\Requests\CallRequest;
use App\Models\Call;
use App\Models\Company;
use App\Models\Lead;
use App\Models\User;
use App\Repositories\CallRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use Sentinel;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use yajra\Datatables\Datatables;

class LeadCallController extends UserController
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var CallRepository
     */
    private $callRepository;

    /**
     * LeadCallController constructor.
     * @param CompanyRepository $companyRepository
     * @param UserRepository $userRepository
     * @param CallRepository $callRepository
     */
    public function __construct(CompanyRepository $companyRepository,
                                UserRepository $userRepository,
                                CallRepository $callRepository)
    {
        parent::__construct();

        $this->companyRepository = $companyRepository;
        $this->userRepository = $userRepository;
        $this->callRepository = $callRepository;

        view()->share('type', 'leadcall');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function index(Lead $lead)
    {
        $title = trans('call.lead_calls');
        return view('user.leadcall.index', compact('title', 'lead'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Lead $lead)
    {
        $title = trans('call.lead_new');

        $this->generateParams();

        return view('user.leadcall.create', compact('title', 'lead'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Lead $lead
     * @param CallRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Lead $lead, CallRequest $request)
    {
        $lead->calls()->create($request->all(), ['user_id' => $this->user->id]);

        return redirect("leadcall/" . $lead->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Lead $lead , Call $call
     * @return \Illuminate\Http\Response
     */
    public function edit(Lead $lead, Call $call)
    {
        $title = trans('call.lead_edit');

        $this->generateParams();

        return view('user.leadcall.create', compact('title', 'call', 'lead'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CallRequest|Request $request
     * @param Lead $lead
     * @param  Call $call
     * @return \Illuminate\Http\Response
     */
    public function update(CallRequest $request, Lead $lead, Call $call)
    {
        $call->update($request->all());

        return redirect("leadcall/" . $lead->id);
    }


    public function delete(Lead $lead, Call $call)
    {
        $title = trans('call.lead_delete');
        return view('user.leadcall.delete', compact('title', 'call', 'lead'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Lead $lead , Call $call
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lead $lead, Call $call)
    {
        $call->delete();
        return redirect('leadcall/' . $lead->id);
    }

    public function data(Lead $lead)
    {
        $calls = $lead->calls()
            ->with('responsible', 'company')
            ->get()
            ->map(function ($call) use ($lead) {
                return [
                    'id' => $call->id,
                    'date' => $call->date,
                    'call_summary' => $call->call_summary,
                    'company' => isset($call->company) ? $call->company->name : '',
                    'lead' => $lead->id,
                    'responsible' => isset($call->responsible) ? $call->responsible->full_name : '',
                ];
            });

        return Datatables::of($calls)
            ->add_column('actions', '<a href="{{ url(\'leadcall/\' . $lead . \'/\' . $id . \'/edit\' ) }}"  title="{{ trans(\'table.edit\') }}">
                                            <i class="fa fa-fw fa-pencil text-warning"></i>  </a>
                                     <a href="{{ url(\'leadcall/\' . $lead . \'/\' . $id . \'/delete\' ) }}"  title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-times text-danger"></i> </a>')
            ->remove_column('id')
            ->remove_column('lead')
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
