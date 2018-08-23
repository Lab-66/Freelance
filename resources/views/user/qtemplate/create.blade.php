@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
        <div class="pull-right">
            <a href="{{ route($type.'.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {!! trans('table.back') !!}</a>
        </div>
    </div>
    <!-- ./ notifications -->
    @include('user/'.$type.'/_form')
@stop
