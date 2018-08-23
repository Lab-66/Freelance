@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
        @if($user_data->hasAccess(['logged_calls.read']) || $user_data->inRole('admin'))
            <div class="pull-right">
                <a href="{{ url($type.'/'.$opportunity->id.'/create') }}" class="btn btn-info">
                    <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
            </div>
        @endif
    </div>
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
            <input type="hidden" id="id" value="{{$opportunity->id}}">

            <table id="data" class="table table-striped table-bordered" data-id="data">
                <thead>
                <tr>
                    <th>{{ trans('call.date') }}</th>
                    <th>{{ trans('call.summary') }}</th>
                    <th>{{ trans('call.contact') }}</th>
                    <th>{{ trans('call.responsible') }}</th>
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