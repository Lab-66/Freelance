@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
    </div>
    <!-- ./ notifications -->
    <div class="panel panel-primary">
    <div class="panel-body">
            {!! Form::open(array('url' => $type.'/store', 'method' => 'post', 'files'=> true)) !!}
       
        <div class="form-group">
            {!! Form::label('title', trans('Title'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('location', trans('Location'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('location', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('location', ':message') }}</span>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('date', trans('date'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('date', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('date', ':message') }}</span>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('start_time', trans('Start Time'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('start_time', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('start_time', ':message') }}</span>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('end_time', trans('End Time'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('end_time', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('end_time', ':message') }}</span>
            </div>
        </div>
    <!-- Form Actions -->
        <div class="form-group">
            <div class="controls">
               
                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> {{trans('table.ok')}}
                </button>
            </div>
        </div>
        <!-- ./ form actions -->

        {!! Form::close() !!}
    </div>
</div>
@stop

@section('scripts')
    <link href="/files/public/timepicker/timepicki.css" rel="stylesheet">
    <script type="text/javascript" src="/files/public/timepicker/timepicki.js"></script>
	<script>
	$('#start_time').timepicki();
	$('#end_time').timepicki();
	</script>	
@endsection
