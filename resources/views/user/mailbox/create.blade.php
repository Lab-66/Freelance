@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
<div class="panel panel-primary">
    <div class="panel-body">
        {!! Form::open(array('url' => $type.'/store', 'method' => 'post', 'files'=> true)) !!}
            <div class="form-group">
                {!! Form::label('title', trans('Title'), array('class' => 'control-label')) !!}
                <div class="controls">
                    {!! Form::text('title', null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('subject', trans('Subject'), array('class' => 'control-label')) !!}
                <div class="controls">
                    {!! Form::text('subject', null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('text', trans('Text'), array('class' => 'control-label')) !!}
                <div class="controls">
                    {!! Form::textarea('text', null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('language', trans('Language'), array('class' => 'control-label')) !!}
                <div class="controls">
                    {!! Form::text('language', null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('af', trans('Attach file'), array('class' => 'control-label')) !!}
                <div class="controls">
                    {!! Form::file('af', null, array('class' => 'form-control')) !!}
                </div>
            </div>
            
            <div class="form-group">
                {!! Form::label('lv', trans('List Of variables'), array('class' => 'control-label')) !!}
                <div class="controls">
                    {!! Form::textarea('text', '{user.email}; {user.first_name}; {user.last_name}; {user.phone_number};  {user.city}; {user.county};', array('class' => 'form-control','disabled' => 'disabled')) !!}
                </div>
                
            </div>
            <div class="form-group">
            <div class="controls">
                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> {{trans('table.ok')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
    
@stop