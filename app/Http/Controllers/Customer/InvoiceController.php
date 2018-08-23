<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\UserController;
use App\Http\Requests\InvoiceEditRequest;
use App\Models\Invoice;
use App\Models\User;
use App\Repositories\InvoiceRepository;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Sentinel;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use yajra\Datatables\Datatables;

class InvoiceController extends UserController
{
    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepository)
    {
        parent::__construct();

        view()->share('type', 'customers/invoice');
        $this->invoiceRepository = $invoiceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $open_invoice_total = round($this->invoiceRepository->getAllOpenForCustomer($this->user->id)->sum('grand_total'), 3);
        $overdue_invoices_total = round($this->invoiceRepository->getAllOverdueForCustomer(Sentinel::getUser()->id)->sum('unpaid_amount'), 3);
        $paid_invoices_total = round($this->invoiceRepository->getAllPaidForCustomer(Sentinel::getUser()->id)->sum('grand_total'), 3);
        $invoices_total_collection = round($this->invoiceRepository->getAllForCustomer(Sentinel::getUser()->id)->sum('grand_total'), 3);

        $title = trans('invoice.invoices');
        return view('customers.invoice.index', compact('title','open_invoice_total','overdue_invoices_total',
            'paid_invoices_total','invoices_total_collection'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $title = trans('invoice.show') . ' ' . $invoice->invoice_number;
        return view('customers.invoice.show', compact('title','invoice'));
    }

    public function data()
    {
        $invoices = $this->invoiceRepository->getAllForCustomer(Sentinel::getUser()->id)
            ->with('customer')
            ->get()
            ->map(function ($invoice) {
                return [
                    'id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'invoice_date' => $invoice->invoice_date,
                    'customer' => isset($invoice->customer) ? $invoice->customer->full_name : '',
                    'due_date' => $invoice->due_date,
                    'final_price' => $invoice->final_price,
                    'status' => $invoice->status,
                    'payment_term' => isset($invoice->payment_term)?$invoice->payment_term:0,
                    'count_payment' => $invoice->receivePayment->count()
                ];
            });
        return Datatables::of($invoices)
            ->add_column('expired', '@if(strtotime(date("m/d/Y"))>strtotime("+".$payment_term." days",strtotime($due_date)))
                                        <span class="btn btn-sm warning"><i class="fa fa-info-circle"></i> {{trans("invoice.invoice_expired")}}</span>
                                     @else
                                      <span class="btn btn-sm info"><i class="fa fa-info-circle"></i> {{trans("invoice.invoice_will_expire")}}</span>
                                     @endif')
            ->add_column('actions', '<a href="{{ url(\'customers/invoice/\' . $id . \'/show\' ) }}"  title={{ trans("table.details")}}>
                                            <i class="fa fa-fw fa-eye text-primary"></i>  </a>')
            ->remove_column('id')
            ->remove_column('count_payment')
            ->remove_column('payment_term')
            ->make();
    }

    /**
     * @param Invoice $invoice
     * @return mixed
     */
    public function printQuot(Invoice $invoice)
    {
        $filename = 'Invoice-' . $invoice->invoice_number;
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('a4')->setOrientation('landscape');
        $pdf->loadView('invoice_template.'.Settings::get('invoice_template'), compact('invoice'));
        return $pdf->download($filename . '.pdf');
    }

    /**
     * @param Invoice $invoice
     */
    public function ajaxCreatePdf(Invoice $invoice)
    {
        $filename = 'Invoice-' . Str::slug($invoice->invoice_number);
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('a4')->setOrientation('landscape');
        $pdf->loadView('invoice_template.'.Settings::get('invoice_template'), compact('invoice'));
        $pdf->save('./pdf/' . $filename . '.pdf');
        $pdf->stream();
        echo url("pdf/" . $filename . ".pdf");

    }
}
