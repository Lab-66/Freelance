<?php

namespace App\Http\Controllers\Users;

use App\Helpers\Common;
use App\Http\Controllers\UserController;
use App\Http\Requests\QuotationMailRequest;
use App\Http\Requests\QuotationRequest;
use App\Models\Company;
use App\Models\Email;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Option;
use App\Models\Qtemplate;
use App\Models\QtemplateProduct;
use App\Models\Quotation;
use App\Models\QuotationProduct;
use App\Models\Saleorder;
use App\Models\SaleorderProduct;
use App\Repositories\CompanyRepository;
use App\Repositories\OptionRepository;
use App\Repositories\ProductRepository;
use App\Repositories\QuotationRepository;
use App\Repositories\QuotationTemplateRepository;
use App\Repositories\SalesTeamRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Efriandika\LaravelSettings\Facades\Settings;
use Sentinel;
use Illuminate\Http\Request;
use App\Http\Requests;
use yajra\Datatables\Datatables;

class QuotationController extends UserController
{
    /**
     * @var QuotationRepository
     */
    private $quotationRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var SalesTeamRepository
     */
    private $salesTeamRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var CompanyRepository
     */
    private $companyRepository;
    /**
     * @var QuotationTemplateRepository
     */
    private $quotationTemplateRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;

    /**
     * QuotationController constructor.
     * @param QuotationRepository $quotationRepository
     * @param UserRepository $userRepository
     * @param SalesTeamRepository $salesTeamRepository
     * @param ProductRepository $productRepository
     * @param CompanyRepository $companyRepository
     * @param QuotationTemplateRepository $quotationTemplateRepository
     * @param OptionRepository $optionRepository
     */
    public function __construct(QuotationRepository $quotationRepository,
                                UserRepository $userRepository,
                                SalesTeamRepository $salesTeamRepository,
                                ProductRepository $productRepository,
                                CompanyRepository $companyRepository,
                                QuotationTemplateRepository $quotationTemplateRepository,
                                OptionRepository $optionRepository)
    {
        parent::__construct();

        $this->middleware('authorized:quotations.read', ['only' => ['index', 'data']]);
        $this->middleware('authorized:quotations.write', ['only' => ['create', 'store', 'update', 'edit']]);
        $this->middleware('authorized:quotations.delete', ['only' => ['delete']]);

        $this->quotationRepository = $quotationRepository;
        $this->userRepository = $userRepository;
        $this->salesTeamRepository = $salesTeamRepository;
        $this->productRepository = $productRepository;
        $this->companyRepository = $companyRepository;
        $this->quotationTemplateRepository = $quotationTemplateRepository;
        $this->optionRepository = $optionRepository;

        view()->share('type', 'quotation');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('quotation.quotations');
        return view('user.quotation.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('quotation.new');

        $this->generateParams();

        return view('user.quotation.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuotationRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuotationRequest $request)
    {
        $total_fields = Quotation::whereNull('deleted_at')->orWhereNotNull('deleted_at')->orderBy('id', 'desc')->first();
        $quotation_no = Settings::get('quotation_prefix') . (Settings::get('quotation_start_number') + (isset($total_fields) ? $total_fields->id : 0) + 1);
        $exp_date = date(Settings::get('date_format'), strtotime(' + ' . isset($request->payment_term) ? $request->payment_term : Settings::get('opportunities_reminder_days') . ' days'));


        $quotation = new Quotation($request->only('customer_id', 'qtemplate_id', 'date',
            'exp_date', 'payment_term', 'sales_person_id', 'sales_team_id', 'terms_and_conditions', 'status', 'total',
            'tax_amount', 'grand_total','discount','final_price'));
        $quotation->quotations_number = $quotation_no;
        $quotation->exp_date = isset($request->exp_date) ? $request->exp_date : strtotime($exp_date);
        $quotation->user_id = Sentinel::getUser()->id;
        $quotation->save();

        if (!empty($request->product_id)) {
            foreach ($request->product_id as $key => $item) {
                if ($item != "" && $request->product_name[$key] != "" &&
                    $request->quantity[$key] != "" && $request->price[$key] != "" && $request->sub_total[$key] != ""
                ) {
                    $quotationProduct = new QuotationProduct();
                    $quotationProduct->quotation_id = $quotation->id;
                    $quotationProduct->product_id = $item;
                    $quotationProduct->product_name = $request->product_name[$key];
                    $quotationProduct->description = $request->description[$key];
                    $quotationProduct->quantity = $request->quantity[$key];
                    $quotationProduct->price = $request->price[$key];
                    $quotationProduct->sub_total = $request->sub_total[$key];
                    $quotationProduct->save();
                }
            }
        }
        return redirect("quotation");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Quotation $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit(Quotation $quotation)
    {
        $title = trans('quotation.edit');

        $this->generateParams();

        return view('user.quotation.edit', compact('title', 'quotation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param QuotationRequest|Request $request
     * @param Quotation $quotation
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(QuotationRequest $request, Quotation $quotation)
    {
        $quotation->update($request->only('customer_id', 'qtemplate_id', 'date',
            'exp_date', 'payment_term', 'sales_person_id', 'sales_team_id', 'terms_and_conditions', 'status', 'total',
            'tax_amount', 'grand_total','discount','final_price'));

        QuotationProduct::where('quotation_id', $quotation->id)->delete();
        if (!empty($request->product_id)) {
            foreach ($request->product_id as $key => $item) {
                if ($item != "" && $request->product_name[$key] != "" &&
                    $request->quantity[$key] != "" && $request->price[$key] != "" && $request->sub_total[$key] != ""
                ) {
                    $quotationProduct = new QuotationProduct();
                    $quotationProduct->quotation_id = $quotation->id;
                    $quotationProduct->product_id = $item;
                    $quotationProduct->product_name = $request->product_name[$key];
                    $quotationProduct->description = $request->description[$key];
                    $quotationProduct->quantity = $request->quantity[$key];
                    $quotationProduct->price = $request->price[$key];
                    $quotationProduct->sub_total = $request->sub_total[$key];
                    $quotationProduct->save();
                }
            }
        }
        return redirect("quotation");
    }

    public function show(Quotation $quotation)
    {
        $title = trans('quotation.show');
        $action = 'show';
        $this->generateParams();
        return view('user.quotation.show', compact('title', 'quotation','action'));
    }

    public function delete(Quotation $quotation)
    {
        $title = trans('quotation.delete');
        $this->generateParams();
        return view('user.quotation.delete', compact('title', 'quotation'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Quotation $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quotation $quotation)
    {
        $quotation->delete();
        return redirect('quotation');
    }

    /**
     * @return mixed
     */
    public function data()
    {
        $quotations = $this->quotationRepository->getAll()
            ->with('user', 'customer')
            ->get()
            ->map(function ($quotation) {
                return [
                    'id' => $quotation->id,
                    'quotations_number' => $quotation->quotations_number,
                    'date' => $quotation->date,
                    'customer' => isset($quotation->customer) ? $quotation->customer->full_name : '',
                    'person' => isset($quotation->user) ? $quotation->user->full_name : '',
                    'final_price' => $quotation->final_price,
                    'status' => $quotation->status
                ];
            });

        return Datatables::of($quotations)
            ->add_column('actions', '@if(Sentinel::getUser()->hasAccess([\'quotations.write\']) || Sentinel::inRole(\'admin\'))
                                    <a href="{{ url(\'quotation/\' . $id . \'/edit\' ) }}" title="{{ trans(\'table.edit\') }}" >
                                            <i class="fa fa-fw fa-pencil text-warning"></i>  </a>
                                     @endif
                                     @if(Sentinel::getUser()->hasAccess([\'quotations.read\']) || Sentinel::inRole(\'admin\'))
                                    <a href="{{ url(\'quotation/\' . $id . \'/show\' ) }}" title="{{ trans(\'table.details\') }}" >
                                            <i class="fa fa-fw fa-eye text-primary"></i> </a>
                                     <a href="{{ url(\'quotation/\' . $id . \'/print_quot\' ) }}" title="{{ trans(\'table.print\') }}">
                                            <i class="fa fa-fw fa-print text-primary "></i>  </a>
                                    @endif
                                    @if(Sentinel::getUser()->hasAccess([\'sales_orders.write\']) || Sentinel::inRole(\'admin\'))
                                    <a href="{{ url(\'quotation/\' . $id . \'/confirm_sales_order\' ) }}" title="{{ trans(\'table.confirm_sales_order\') }}">
                                            <i class="fa fa-fw fa-check text-primary"></i> </a>
                                    @endif
                                     @if(Sentinel::getUser()->hasAccess([\'quotations.delete\']) || Sentinel::inRole(\'admin\'))
                                   <a href="{{ url(\'quotation/\' . $id . \'/delete\' ) }}" title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-times text-danger"></i> </a>
                                   @endif')
            ->remove_column('id')
            ->make();
    }

    function confirmSalesOrder(Quotation $quotation)
    {
        $total_fields = Saleorder::whereNull('deleted_at')->orWhereNotNull('deleted_at')->orderBy('id', 'desc')->first();
        $sale_no = Settings::get('sales_prefix') . (Settings::get('sales_start_number') + (isset($total_fields) ? $total_fields->id : 0) + 1);

        $saleorder = Saleorder::create(array(
            'sale_number' => $sale_no,
            'customer_id' => $quotation->customer_id,
            'date' => date(Settings::get('date_format')),
            'exp_date' => $quotation->exp_date,
            'qtemplate_id' => $quotation->qtemplate_id,
            'payment_term' => isset($quotation->payment_term)?$quotation->payment_term:0,
            "sales_person_id" => $quotation->sales_person_id,
            "terms_and_conditions" => $quotation->terms_and_conditions,
            "total" => $quotation->total,
            "tax_amount" => $quotation->tax_amount,
            "grand_total" => $quotation->grand_total,
            "discount" => $quotation->discount,
            "final_price" => $quotation->final_price,
            'status' => 'Draft sales order',
            'user_id' => Sentinel::getUser()->id
        ));

        if (!empty($quotation->products->count() > 0)) {
            foreach ($quotation->products as $item) {
                $saleorderProduct = new SaleorderProduct();
                $saleorderProduct->order_id = $saleorder->id;
                $saleorderProduct->product_id = $item->product_id;
                $saleorderProduct->product_name = $item->product_name;
                $saleorderProduct->description = $item->description;
                $saleorderProduct->quantity = $item->quantity;
                $saleorderProduct->price = $item->price;
                $saleorderProduct->sub_total = $item->sub_total;
                $saleorderProduct->save();
            }
        }

        $quotation->delete();

        return redirect('sales_order');
    }

    /**
     * @param Qtemplate $qtemplate
     */
    public function ajaxQtemplatesProducts(Qtemplate $qtemplate)
    {
        return QtemplateProduct::where('qtemplate_id', $qtemplate->id)->get()->toArray();
    }


    public function printQuot(Quotation $quotation)
    {
        $filename = 'Quotation-' . $quotation->quotations_number;
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('a4')->setOrientation('landscape');
        $pdf->loadView('quotation_template.'.Settings::get('quotation_template'), compact('quotation'));
        return $pdf->download($filename . '.pdf');
    }

    public function ajaxCreatePdf(Quotation $quotation)
    {

        dd(Settings::get('quotation_template'));
        $filename = 'Quotation-' . $quotation->quotations_number;
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('a4')->setOrientation('landscape');
        $pdf->loadView('quotation_template.'.Settings::get('quotation_template'), compact('quotation'));
        $pdf->save('./pdf/' . $filename . '.pdf');
        $pdf->stream();
        echo url("pdf/" . $filename . ".pdf");

    }

    public function sendQuotation(QuotationMailRequest $request)
    {
        $quotation_id = $request->quotation_id;
        $email_subject = $request->email_subject;
        $to_company = Company::whereIn('id', $request->recipients)->get();
        $email_body = $request->message_body;
        $message_body = Common::parse_template($email_body);
        $quotation_pdf = $request->quotation_pdf;

        if (!empty($to_company) && !filter_var(Settings::get('site_email'), FILTER_VALIDATE_EMAIL) === false) {
            foreach ($to_company as $item) {
                if (!filter_var($item->email, FILTER_VALIDATE_EMAIL) === false) {
                    Mail::send('emails.quotation', array('message_body' => $message_body), function ($message)
                    use ($item, $email_subject, $quotation_pdf, $item) {
                        $message->from(Settings::get('site_email'), Settings::get('site_name'));
                        $message->to($item->email)->subject($email_subject);
                        $message->attach(url('/pdf/' . $quotation_pdf));
                    });
                }
                $email = new Email();
                $email->assign_customer_id = $item->id;
                $email->from = Sentinel::getUser()->id;
                $email->subject = $email_subject;
                $email->message = $message_body;
                $email->save();
            }
            echo '<div class="alert alert-success">' . trans('invoice.success') . '</div>';
        } else {
            echo '<div class="alert alert-danger">' . trans('invoice.error') . '</div>';
        }
    }

    public function makeInvoice(Quotation $quotation)
    {
        $total_fields = Invoice::whereNull('deleted_at')->orWhereNotNull('deleted_at')->orderBy('id', 'desc')->first();
        $invoice_number = Settings::get('invoice_prefix') . (Settings::get('invoice_start_number') + (isset($total_fields) ? $total_fields->id : 0) + 1);

        $invoice_details = array(
            'order_id' => $quotation->id,
            'customer_id' => $quotation->customer_id,
            'sales_person_id' => $quotation->sales_person_id,
            'sales_team_id' => $quotation->sales_team_id,
            'invoice_number' => $invoice_number,
            'invoice_date' => date(Settings::get('date_format')),
            'due_date' => $quotation->exp_date,
            'payment_term' => isset($quotation->payment_term)?$quotation->payment_term:0,
            'status' => 'Open Invoice',
            'total' => $quotation->total,
            'tax_amount' => $quotation->tax_amount,
            'grand_total' => $quotation->grand_total,
            'unpaid_amount' => $quotation->final_price,
            'discount' => $quotation->discount,
            'final_price' => $quotation->final_price,
            'user_id' => Sentinel::getUser()->id,
        );
        $invoice = Invoice::create($invoice_details);

        $products = $quotation->products;
        if (!empty($products)) {
            foreach ($products as $item) {
                $product_add = array(
                    'invoice_id' => $invoice->id,
                    'product_id' => $item->id,
                    'product_name' => $item->product_name,
                    'description' => $item->description,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'sub_total' => $item->sub_total
                );
                InvoiceProduct::create($product_add);
            }
        }

        $quotation->delete();

        return redirect('invoice');
    }

    private function generateParams()
    {
        $products = $this->productRepository->getAll()->orderBy("id", "desc")->get();

        $qtemplates = ['' => trans('quotation.select_template')] +
            $this->quotationTemplateRepository->getAll()->lists('quotation_template', 'id')->toArray();

        $companies = ['' => trans('dashboard.select_company')] +
            $this->companyRepository->getAll()->orderBy("name", "asc")->lists('name', 'id')->toArray();

        $staffs = ['' => trans('dashboard.select_staff')] +
            $this->userRepository->getStaff()->lists('full_name', 'id')->toArray();

        $salesteams = ['' => trans('dashboard.select_sales_team')] +
            $this->salesTeamRepository->getAllQuotations()
                ->orderBy("id", "asc")
                ->lists('salesteam', 'id')->toArray();

        $customers = ['' => trans('dashboard.select_customer')] +
            $this->userRepository->getCustomers()->lists('full_name', 'id')->toArray();

        $companies_mail = $this->userRepository->getAll()->get()->filter(function ($user) {
            return $user->inRole('customer');
        })->lists('full_name', 'id');

        $statuses = $this->optionRepository->getAll()
            ->where('category', 'quotation_status')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value'   => $title->value,
                ];
            })->lists('title', 'value')->toArray();

        view()->share('statuses', $statuses);
        view()->share('products', $products);
        view()->share('qtemplates', $qtemplates);
        view()->share('companies', $companies);
        view()->share('staffs', $staffs);
        view()->share('salesteams', $salesteams);
        view()->share('customers', $customers);
        view()->share('companies_mail', $companies_mail);
    }
}
