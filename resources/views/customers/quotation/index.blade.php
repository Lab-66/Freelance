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
                <i class="material-icons">assignment</i>
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
                <th>{{ trans('quotation.quotations_number') }}</th>
                <th>{{ trans('quotation.date') }}</th>
                <th>{{ trans('quotation.customer') }}</th>
                <th>{{ trans('quotation.sales_person') }}</th>
                <th>{{ trans('quotation.total') }}</th>
                <th>{{ trans('quotation.status') }}</th>
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