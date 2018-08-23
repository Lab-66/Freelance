@extends('layouts.install')
@section('content')
    @include('install.steps', ['steps' => [
        'welcome' => 'selected done',
        'requirements' => 'selected done',
        'permissions' => 'selected done',
        'database' => 'selected'
    ]])
    @include('layouts.messages')

    {!! Form::open(array('url' =>  'install/start-installation', 'method' => 'post')) !!}
        <div class="step-content" style="padding-left: 15px; padding-top: 15px; padding-right: 15px">
            <h3>{{trans('install.database_info')}}</h3>
            <hr>
            <div class="form-group">
                <label for="host">{{trans('install.host')}}</label>
                <input type="text" class="form-control" id="host" name="host" value="{{ old('host') }}">
                <small>{{trans('install.host_info')}}</small>
            </div>
            <div class="form-group">
                <label for="username">{{trans('install.username')}}</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}">
                <small>{{trans('install.username_info')}}</small>
            </div>
            <div class="form-group">
                <label for="password">{{trans('install.password')}}</label>
                <input type="password" class="form-control" id="password" name="password">
                <small>{{trans('install.password_info')}}</small>
            </div>
            <div class="form-group">
                <label for="database">{{trans('install.database')}}</label>
                <input type="text" class="form-control" id="database" name="database"  value="{{ old('database') }}">
                <small>{{trans('install.database_info2')}}</small>
            </div>
            <button class="btn btn-green pull-right">
                {{trans('install.next')}}
                <i class="fa fa-arrow-right" style="margin-left: 6px"></i>
            </button>
            <div class="clearfix"></div>
        </div>
    {!! Form::close() !!}
@stop