<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\UserController;
use App\Repositories\CallRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\ContractRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\LeadRepository;
use App\Repositories\MeetingRepository;
use App\Repositories\OpportunityRepository;
use App\Repositories\OptionRepository;
use App\Repositories\ProductRepository;
use App\Repositories\QuotationRepository;
use App\Repositories\SalesOrderRepository;
use App\Repositories\SalesTeamRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Sentinel;

class DashboardController extends UserController
{
    /**
     * @var LeadRepository
     */
    private $leadRepository;
    /**
     * @var OpportunityRepository
     */
    private $opportunityRepository;
    /**
     * @var CallRepository
     */
    private $callRepository;
    /**
     * @var MeetingRepository
     */
    private $meetingRepository;
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
     * @var CompanyRepository
     */
    private $companyRepository;
    /**
     * @var SalesTeamRepository
     */
    private $salesTeamRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;

    /**
     * DashboardController constructor.
     * @param LeadRepository $leadRepository
     * @param OpportunityRepository $opportunityRepository
     * @param UserRepository $userRepository
     * @param CallRepository $callRepository
     * @param MeetingRepository $meetingRepository
     * @param QuotationRepository $quotationRepository
     * @param SalesOrderRepository $salesOrderRepository
     * @param ContractRepository $contractRepository
     * @param CompanyRepository $companyRepository
     * @param SalesTeamRepository $salesTeamRepository
     * @param ProductRepository $productRepository
     * @param InvoiceRepository $invoiceRepository
     * @param OptionRepository $optionRepository
     */
    public function __construct(LeadRepository $leadRepository,
                                OpportunityRepository $opportunityRepository,
                                UserRepository $userRepository,
                                CallRepository $callRepository,
                                MeetingRepository $meetingRepository,
                                QuotationRepository $quotationRepository,
                                SalesOrderRepository $salesOrderRepository,
                                ContractRepository $contractRepository,
                                CompanyRepository $companyRepository,
                                SalesTeamRepository $salesTeamRepository,
                                ProductRepository $productRepository,
                                InvoiceRepository $invoiceRepository,
                                OptionRepository $optionRepository)
    {
        parent::__construct();
        $this->leadRepository = $leadRepository;
        $this->opportunityRepository = $opportunityRepository;
        $this->userRepository = $userRepository;
        $this->callRepository = $callRepository;
        $this->meetingRepository = $meetingRepository;
        $this->quotationRepository = $quotationRepository;
        $this->salesOrderRepository = $salesOrderRepository;
        $this->contractRepository = $contractRepository;
        $this->companyRepository = $companyRepository;
        $this->salesTeamRepository = $salesTeamRepository;
        $this->productRepository = $productRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->optionRepository = $optionRepository;
    }

    public function index()
    {
        if (Sentinel::check()) {

            $customers = $this->companyRepository->getAll()->count();
            $contracts = $this->contractRepository->getAll()->count();
            $opportunities = $this->opportunityRepository->getAll()->count();
            $products = $this->productRepository->getAll()->count();

            $opportunity_leads = array();
            for($i=11;$i>=0;$i--)
            {
                $opportunity_leads[] =
                    array('month' =>Carbon::now()->subMonth($i)->format('M'),
                        'year' =>Carbon::now()->subMonth($i)->format('Y'),
                            'opportunity'=>$this->opportunityRepository->getAll()->where('created_at','LIKE',
                                Carbon::now()->subMonth($i)->format('Y-m').'%')->count(),
                            'leads'=>$this->leadRepository->getAll()->where('created_at','LIKE',
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
            $customers_world = $this->companyRepository->getAll()
                ->with('cities')
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get()
                ->map(function ($customer) {
                    return [
                        'id' => $customer->id,
                        'latitude' => $customer->latitude,
                        'longitude' => $customer->longitude,
                        'city' => isset($customer->cities) ? $customer->cities->name : '',
                    ];
                });
            $customers_usa = $this->companyRepository->getAll()
                ->where('country_id', 231)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->with('cities')
                ->get()
                ->map(function ($customer) {
                    return [
                        'id' => $customer->id,
                        'latitude' => $customer->latitude,
                        'longitude' => $customer->longitude,
                        'city' => isset($customer->cities) ? $customer->cities->name : '',
                    ];
                });

            return view('user.index', compact('customers', 'contracts', 'opportunities','products',
                'customers_world', 'customers_usa','opportunity_leads','stages'));
        }
    }


}