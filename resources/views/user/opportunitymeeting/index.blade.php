@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
        <div class="pull-right">
            @if($user_data->hasAccess(['meetings.read']) || $user_data->inRole('admin'))
                <a href="{{ url($type.'/'.$opportunity->id.'/calendar') }}" class="btn btn-success">
                    <i class="fa fa-calendar"></i> {{ trans('opportunity.calendar') }}</a>
            @endif
            @if($user_data->hasAccess(['meetings.write']) || $user_data->inRole('admin'))
                <a href="{{ url($type.'/'.$opportunity->id.'/create') }}" class="btn btn-info">
                    <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
            @endif
        </div>
    </div>
    <input type="hidden" id="id" value="{{$opportunity->id}}">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <i class="fa fa-fw fa-bell-o"></i>
                {{ $title }}
            </h4>
                                <span class="pull-right">
                                    <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    <i class="fa fa-fw fa-times removepanel clickable"></i>
                                </span>
        </div>
        <div class="panel-body">

            <table id="data" class="table table-striped table-bordered" data-id="data">
                <thead>
                <tr>
                    <th>{{ trans('meeting.meeting_subject') }}</th>
                    <th>{{ trans('meeting.starting_date') }}</th>
                    <th>{{ trans('meeting.ending_date') }}</th>
                    <th>{{ trans('meeting.responsible') }}</th>
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