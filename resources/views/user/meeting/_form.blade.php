<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($meeting))
            {!! Form::model($meeting, array('url' => $type . '/' . $meeting->id, 'method' => 'put', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => $type, 'method' => 'post', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('meeting_subject') ? 'has-error' : '' }}">
            {!! Form::label('meeting_subject', trans('meeting.meeting_subject'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('meeting_subject', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('meeting_subject', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('responsible_id') ? 'has-error' : '' }}">
            {!! Form::label('responsible_id', trans('meeting.responsible'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('responsible_id', $staffs, null, array('id'=>'responsible_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('responsible_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('attendees') ? 'has-error' : '' }}">
            {!! Form::label('attendees', trans('meeting.attendees'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('attendees[]', $companies, (isset($meeting)?explode(',',$meeting->attendees):null), array('id'=>'attendees','multiple'=>true, 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('attendees', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('starting_date') ? 'has-error' : '' }}">
            {!! Form::label('starting_date', trans('meeting.starting_date'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('starting_date', null, array('class' => 'form-control datetime')) !!}
                <span class="help-block">{{ $errors->first('starting_date', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('ending_date') ? 'has-error' : '' }}">
            {!! Form::label('ending_date', trans('meeting.ending_date'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('ending_date', null, array('class' => 'form-control datetime')) !!}
                <span class="help-block">{{ $errors->first('ending_date', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('location') ? 'has-error' : '' }}">
            {!! Form::label('location', trans('meeting.location'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('location', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('location', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('meeting_description') ? 'has-error' : '' }}">
            {!! Form::label('meeting_description', trans('meeting.meeting_description'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('meeting_description', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('meeting_description', ':message') }}</span>
            </div>
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" value="1" name="all_day" class='icheck'
                       @if(isset($meeting) && $meeting->all_day==1)checked @endif>
                {{trans('meeting.all_day')}} </label>
        </div>
        <div class="form-group required {{ $errors->has('privacy') ? 'has-error' : '' }}">
            {!! Form::label('privacy', trans('meeting.privacy'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('privacy', $privacy, null, array('id'=>'privacy', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('privacy', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('show_time_as') ? 'has-error' : '' }}">
            {!! Form::label('show_time_as', trans('meeting.show_time_as'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('show_time_as', $show_times, null, array('id'=>'show_time_as', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('show_time_as', ':message') }}</span>
            </div>
        </div>
        <!-- Form Actions -->
        <div class="form-group">
            <div class="controls">
                <a href="{{ route($type.'.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> {{trans('table.ok')}}</button>
            </div>
        </div>
        <!-- ./ form actions -->

        {!! Form::close() !!}
    </div>
</div>


@section('scripts')
    <script>
        $(document).ready(function () {
            $('.icheck').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
        });
    </script>
@stop