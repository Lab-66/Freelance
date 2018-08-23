<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($call))
            {!! Form::model($call, array('url' => $type . '/' . $call->id, 'method' => 'put', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => $type, 'method' => 'post', 'files'=> true)) !!}
        @endif
       <div class="test form-group required {{ $errors->has('date') ? 'has-error' : '' }}">
            {!! Form::label('date', trans('call.date'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('date', isset($call)?null:date('d.m.Y.h:i:sa',strtotime("now")), array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('date', ':message') }}</span>
            </div>
        </div>
        <div class="form-group">
        {!! Form::label('timepicker', trans('Time'), array('class' => 'control-label')) !!}
        <input id="timepicker1" type="text" name="timepicker1" value="{{isset($call)?$call->timepicker1:null}}"/>
           <!-- {!! Form::label('timepicker', trans('Time'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('timepicker', null, array('class' => 'form-control timepicker')) !!}
                <span class="help-block">{{ $errors->first('timepicker', ':message') }}</span>
            </div>-->
        </div>
        <div class="form-group">
            {!! Form::label('duration', trans('call.duration'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::input('number','duration',null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('duration', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('call_summary') ? 'has-error' : '' }}">
            {!! Form::label('call_summary', trans('call.summary'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('call_summary', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('call_summary', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('company_id') ? 'has-error' : '' }}">
            {!! Form::label('company_id', trans('call.contact'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('company_id', $companies, null, array('id'=>'company_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('company_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('resp_staff_id') ? 'has-error' : '' }}">
            {!! Form::label('resp_staff_id', trans('call.responsible'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('resp_staff_id', $staffs, null, array('id'=>'resp_staff_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('resp_staff_id', ':message') }}</span>
            </div>
        </div>
        <!-- Form Actions -->
        <div class="form-group">
            <div class="controls">
                <a href="{{ route($type.'.index') }}" class="btn btn-primary"><i
                            class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> {{trans('table.ok')}}
                </button>
            </div>
        </div>
        <!-- ./ form actions -->

        {!! Form::close() !!}
    </div>
</div>
@section('scripts')
	<link href="/files/public/timepicker/timepicki.css" rel="stylesheet">
    <script type="text/javascript" src="/files/public/timepicker/timepicki.js"></script>
	<script>
	var x = $('#timepicker1').val();
	if(x != ''){
		a = x.split(':');
		b = a[1].split(' ');
		$('#timepicker1').timepicki({start_time: [a[0], b[0], b[1]]});
	} else{
		$('#timepicker1').timepicki();
	}
	
    </script>
@endsection
