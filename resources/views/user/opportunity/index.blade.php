@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
        @if($user_data->hasAccess(['opportunities.write']) || $user_data->inRole('admin'))
            <div class="pull-right">
                <a href="{{ $type.'/create' }}" class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
            </div>
        @endif
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <i class="material-icons">event_seat</i>
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
                    <th>{{ trans('opportunity.opportunity') }}</th>
                    <th>{{ trans('opportunity.customer') }}</th>
                    <th>{{ trans('opportunity.next_action') }}</th>
                    <th>{{ trans('opportunity.next_action_title') }}</th>
                    <th>{{ trans('opportunity.stages') }}</th>
                    <th>{{ trans('opportunity.expected_revenue') }}</th>
                    <th>{{ trans('opportunity.probability') }}</th>
                    <th>{{ trans('opportunity.salesteam') }}</th>
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