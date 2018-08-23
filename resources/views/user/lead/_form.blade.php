<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($lead))
            {!! Form::model($lead, array('url' => $type . '/' . $lead->id, 'method' => 'put', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => $type, 'method' => 'post', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('opportunity') ? 'has-error' : '' }}">
            {!! Form::label('opportunity', trans('lead.opportunity'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('opportunity', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('opportunity', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('company_name') ? 'has-error' : '' }}">
            {!! Form::label('company_name', trans('lead.company_name'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('company_name', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('company_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">
            {!! Form::label('address', trans('lead.address'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('address', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('address', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('customer_id') ? 'has-error' : '' }}">
            {!! Form::label('company_id', trans('lead.customer'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('customer_id', $companies, null, array('id'=>'customer_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('customer_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('country_id') ? 'has-error' : '' }}">
            {!! Form::label('country_id', trans('lead.country'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('country_id', $countries, null, array('id'=>'country_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('country_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('state_id') ? 'has-error' : '' }}">
            {!! Form::label('state_id', trans('lead.state'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('state_id', isset($lead)?$states:array(0=>trans('lead.select_state')), null, array('id'=>'state_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('state_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('city_id') ? 'has-error' : '' }}">
            {!! Form::label('city_id', trans('lead.city'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('city_id', isset($lead)?$cities:array(0=>trans('lead.select_city')), null, array('id'=>'city_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('city_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('sales_person_id') ? 'has-error' : '' }}">
            {!! Form::label('sales_person_id', trans('lead.salesperson'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('sales_person_id', $staffs, null, array('id'=>'sales_person_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('sales_person_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('sales_team_id') ? 'has-error' : '' }}">
            {!! Form::label('sales_team_id', trans('lead.sales_team'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('sales_team_id', $salesteams, null, array('id'=>'sales_team_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('sales_team_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('contact_name') ? 'has-error' : '' }}">
            {!! Form::label('contact_name', trans('lead.contact_name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('contact_name', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('contact_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('lead.title'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('title', $titles, null, array('id'=>'title', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('email') ? 'has-error' : '' }}">
            {!! Form::label('email', trans('lead.email'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::email('email', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('email', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('function') ? 'has-error' : '' }}">
            {!! Form::label('function', trans('lead.function'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('function', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('function', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('phone') ? 'has-error' : '' }}">
            {!! Form::label('phone', trans('lead.phone'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('phone', null, array('class' => 'form-control','data-fv-integer' => "true")) !!}
                <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('mobile') ? 'has-error' : '' }}">
            {!! Form::label('mobile', trans('lead.mobile'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('mobile', null, array('class' => 'form-control','data-fv-integer' => 'true')) !!}
                <span class="help-block">{{ $errors->first('mobile', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('fax') ? 'has-error' : '' }}">
            {!! Form::label('fax', trans('lead.fax'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('fax', null, array('class' => 'form-control','data-fv-integer' => 'true')) !!}
                <span class="help-block">{{ $errors->first('fax', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('priority') ? 'has-error' : '' }}">
            {!! Form::label('priority', trans('lead.priority'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('priority', $priority, null, array('id'=>'priority','class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('priority', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('tags') ? 'has-error' : '' }}">
            {!! Form::label('tags', trans('lead.tags'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('tags[]', $tags, (isset($lead)?explode(',',$lead->tags):null), array('id'=>'tags','multiple'=>true, 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('tags', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('internal_notes') ? 'has-error' : '' }}">
            {!! Form::label('internal_notes', trans('lead.internal_notes'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('internal_notes', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('internal_notes', ':message') }}</span>
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
        $('#country_id').change(function () {
            $.ajax({
                type: "GET",
                url: '{{ url('lead/ajax_state_list')}}',
                data: {'id': $(this).val(), _token: '{{ csrf_token() }}'},
                success: function (data) {
                    $('#state_id').empty();
                    $('#city_id').empty();
                    $('#state_id').select2().trigger('change');
                    $('#city_id').select2().trigger('change');
                    $.each(data, function (val, text) {
                        $('#state_id').append($('<option></option>').val(val).html(text))
                    });
                }
            });
        });
        $('#state_id').change(function () {
            $.ajax({
                type: "GET",
                url: '{{ url('lead/ajax_city_list')}}',
                data: {'id': $(this).val(), _token: '{{ csrf_token() }}'},
                success: function (data) {
                    $('#city_id').empty();
                    $('#city_id').select2().trigger('change');
                    $.each(data, function (val, text) {
                        $('#city_id').append($('<option></option>').val(val).html(text))
                    });
                }
            });
        })
    </script>
@endsection
