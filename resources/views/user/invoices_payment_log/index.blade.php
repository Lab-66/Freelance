@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
        <div class="pull-right">
            <a href="{{ $type.'/create' }}" class="btn btn-primary">
                <i class="fa fa-plus-circle"></i> {{ trans('invoices_payment_log.create_invoice_payment') }}</a>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <i class="material-icons">archive</i>
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
                <th>{{ trans('invoices_payment_log.payment_number') }}</th>
                <th>{{ trans('invoices_payment_log.amount') }}</th>
                <th>{{ trans('invoices_payment_log.invoice_number') }}</th>
                <th>{{ trans('invoices_payment_log.payment_method') }}</th>
                <th>{{ trans('invoices_payment_log.payment_date') }}</th>
                <th>{{ trans('invoices_payment_log.customer') }}</th>
                <th>{{ trans('invoices_payment_log.salesperson') }}</th>
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