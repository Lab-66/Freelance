<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\UserController;
use App\Models\Company;
use App\Repositories\ContractRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\LeadRepository;
use App\Repositories\OpportunityRepository;
use App\Repositories\OptionRepository;
use App\Repositories\QuotationRepository;
use App\Repositories\SalesOrderRepository;
use Carbon\Carbon;
use App\Http\Requests;

class DashboardController extends UserController
{
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
    /**
     * @var ContractRepository
     */
    private $contractRepository;
    /**
     * @var OpportunityRepository
     */
    private $opportunityRepository;
    /**
     * @var LeadRepository
     */
    private $leadRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;

    /**
     * DashboardController constructor.
     * @param InvoiceRepository $invoiceRepository
     * @param QuotationRepository $quotationRepository
     * @param SalesOrderRepository $salesOrderRepository
     * @param ContractRepository $contractRepository
     * @param OpportunityRepository $opportunityRepository
     * @param LeadRepository $leadRepository
     * @param OptionRepository $optionRepository
     */
    public function __construct(InvoiceRepository $invoiceRepository, QuotationRepository $quotationRepository,
                                SalesOrderRepository $salesOrderRepository,
                                ContractRepository $contractRepository, OpportunityRepository $opportunityRepository,
                                LeadRepository $leadRepository, OptionRepository $optionRepository)
    {
        parent::__construct();

        $this->invoiceRepository = $invoiceRepository;
        $this->quotationRepository = $quotationRepository;
        $this->salesOrderRepository = $salesOrderRepository;
        $this->contractRepository = $contractRepository;
        $this->opportunityRepository = $opportunityRepository;
        $this->leadRepository = $leadRepository;
        $this->optionRepository = $optionRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::where('main_contact_person', $this->user->id)->get();

        $data = array();
        for($i=11;$i>=0;$i--)
        {
            $data[] =
                array('month' =>Carbon::now()->subMonth($i)->format('M'),
                    'year' =>Carbon::now()->subMonth($i)->format('Y'),
                    'invoices'=>$this->invoiceRepository->getAllForCustomer($this->user->id)->where('created_at','LIKE',
                        Carbon::now()->subMonth($i)->format('Y-m').'%')->sum('grand_total'),
                    'contracts'=>$this->contractRepository->getAllForCustomer($companies)->where('created_at','LIKE',
                        Carbon::now()->subMonth($i)->format('Y-m').'%')->count(),
                    'opportunity'=>$this->opportunityRepository->getAllForCustomer($this->user->id)->where('created_at','LIKE',
                        Carbon::now()->subMonth($i)->format('Y-m').'%')->count(),
                    'leads'=>$this->leadRepository->getAllForCustomer($this->user->id)->where('created_at','LIKE',
                        Carbon::now()->subMonth($i)->format('Y-m').'%')->count());
        }
        $stages = $this->optionRepository->getAll()
            ->where('category', 'stages')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value'   => $title->value,
                ];
            })->toArray();
        $colors = array('#4fc1e9','#a0d468','#37bc9b','#ffcc66','#fd9883','#c2185b','#00796b','#7b1fa2','#3f51b5','#00796b','#607d8b','#00b0ff');
        foreach($stages as $key=>&$item)
        {
            $item['color'] = isset($colors[$key])?$colors[$key]:"";
            $item['opprotunities'] = $this->opportunityRepository->getAllForCustomer($this->user->id)->where('stages',$item['title'])->count();
        }

        return view('customers.index', compact('data','stages'));

    }
}
