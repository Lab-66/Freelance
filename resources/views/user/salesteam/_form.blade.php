<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($salesteam))
            {!! Form::model($salesteam, array('url' => $type . '/' . $salesteam->id, 'method' => 'put', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => $type, 'method' => 'post', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('salesteam') ? 'has-error' : '' }}">
            {!! Form::label('salesteam', trans('salesteam.salesteam'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('salesteam', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('salesteam', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('invoice_target') ? 'has-error' : '' }}">
            {!! Form::label('invoice_target', trans('salesteam.invoice_target'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('invoice_target', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('invoice_target', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('invoice_forecast') ? 'has-error' : '' }}">
            {!! Form::label('invoice_forecast', trans('salesteam.invoice_forecast'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('invoice_forecast', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('invoice_forecast', ':message') }}</span>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('responsibility', trans('salesteam.responsibility'), array('class' => 'control-label')) !!}
            <div class="controls">
                <label>
                    <input type="checkbox" value="1" name="quotations" class='icheck'
                           @if(isset($salesteam) && $salesteam->quotations==1) checked @endif>
                    {{trans('salesteam.quotations')}} </label>
                <label>
                    <input type="checkbox" value="1" name="leads" class='icheck'
                           @if(isset($salesteam) && $salesteam->leads==1) checked @endif>
                    {{trans('salesteam.leads')}} </label>
                <label>
                    <input type="checkbox" value="1" name="opportunities" class='icheck'
                           @if(isset($salesteam) && $salesteam->opportunities==1) checked @endif>
                    {{trans('salesteam.opportunities')}} </label>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('team_leader') ? 'has-error' : '' }}">
            {!! Form::label('team_leader', trans('salesteam.team_leader'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('team_leader', $staffs, null, array('id'=>'team_leader', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('team_leader', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('team_members') ? 'has-error' : '' }}">
            {!! Form::label('team_members', trans('salesteam.team_members'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('team_members[]', $staffs, isset($salesteam_stafs)?$salesteam_stafs:null, array('id'=>'team_members', 'multiple'=>true, 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('team_members', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('notes') ? 'has-error' : '' }}">
            {!! Form::label('notes', trans('salesteam.notes'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('notes', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('notes', ':message') }}</span>
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
    <script>
        $(document).ready(function () {
            $('.icheck').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
        });
    </script>
@stop