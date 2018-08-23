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
                <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
            <a href="{{ $type.'/import' }}" class="btn btn-primary">
                <i class="fa fa-plus-circle"></i> {{ trans('category.import') }}</a>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <i class="material-icons">gamepad</i>
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
                <th>{{ trans('category.name') }}</th>
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
