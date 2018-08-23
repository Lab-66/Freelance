@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    
{!! Form::open(array('url' => 'sales_orders/filtersales' , 'method' => 'post')) !!}
 
	<div class="panel-body">
    	<div class="form-group">
            {!! Form::label('pyear', trans('Which year are you want to check?'), array('class' => 'control-label')) !!}
            <div class="controls">
           		{!! Form::select('pyear', $years) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('pmonth', trans('Which month are your want to check?'), array('class' => 'control-label')) !!}
            <div class="controls">
               {!! Form::select('pmonth', $months) !!}
            </div>
        </div>
         <div class="form-group">
            <div class="controls">
            
                <button type="submit" class="btn btn-success"><i class="fa fa-filter"></i> {{trans('Filter')}}</button>
            </div>
        </div>
	</div>
{!! Form::close() !!}

@stop
@section('scripts')
    
@stop