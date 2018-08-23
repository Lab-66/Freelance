@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
        @if($user_data->hasAccess(['leads.write']) || $user_data->inRole('admin'))
            <div class="pull-right">
                <a href="{{ $type.'/create' }}" class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
            </div>
        @endif
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <i class="material-icons">thumb_up</i>
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
                    <th>{{ trans('lead.creation_date') }}</th>
                    <th>{{ trans('lead.opportunity') }}</th>
                    <th>{{ trans('lead.contact_name') }}</th>
                    <th>{{ trans('lead.country') }}</th>
                    <th>{{ trans('lead.email') }}</th>
                    <th>{{ trans('lead.phone') }}</th>
                    <th>{{ trans('lead.sales_team') }}</th>
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