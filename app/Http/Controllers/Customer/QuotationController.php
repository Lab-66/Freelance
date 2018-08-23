<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\UserController;
use App\Models\Quotation;
use App\Models\User;
use App\Repositories\QuotationRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Sentinel;
use App\Http\Requests;
use yajra\Datatables\Datatables;

class QuotationController extends UserController
{

    /**
     * @var QuotationRepository
     */
    private $quotationRepository;

    public function __construct(QuotationRepository $quotationRepository)
    {
        parent::__construct();

        $this->quotationRepository = $quotationRepository;

        view()->share('type', 'customers/quotation');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('quotation.quotations');
        return view('customers.quotation.index', compact('title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Quotation $quotation
     * @return \Illuminate\Http\Response
     */
    public function show(Quotation $quotation)
    {
        $title = trans('quotation.show');
        return view('customers.quotation.show', compact('title', 'quotation'));
    }
    /**
     * @return mixed
     */
    public function data()
    {
        $quotations = $this->quotationRepository->getAllForCustomer(Sentinel::getUser()->id)
            ->with('user', 'customer')
            ->get()
            ->map(function ($quotation) {
                return [
                    'id' => $quotation->id,
                    'quotations_number' => $quotation->quotations_number,
                    'date' => $quotation->date,
                    'customer' => isset($quotation->customer) ?$quotation->customer->full_name : '',
                    'person' => isset($quotation->user) ?$quotation->user->full_name : '',
                    'final_price' => $quotation->final_price,
                    'status' => $quotation->status
                ];
            });
        return Datatables::of($quotations)
            ->add_column('actions', '<a href="{{ url(\'customers/quotation/\' . $id . \'/show\' ) }}"  title="{{ trans(\'table.details\') }}">
                                            <i class="fa fa-fw fa-eye text-primary"></i>  </a>
                                     <a href="{{ url(\'customers/quotation/\' . $id . \'/print_quot\' ) }}"  title="{{ trans(\'table.print\') }}">
                                            <i class="fa fa-fw fa-print text-warning"></i>  </a>')
            ->remove_column('id')
            ->make();
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
        $filename = 'Quotation-' . $quotation->quotations_number;
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('a4')->setOrientation('landscape');
        $pdf->loadView('quotation_template.'.Settings::get('quotation_template'), compact('quotation'));
        $pdf->save('./pdf/' . $filename . '.pdf');
        $pdf->stream();
        echo url("pdf/" . $filename . ".pdf");
    }

}
