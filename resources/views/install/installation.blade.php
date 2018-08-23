@extends('layouts.install')

@section('content')

    @include('install.steps', ['steps' => [
        'welcome' => 'selected done',
        'requirements' => 'selected done',
        'permissions' => 'selected done',
        'database' => 'selected done',
        'installation' => 'selected'
    ]])

    {!! Form::open(['url' => 'install/install']) !!}
        <div class="step-content"style="padding-left: 15px; padding-top: 15px; padding-right: 15px">
            <h3>{{trans('install.installation')}}</h3>
            <hr>
            <p>{{trans('install.ready_to_install')}}</p>
            <button class="btn btn-green pull-right" data-toggle="loader" data-loading-text="Installing" type="submit">
                <i class="fa fa-play" style="padding-right: 5px"></i>
                {{trans('install.install')}}
            </button>
            <div class="clearfix"></div>
        </div>
    {!! Form::close() !!}
@stop