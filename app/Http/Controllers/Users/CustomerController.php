<?php

namespace App\Http\Controllers\Users;

use App\Helpers\Thumbnail;
use App\Helpers\ExcelfileValidator  ;
use App\Http\Controllers\UserController;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\User;
use App\Repositories\CompanyRepository;
use App\Repositories\ExcelRepository;
use App\Repositories\OptionRepository;
use App\Repositories\SalesTeamRepository;
use App\Repositories\UserRepository;
use Efriandika\LaravelSettings\Facades\Settings;
use Sentinel;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use DB;

class CustomerController extends UserController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var CompanyRepository
     */
    private $companyRepository;
    /**
     * @var SalesTeamRepository
     */
    private $salesTeamRepository;
    /**
     * @var ExcelRepository
     */
    private $excelRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;

    /**
     * CustomerController constructor.
     * @param UserRepository $userRepository
     * @param CompanyRepository $companyRepository
     * @param SalesTeamRepository $salesTeamRepository
     * @param ExcelRepository $excelRepository
     * @param OptionRepository $optionRepository
     */
    public function __construct(UserRepository $userRepository,
                                CompanyRepository $companyRepository,
                                SalesTeamRepository $salesTeamRepository,
                                ExcelRepository $excelRepository,
                                OptionRepository $optionRepository)
    {
        parent::__construct();

        $this->middleware('authorized:contacts.read', ['only' => ['index', 'data']]);
        $this->middleware('authorized:contacts.write', ['only' => ['create', 'store', 'update', 'edit']]);
        $this->middleware('authorized:contacts.delete', ['only' => ['delete']]);

        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
        $this->salesTeamRepository = $salesTeamRepository;
        $this->excelRepository = $excelRepository;
        $this->optionRepository = $optionRepository;

        view()->share('type', 'customer');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('customer.customers');

        $companies = $this->companyRepository->getAll()
            ->orderBy("name", "asc")
            ->get()
            ->map(function ($c) {
                return [
                    'text' => $c->name,
                    'id'   => $c->id,
                ];
            })->values();

        $customers = $this->userRepository->getAll()
            ->with('customer.company')
            ->get()
            ->filter(function ($user) {
                return $user->inRole('customer', 'companies');
            });

        return view('user.customer.index', compact('title', 'companies', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		
        $title = trans('customer.new');

        $this->generateParams();

        return view('user.customer.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
		
        $user = Sentinel::registerAndActivate($request->only('first_name', 'last_name', 'phone_number', 'email', 'password'));

        $role = Sentinel::findRoleBySlug('customer');
        $role->users()->attach($user);

        $user = User::find($user->id);

        if ($request->hasFile('user_avatar_file')) {
            $file = $request->file('user_avatar_file');
            $file = $this->userRepository->uploadAvatar($file);

            $request->merge([
                'user_avatar' => $file->getFileInfo()->getFilename(),
            ]);

            $this->generateThumbnail($file);

            $user->user_avatar = $request->user_avatar;
        }
        $user->phone_number = $request->phone_number;
        $user->password = bcrypt($request->password);
        $user->save();

        $customer = new Customer($request->except('first_name', 'last_name', 'phone_number', 'email', 'password','language',
            'user_avatar', 'password_confirmation', 'user_avatar_file'));
        $customer->user_id = $user->id;
        $customer->belong_user_id = Sentinel::getUser()->id;
		$customer->language = $request->language;
        $customer->save();

        $subject = 'Customer login details';

        $currentUser = Sentinel::getUser();
        $currentUser->users()->save($user);

        if (!filter_var(Settings::get('site_email'), FILTER_VALIDATE_EMAIL) === false) {
            Mail::send('emails.new_customer', array('email' => $request->email, 'password' => $request->password), function ($m) use ($request, $subject) {
                $m->from(Settings::get('site_email'), Settings::get('site_name'));
                $m->to($request->email, $request->first_name . $request->last_name);
                $m->subject($subject);
            });
        }

        return redirect("customer");
    }

    public function ajaxUpdate(Request $request, User $user)
    {
		//print_r($request->customer->language);
		//print_r($_REQUEST);
		//die;
        $this->validate($request, [
            'first_name'             => 'required|alpha',
            'last_name'              => 'required|alpha',
            'email'                  => 'required|email||unique:users,email,' . $user->id,
            'phone_number'        => 'required|numeric',
            'fax'        => 'numeric',
            'mobile'        => 'numeric',
            'website'       => 'url',
            'sales_team_id' => 'required',
            'company_id' => 'required',
            'title' => 'required',
        ]);

        $user->update($request->only('first_name', 'last_name', 'email','phone_number'));

        $customerData = $request->except('first_name', 'last_name', 'email','phone_number');
		//print_r($customerData['id']);die;
        $user->customer->fill($customerData);
        $user->customer->company()->associate($customerData['company_id']);
        $user->customer->salesteam()->associate($customerData['sales_team_id']);
		//$user->customer = $customerData['language'];
        $user->customer->save();
		DB::table('customers')
            ->where('user_id', $customerData['id'])
            ->update(['language' => $customerData['language']]);

        //$user->load('customer.company', 'customer.salesteam');

        return response()->json(['message' => 'Updated successfully!', 'data' => compact('user')], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect('customer');
    }

    public function data()
    {
        $customers = $this->userRepository->getAll()
            ->with('customer.company', 'customer.salesteam')
            ->get()
            ->filter(function ($user) {
                return $user->inRole('customer');
            })
            ->map(function ($user) {
                return [
                    'full_name' => $user->full_name,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'phone_number' => $user->phone_number,
					'language' => $user->customer->language,
                    'email' => $user->email,
                    'mobile' => $user->customer->mobile,
                    'fax' => $user->customer->fax,
                    'website' => $user->customer->website,
                    'avatar'=> $user->avatar,
                    'title'=> $user->customer->title,
                    'job_position'=> $user->customer->job_position,
                    'id' => $user->id,
                    'company_id' => isset($user->customer->company_id)?$user->customer->company_id:0,
                    'sales_team_id' => isset($user->customer->sales_team_id)?$user->customer->sales_team_id:0,
                    'company' => isset($user->customer->company->name)?$user->customer->company->name:"",
                    'salesteam' => isset($user->customer->salesteam->salesteam)?$user->customer->salesteam->salesteam:"",
                ];
            })->values();

        $companies = $this->companyRepository->getAll()
            ->orderBy("name", "asc")
            ->get()
            ->map(function ($company) {
                return [
                    'text' => $company->name,
                    'id'   => $company->id,
                ];
            })->values();

        $salesTeams = $this->salesTeamRepository->getAll()
            ->orderBy("id", "asc")
            ->get()
            ->map(function ($salesTeam) {
                return [
                    'text' => $salesTeam->salesteam,
                    'id'   => $salesTeam->id,
                ];
            })->values();

        $titles = $this->optionRepository->getAll()
            ->where('category', 'titles')
            ->get()
            ->map(function ($title) {
                return [
                    'text' => $title->title,
                    'id'   => $title->value,
                ];
            })->values();
        $can_write = (Sentinel::getUser()->hasAccess(['contacts.write']) || Sentinel::inRole('admin'))?true:false;
        $can_delete = (Sentinel::getUser()->hasAccess(['contacts.delete']) || Sentinel::inRole('admin'))?true:false;

        return response()->json(compact('customers', 'companies', 'salesTeams', 'titles','can_write','can_delete'), 200);
    }

    public function importExcelData(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx,xls,csv|max:5000',
        ]);

        $reader = $this->excelRepository->load($request->file('file'));

        $users = $reader->all()->map(function ($row) {
            return [
                'email'      => $row->email,
                'password'   => $row->password,
                'first_name' => $row->first_name,
                'last_name'  => $row->last_name,
                'mobile'     => $row->mobile,
                'fax'        => $row->fax,
                'website'    => $row->website,
            ];
        });

        foreach ($users as $userData) {
            if (!$customer = \App\Models\User::whereEmail($userData['email'])->first()) {
                $customer = $this->userRepository->create($userData);

                $customer->customer()->create($userData);
                $this->userRepository->assignRole($customer, 'customer');
            }
        }

        return response()->json([], 200);
    }

    public function downloadExcelTemplate()
    {
        return response()->download(base_path('resources/excel-templates/contacts.xlsx'));
    }

    private function generateParams()
    {
        $salesteams = ['' => trans('dashboard.select_sales_team')] + $this->salesTeamRepository->getAll()->orderBy("id", "asc")->lists('salesteam', 'id')->toArray();
        $companies = ['' => trans('dashboard.select_company')] + $this->companyRepository->getAll()->orderBy("name", "asc")->lists('name', 'id')->toArray();
        $titles = $this->optionRepository->getAll()
            ->where('category', 'titles')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value'   => $title->value,
                ];
            })->lists('title', 'value')->toArray();

        view()->share('salesteams', $salesteams);
        view()->share('companies', $companies);
        view()->share('titles', $titles);
    }


    public function getImport()
    {
        $title = trans('customer.customers');

        return view('user.customer.import', compact('title'));
    }

    public function postImport(Request $request)
    {
        //~ $this->validate($request, [
            //~ 'file' => 'required|mimes:xlsx,xls,csv|max:5000',
        //~ ]);
        
       ExcelfileValidator::validate($request);
       
        $reader = $this->excelRepository->load($request->file('file'));

        $customers = $reader->all()->map(function ($row) {
            return [
                'first_name'            => $row->first_name,
                'last_name'             => $row->last_name,
                'email'                 => $row->email,
                'password'              => $row->password,
                'password_confirmation' => $row->password,
                'mobile'                => $row->mobile,
                'webstie'               => $row->website,
            ];
        });

        $companies = $this->companyRepository->getAll()->get()->map(function ($company) {
            return [
                'text' => $company->name,
                'id'   => $company->id,
            ];
        })->values();

        return response()->json(compact('customers', 'companies'), 200);
    }

    public function postAjaxStore(CustomerRequest $request)
    {
        $this->userRepository->create($request->except('created', 'errors', 'selected'));

        return response()->json([], 200);
    }

    /**
     * @param $file
     */
    private function generateThumbnail($file)
    {
        Thumbnail::generate_image_thumbnail(public_path() . '/uploads/avatar/' . $file->getFileInfo()->getFilename(),
            public_path() . '/uploads/avatar/' . 'thumb_' . $file->getFileInfo()->getFilename());
    }
}
