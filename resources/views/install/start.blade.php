@extends('layouts.install')
@section('content')
    @include('install.steps', ['steps' => ['welcome' => 'selected']])
    <div class="step-content" style="background-color: #fff; padding-left: 15px; padding-top: 15px">
        <h3>{{trans('install.welcome')}}</h3>
        <hr>
        <p>{{trans('install.steps_guide')}}</p>
        <p>{{trans('install.installation_process')}} </p>
        <br>
        <a href="{{ url('install/requirements') }}"><button class="btn btn-green pull-right" type="button" style="background-color: #FCD68A">
            {{trans('install.next')}}
            <i class="fa fa-arrow-right" style="margin-left: 6px"></i>
                </button>
        </a>
        <div class="clearfix"></div>
    </div>
@stop