<?php

namespace App\Http\Controllers\Users;

use App\Helpers\ExcelfileValidator  ;
use App\Http\Controllers\UserController;
use App\Http\Requests;
use App\Http\Requests\LeadImportRequest;
use App\Http\Requests\LeadRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Lead;
use App\Models\Option;
use App\Models\State;
use App\Models\Tag;
use App\Repositories\CompanyRepository;
use App\Repositories\LeadRepository;
use App\Repositories\OptionRepository;
use App\Repositories\SalesTeamRepository;
use App\Repositories\UserRepository;
use App\Repositories\ExcelRepository;
use Illuminate\Http\Request;
use Sentinel;
use yajra\Datatables\Datatables;


class LeadController extends UserController
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
     * @var LeadRepository
     */
    private $leadRepository;
    /**
     * @var SalesTeamRepository
     */
    private $salesTeamRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;
    
    /**
     * @var ExcelRepository
     */
    private $excelRepository;

    /**
     * SalesTeamController constructor.
     * @param CompanyRepository $companyRepository
     * @param UserRepository $userRepository
     * @param LeadRepository $leadRepository
     * @param SalesTeamRepository $salesTeamRepository
     * @param OptionRepository $optionRepository
     */
    public function __construct(CompanyRepository $companyRepository,
                                UserRepository $userRepository,
                                LeadRepository $leadRepository,
                                SalesTeamRepository $salesTeamRepository,
                                OptionRepository $optionRepository,
                                ExcelRepository $excelRepository)
    {
        $this->middleware('authorized:leads.read', ['only' => ['index', 'data']]);
        $this->middleware('authorized:leads.write', ['only' => ['create', 'store', 'update', 'edit']]);
        $this->middleware('authorized:leads.delete', ['only' => ['delete']]);

        parent::__construct();

        $this->companyRepository = $companyRepository;
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
        $this->leadRepository = $leadRepository;
        $this->salesTeamRepository = $salesTeamRepository;
        $this->optionRepository = $optionRepository;
        $this->excelRepository = $excelRepository;

        view()->share('type', 'lead');
    }

    public function index()
    {
        $title = trans('lead.leads');
        return view('user.lead.index', compact('title'));
    }

    public function create()
    {
        $title = trans('lead.new');
        $calls = 0;

        $this->generateParams();

        return view('user.lead.create', compact('title', 'calls'));
    }

    public function store(LeadRequest $request)
    {
        $this->leadRepository->store($request->all());
        return redirect("lead");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Lead $lead)
    {
        $title = trans('lead.edit');

        $this->generateParams();

        $calls = $lead->calls()->count();
        $states = State::where('country_id', $lead->country_id)->orderBy("name", "asc")->lists('name', 'id')->toArray();
        $cities = City::where('state_id', $lead->state_id)->orderBy("name", "asc")->lists('name', 'id')->toArray();

        return view('user.lead.edit', compact('lead', 'title', 'calls', 'states', 'cities'));
    }

    public function update(Lead $lead, LeadRequest $request)
    {
        $lead->update($request->all());

        return redirect("lead");
    }

    public function show(Lead $lead)
    {
        $title = trans('lead.show');
        $action = "show";
        $this->generateParams();
        return view('user.lead.show', compact('title', 'lead','action'));
    }

    public function delete(Lead $lead)
    {
        $title = trans('lead.delete');
        $this->generateParams();
        return view('user.lead.delete', compact('title', 'lead'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect('lead');
    }

    public function data()
    {
        $leads = $this->leadRepository->getAll()
            ->with('country', 'salesTeam')
            ->get()
            ->map(function ($lead) {
                return [
                    'id' => $lead->id,
                    'created_at' => $lead->created_at,
                    'opportunity' => $lead->opportunity,
                    'contact_name' => $lead->contact_name,
                    'country' => isset($lead->country) ? $lead->country->name : '',
                    'email' => $lead->email,
                    'phone' => $lead->phone,
                    'salesteam' => isset($lead->salesTeam) ? $lead->salesTeam->salesteam : '',
                    'calls' => $lead->calls->count()
                ];
            });
        return Datatables::of($leads)
            ->edit_column('created_at', '{{ $created_at->format("d.m.Y")}}')
            ->add_column('actions', '@if(Sentinel::getUser()->hasAccess([\'leads.write\']) || Sentinel::inRole(\'admin\'))
                                        <a href="{{ url(\'lead/\' . $id . \'/edit\' ) }}" title="{{ trans(\'table.edit\') }}">
                                            <i class="fa fa-fw fa-pencil text-warning"></i> </a>
                                        <a href="{{ url(\'leadcall/\'. $id .\'/\' ) }}" title="{{ trans(\'table.calls\') }}">
                                            <i class="fa fa-fw fa-phone text-primary"></i> <sup>{{ $calls }}</sup></a>
                                    @endif
                                     @if(Sentinel::getUser()->hasAccess([\'leads.read\']) || Sentinel::inRole(\'admin\'))
                                     <a href="{{ url(\'lead/\' . $id . \'/show\' ) }}" title="{{ trans(\'table.details\') }}" >
                                            <i class="fa fa-fw fa-eye text-primary"></i> </a>
                                    @endif
                                    @if(Sentinel::getUser()->hasAccess([\'leads.delete\']) || Sentinel::inRole(\'admin\'))
                                     <a href="{{ url(\'lead/\' . $id . \'/delete\' ) }}" title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-times text-danger"></i> </a>
                                    @endif')
            ->remove_column('id')
            ->remove_column('calls')
            ->make();
    }

    public function ajaxStateList(Request $request)
    {
        return ['' => trans('lead.select_state')] + State::where('country_id', $request->id)->orderBy("name", "asc")->lists('name', 'id')->toArray();
    }

    public function ajaxCityList(Request $request)
    {
        return ['' => trans('lead.select_city')] + City::where('state_id', $request->id)->orderBy("name", "asc")->lists('name', 'id')->toArray();
    }

    private function generateParams()
    {
        $tags = Tag::lists('title', 'id');

        $priority = $this->optionRepository->getAll()
            ->where('category', 'priority')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value'   => $title->value,
                ];
            })->lists('title', 'value')->toArray();

        $titles = $this->optionRepository->getAll()
            ->where('category', 'titles')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value'   => $title->value,
                ];
            })->lists('title', 'value')->toArray();

        $companies = ['' => trans('dashboard.select_company')] +
            $this->companyRepository->getAll()->orderBy("name", "asc")->lists('name', 'id')->toArray();

        $countries = ['' => trans('lead.select_country')] + Country::orderBy("name", "asc")->lists('name', 'id')->toArray();

        $staffs = ['' => trans('dashboard.select_staff')] +
            $this->userRepository->getStaff()->lists('full_name', 'id')->toArray();

        $salesteams = ['' => trans('dashboard.select_sales_team')] +
            $this->salesTeamRepository->getAllLeads()
                ->orderBy("id", "asc")
                ->lists('salesteam', 'id')->toArray();

        view()->share('tags', $tags);
        view()->share('priority', $priority);
        view()->share('titles', $titles);
        view()->share('companies', $companies);
        view()->share('countries', $countries);
        view()->share('staffs', $staffs);
        view()->share('salesteams', $salesteams);
    }
    
      public function downloadExcelTemplate()
    {
        return response()->download(base_path('resources/excel-templates/leads.xlsx'));
    }
    
     public function getImport()
    {
        $title = trans('lead.newupload');
     //  return 'jimmy';
      return view('user.lead.import', compact('title'));
    }
    
     public function postImport(Request $request)
    {
        
        
        ExcelfileValidator::validate($request);

        $reader = $this->excelRepository->load($request->file('file'));

        $customers = $reader->all()->map(function ($row) {
            return [
                'opportunity'            => $row->opportunity,
                'company_name'             => $row->company,
                'address'                 => $row->address,
                'contact_name'              => $row->names,
                'email'                    =>  $row->email,
                'function'                => $row->functions,
                'phone'               => $row->phone,
                'mobile'               => $row->mobile,
                'fax'               => $row->fax,
                'internal_notes'               => $row->notes,
            ];
        });

        $companies = $this->companyRepository->getAll()->get()->map(function ($company) {
            return [
                'text' => $company->name,
                'id'   => $company->id,
            ];
        })->values();
        
       $countries1 = Country::orderBy("name", "asc")->lists('name', 'id')->toArray() ;
       
       $countries  = array() ;
       
       foreach($countries1 as $c => $v){
		   
		   $countries[] = array(
		      'id' =>  $c ,
		      'text' => $v ,
		   ); 
		   
	    }
	    
	  $salesteams1 = $this->salesTeamRepository->getAllLeads()
                ->orderBy("id", "asc")
                ->lists('salesteam', 'id')->toArray();
       
        $salesteams  = array() ;
             
       foreach($salesteams1 as $sc => $sv){
		   
		   $salesteams[] = array(
		      'id' =>  $sc ,
		      'text' => $sv ,
		   ); 
		   
	    }

        return response()->json(compact('customers', 'companies' , 'countries' ,'salesteams'), 200);
    }

    public function postAjaxStore(LeadImportRequest $request)
    {
        $this->leadRepository->store($request->except('created', 'errors', 'selected'));

        return response()->json([], 200);
    }
    
    public function importExcelData(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx,xls,csv|max:5000',
        ]);

        $reader = $this->excelRepository->load($request->file('file'));
//~ 
        //~ $users = $reader->all()->map(function ($row) {
            //~ return [
                //~ 'email'      => $row->email,
                //~ 'password'   => $row->password,
                //~ 'first_name' => $row->first_name,
                //~ 'last_name'  => $row->last_name,
                //~ 'mobile'     => $row->mobile,
                //~ 'fax'        => $row->fax,
                //~ 'website'    => $row->website,
            //~ ];
        //~ });
//~ 
        //~ foreach ($users as $userData) {
            //~ if (!$customer = \App\Models\User::whereEmail($userData['email'])->first()) {
                //~ $customer = $this->userRepository->create($userData);
//~ 
                //~ $customer->customer()->create($userData);
                //~ $this->userRepository->assignRole($customer, 'customer');
            //~ }
        //~ }
//~ 
        //~ return response()->json([], 200);
    }


}
