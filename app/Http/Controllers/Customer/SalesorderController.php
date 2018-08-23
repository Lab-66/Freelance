<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\UserController;
use App\Models\Saleorder;
use App\Models\User;
use App\Repositories\QuotationRepository;
use App\Repositories\SalesOrderRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Sentinel;
use App\Http\Requests;
use yajra\Datatables\Datatables;

class SalesorderController extends UserController
{
    /**
     * @var QuotationRepository
     */
    private $salesOrderRepository;

    public function __construct(SalesOrderRepository $salesOrderRepository)
    {
        parent::__construct();
        $this->salesOrderRepository = $salesOrderRepository;

        view()->share('type', 'customers/sales_order');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('sales_order.sales_orders');
        return view('customers.sales_order.index', compact('title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Saleorder $saleorder
     * @return \Illuminate\Http\Response
     */
    public function show(Saleorder $saleorder)
    {
        $title = trans('quotation.show');
        return view('customers.sales_order.show', compact('title', 'saleorder'));
    }
    public function data()
    {
        $sales_orders = $this->salesOrderRepository->getAllForCustomer(Sentinel::getUser()->id)
            ->with('user', 'customer')
            ->get()
            ->map(function ($saleorder) {
                return [
                    'id' => $saleorder->id,
                    'sale_number' => $saleorder->sale_number,
                    'date' => $saleorder->date,
                    'customer' => isset($saleorder->customer) ?$saleorder->customer->full_name : '',
                    'person' => isset($saleorder->user) ?$saleorder->user->full_name : '',
                    'final_price' => $saleorder->final_price,
                    'status' => $saleorder->status
                ];
            });
        return Datatables::of($sales_orders)
            ->add_column('actions', '<a href="{{ url(\'customers/sales_order/\' . $id . \'/show\' ) }}"  title="{{ trans(\'table.details\') }}">
                                            <i class="fa fa-fw fa-eye text-primary"></i> </a>')
            ->remove_column('id')
            ->make();
    }
    public function printQuot(Saleorder $saleorder)
    {
        $filename = 'SaleOrder-' . $saleorder->sale_number;
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('a4')->setOrientation('landscape');
        $pdf->loadView('saleorder_template.'.Settings::get('saleorder_template'), compact('saleorder'));
        return $pdf->download($filename . '.pdf');
    }

    public function ajaxCreatePdf(Saleorder $saleorder)
    {
        $filename = 'SaleOrder-' . $saleorder->sale_number;
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('a4')->setOrientation('landscape');
        $pdf->loadView('saleorder_template.'.Settings::get('saleorder_template'), compact('saleorder'));
        $pdf->save('./pdf/' . $filename . '.pdf');
        $pdf->stream();
        echo url("pdf/" . $filename . ".pdf");

    }
}
