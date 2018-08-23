<?php

namespace App\Http\Controllers\Users;

use App\Helpers\Thumbnail;
use App\Http\Controllers\UserController;
use App\Http\Requests\CompanyRequest;
use App\Models\Call;
use App\Models\City;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Email;
use App\Models\Invoice;
use App\Models\Meeting;
use App\Models\Quotation;
use App\Models\Saleorder;
use App\Models\State;
use App\Repositories\CompanyRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\QuotationRepository;
use App\Repositories\SalesOrderRepository;
use App\Repositories\SalesTeamRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use yajra\Datatables\Datatables;
use Sentinel;
use DB;
use View;

class NotesController extends UserController
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;
    /**
     * @var SalesTeamRepository
     */
    private $salesTeamRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;
    /**
     * @var QuotationRepository
     */
    private $quotationRepository;
    /**
     * @var SalesOrderRepository
     */
    private $salesOrderRepository;

    public function __construct(CompanyRepository $companyRepository,
                                SalesTeamRepository $salesTeamRepository,
                                UserRepository $userRepository,
                                InvoiceRepository $invoiceRepository,
                                QuotationRepository $quotationRepository,
                                SalesOrderRepository $salesOrderRepository)
    {
        parent::__construct();

        $this->middleware('authorized:contacts.read', ['only' => ['index', 'data']]);
        $this->middleware('authorized:contacts.write', ['only' => ['create', 'store', 'update', 'edit']]);
        $this->middleware('authorized:contacts.delete', ['only' => ['delete']]);

        $this->companyRepository = $companyRepository;
        $this->salesTeamRepository = $salesTeamRepository;
        $this->userRepository = $userRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->quotationRepository = $quotationRepository;
        $this->salesOrderRepository = $salesOrderRepository;

        view()->share('type', 'notes');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$title = trans('Notes');
		$getNotes = DB::table('notes')->get();
        return view('user.notes.index', compact('title','getNotes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
    public function create()
    {
        $title = trans('Notes New');

        return view('user.notes.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
   
    public function store()
    {
		DB::table('notes')->insert([
									['title' => $_REQUEST['name'],
									 'content' => $_REQUEST['content'],
									 'date' => $_REQUEST['date'],
									 ]
								]);
								
       
        return redirect("notes");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
	
    public function edit($id)
    {
		$rPorjects = DB::table('notes')->where('note_id','=',$id)->get();
		$id = $rPorjects[0]->note_id;
		$name = $rPorjects[0]->title;
		$content = $rPorjects[0]->content;
		$date = $rPorjects[0]->date;


		$title = trans('Note Edit');

        return view('user.running_projects.edit', compact('title', 'id', 'name', 'content', 'date'));
    }
 /*#####################################################################################################################
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
	 
    public function update($id)
    {
		DB::table('notes')
            ->where('note_id', $id)
            ->update(array('title' => $_REQUEST['name'],
							'content' => $_REQUEST['content'],
							));
		
        return redirect("notes");
    }
/*#####################################################################################################################
    public function show(Company $company)
    {
        $title = trans('company.details');
        $action = 'show';

        $open_invoices = round($this->invoiceRepository->getAllOpenForCustomer($company->id)->sum('unpaid_amount'), 3);
        $overdue_invoices = round($this->invoiceRepository->getAllOverdueForCustomer($company->id)->sum('unpaid_amount'), 3);
        $paid_invoices = round($this->invoiceRepository->getAllPaidForCustomer($company->id)->sum('grand_total'), 3);
        $total_sales = round($this->invoiceRepository->getAllForCustomer($company->id)->sum('unpaid_amount'), 3);

        $quotations_total =  round($this->quotationRepository->getAllForCustomer($company->id)
            ->get()->sum('grand_total'), 3);

        $salesorder =  round($this->salesOrderRepository->getAllForCustomer($company->id)
            ->get()->sum('grand_total'), 3);

        $invoices =  $this->invoiceRepository->getAllOpenForCustomer($company->id)->count();


        $quotations =  $this->quotationRepository->getAllForCustomer($company->id)
            ->get()->count();

        $calls = Call::where('company_id',$company->id)->count();

        $meetings_res = Meeting::get();
        $meeting=0;

        foreach( $meetings_res as $meetings)
        {
            $b=explode(',',$meetings->attendees);
            if(in_array($company->id,$b))
            {
                $meeting++;
            }
        }

        $emails = Email::where('assign_customer_id',$company->id)->count();

        $contracts = Contract::where('company_id',$company->id)->count();


        return view('user.company.delete', compact('title', 'company','action','total_sales','open_invoices','paid_invoices',
            'quotations_total','salesorder','quotations','invoices','calls','meeting','emails','contracts','overdue_invoices'));
    }
*/
    public function delete($id)
    {
        DB::table('notes')->where('note_id', '=', $id)->delete();
		return redirect("notes");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
	 /*#####################################################################################################################
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect('company');
    }*/

   /* public function data()
    {
        $company = $this->companyRepository->getAll()
            ->with('contactPerson')
            ->get()
            ->map(function ($comp) {
            return [
                'id' => $comp->id,
                'name' => $comp->name,
                'customer' => isset($comp->contactPerson) ?$comp->contactPerson->full_name : '--',
                'phone' => $comp->phone,
				'email' => $comp->email,
				'website' => $comp->website,
				'tag' => 'test',
            ];
        });

        return Datatables::of($company)

            ->add_column('actions', '@if(Sentinel::getUser()->hasAccess([\'contacts.write\']) || Sentinel::inRole(\'admin\'))
                                    <a href="{{ url(\'company/\' . $id . \'/edit\' ) }}" title="{{ trans(\'table.edit\') }}">
                                            <i class="fa fa-fw fa-pencil text-warning "></i> </a>
                                    @endif
                                    <a href="{{ url(\'company/\' . $id . \'/show\' ) }}" title="{{ trans(\'table.details\') }}" >
                                            <i class="fa fa-fw fa-eye text-primary"></i> </a>
                                    @if(Sentinel::getUser()->hasAccess([\'contacts.delete\']) || Sentinel::inRole(\'admin\'))
                                    <a href="{{ url(\'company/\' . $id . \'/delete\' ) }}"  title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-times text-danger"></i> </a>
                                       @endif')

            ->remove_column('id')
            ->make();
    }*/

   /* private function generateParams()
    {
       /* $countries = ['' => trans('company.select_country')] + Country::orderBy("name", "asc")->lists('name', 'id')->toArray();
        $salesteams = ['' => trans('dashboard.select_sales_team')] + $this->salesTeamRepository->getAll()->lists('salesteam', 'id')->toArray();*/
        /*$customers = ['' => trans('dashboard.select_customer')] +
            $this->userRepository->getCustomers()->lists('full_name', 'id')->toArray();
		$rp = DB::table('running_projects')->select('*')->get();
        view()->share('allProjects', $rp);
        view()->share('customers', $customers);*/
        //view()->share('countries', $countries);
   /* }*/
    /**
     * @param $file
     */
	 /*#####################################################################################################################
    private function generateThumbnail($file)
    {
        Thumbnail::generate_image_thumbnail(public_path() . '/uploads/company/' . $file->getFileInfo()->getFilename(),
            public_path() . '/uploads/company/' . 'thumb_' . $file->getFileInfo()->getFilename());
    }*/

}