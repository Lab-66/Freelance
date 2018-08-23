@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <i class="material-icons">attach_money</i>
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
                <th>{{ trans('sales_order.order_number') }}</th>
                <th>{{ trans('sales_order.date') }}</th>
                <th>{{ trans('sales_order.customer') }}</th>
                <th>{{ trans('sales_order.salesperson') }}</th>
                <th>{{ trans('sales_order.total') }}</th>
                <th>{{ trans('sales_order.status') }}</th>
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