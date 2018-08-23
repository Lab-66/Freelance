@extends('layouts.install')
@section('content')
    @include('install.steps', ['steps' => ['welcome' => 'selected done', 'requirements' => 'selected']])
    @if (! $allLoaded)
        <div class="alert alert-danger">
            {!!trans('install.system_not_meet_requirements')!!}
        </div>
    @endif
    <div class="step-content">
        <h3 style="padding-left: 15px; padding-top: 15px">{{trans('install.system_requirements')}}</h3>
        <hr>
        <ul class="list-group" style="border-left: 1px solid #a4a4a4; border-right: 1px solid #a4a4a4">
            @foreach ($requirements as $extension => $loaded)
                <li class="list-group-item {{ ! $loaded ? 'list-group-item-danger' : '' }}">
                    {{ $extension }}
                    @if ($loaded)
                        <span class="badge badge-success"><i class="fa fa-check"></i></span>
                    @else
                        <span class="badge badge-danger"><i class="fa fa-times"></i></span>
                    @endif
                </li>
            @endforeach
        </ul>
        @if ($allLoaded)
            <a class="btn btn-green pull-right" href="{{ url('install/permissions') }}">
                {{trans('install.next')}}
                <i class="fa fa-arrow-right"></i>
            </a>
        @else
            <a class="btn btn-info pull-right" href="{{ url('install/permissions') }}">
                {{trans('install.refresh')}}
                <i class="fa fa-refresh"></i></a>
            <button class="btn btn-green pull-right" disabled>
                {{trans('install.next')}}
                <i class="fa fa-arrow-right"></i>
            </button>
        @endif
        <div class="clearfix"></div>
    </div>
@stop