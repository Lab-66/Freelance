@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/c3.min.css') }}">
@stop
{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <h4>Invoice Details for current month</h4>
                    <hr>
                    <div id="invoice-chart" style="width:100%; height:300px;"></div>
                </div>
                <div class="col-md-6">
                    <ul class="list-inline invoice-list">
                        <li>
                            <div class="txt">{{trans('invoice.invoices_total')}}</div>
                            <h5 class="number c-red">${{ $invoices_total_collection}} </h5>
                        </li>
                        <li>
                            <div class="txt">{{trans('invoice.open_invoice')}}</div>
                            <h5 class="number c-green">${{$open_invoice_total}} </h5>
                        </li>
                        <li>
                            <div class="txt">{{trans('invoice.overdue_invoice')}}</div>
                            <h5 class="number c-red">${{$overdue_invoices_total}} </h5>
                        </li>
                        <li>
                            <div class="txt">{{trans('invoice.paid_invoice')}}</div>
                            <h5 class="number c-blue">${{ $paid_invoices_total}} </h5>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="page-header clearfix">
                @if($user_data->hasAccess(['invoices.write']) || $user_data->inRole('admin'))
                    <div class="pull-right">
                        <a href="{{ $type.'/create' }}" class="btn btn-primary">
                            <i class="fa fa-plus-circle"></i> {{ trans('invoice.new') }}</a>
                    </div>
                @endif
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <i class="material-icons">receipt</i>
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
                            <th>{{ trans('invoice.total') }}</th>
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
        </div>
    </div>
@stop

{{-- Scripts --}}
@section('scripts')
    <script type="text/javascript" src="{{ asset('js/d3.v3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/d3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/c3.min.js')}}"></script>
    <script>

        /*invoice chart*/

        var chart = c3.generate({
            bindto: '#invoice-chart',
            data: {
                columns: [
                    ['Open invoice', {{$open_invoice_total}}],
                    ['Overdue invoice', {{$overdue_invoices_total}}],
                    ['Paid invoice', {{$paid_invoices_total}}]
                ],
                type : 'donut',
                colors: {
                    'Open invoice': '#4FC1E9',
                    'Overdue invoice': '#FD9883',
                    'Paid invoice': '#A0D468'
                }
            }
        });
        //c3 customisation

        /* invoice chart end*/
    </script>
@stop