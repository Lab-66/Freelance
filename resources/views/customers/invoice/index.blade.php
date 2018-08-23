@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
        <div class="col-sm-2 box">
            <div class="txt"><b>{{trans('invoice.open_invoice')}}</b></div>
            <div class="number c-green">${{$open_invoice_total}} </div>
        </div>
        <div class="col-sm-2 box">
            <div class="txt"><b>{{trans('invoice.overdue_invoice')}}</b></div>
            <div class="number c-red">${{$overdue_invoices_total}} </div>
        </div>
        <div class="col-sm-2 box">
            <div class="txt"><b>{{trans('invoice.paid_invoice')}}</b></div>
            <div class="number c-blue">${{ $paid_invoices_total}} </div>
        </div>
        <div class="col-sm-2 box">
            <div class="txt"><b>{{trans('invoice.invoices_total')}}</b></div>
            <div class="number c-red">${{ $invoices_total_collection}} </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <i class="material-icons">web</i>
                {{ $title }}
            </h4>
                                <span class="pull-right">
                                    <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    <i class="fa fa-fw fa-times removepanel clickable"></i>
                                </span>
        </div>
        <div class="panel-body">

        <table id="data" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>{{ trans('invoice.invoice_number') }}</th>
                <th>{{ trans('invoice.invoice_date') }}</th>
                <th>{{ trans('invoice.customer') }}</th>
                <th>{{ trans('invoice.due_date') }}</th>
                <th>{{ trans('invoice.unpaid_amount') }}</th>
                <th>{{ trans('invoice.status') }}</th>
                <th>{{ trans('invoice.expired') }}</th>
                <th>{{ trans('table.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>

@stop

{{-- Scripts --}}
@section('scripts')
@stop