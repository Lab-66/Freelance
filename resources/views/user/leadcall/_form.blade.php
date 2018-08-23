<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($call))
            {!! Form::model($call, array('url' => $type . '/' . $lead->id . '/' . $call->id, 'method' => 'put', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => $type. '/' . $lead->id , 'method' => 'post', 'files'=> true)) !!}
        @endif
            <div class="form-group required {{ $errors->has('date') ? 'has-error' : '' }}">
            {!! Form::label('date', trans('call.date'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('date', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('date', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('call_summary') ? 'has-error' : '' }}">
            {!! Form::label('call_summary', trans('call.summary'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('call_summary', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('call_summary', ':message') }}</span>
            </div>
        </div>
            <div class="form-group required {{ $errors->has('duration') ? 'has-error' : '' }}">
                {!! Form::label('duration', trans('call.duration'), array('class' => 'control-label')) !!}
                <div class="controls">
                    {!! Form::input('number','duration',null, array('class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('duration', ':message') }}</span>
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
                <a href="{{ url($type.'/'.$lead->id ) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> {{trans('table.ok')}}</button>
            </div>
        </div>
        <!-- ./ form actions -->

        {!! Form::close() !!}
    </div>
</div>
