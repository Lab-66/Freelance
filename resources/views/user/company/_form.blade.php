<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($company))
            {!! Form::model($company, array('url' => $type . '/' . $company->id, 'method' => 'put', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => $type, 'method' => 'post', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
            {!! Form::label('name', trans('company.company_name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('name', null, array('class' => 'form-control', 'required' => 'required')) !!}
                <span class="help-block">{{ $errors->first('name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('website') ? 'has-error' : '' }}">
            {!! Form::label('website', trans('company.website'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('website', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('website', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">
            {!! Form::label('address', trans('company.address'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::textarea('address', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('address', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('phone') ? 'has-error' : '' }}">
            {!! Form::label('phone', trans('company.phone'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('phone', null, array('class' => 'form-control','data-fv-integer' => "true")) !!}
                <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('mobile') ? 'has-error' : '' }}">
            {!! Form::label('mobile', trans('company.mobile'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('mobile', null, array('class' => 'form-control','data-fv-integer' => "true")) !!}
                <span class="help-block">{{ $errors->first('mobile', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('fax') ? 'has-error' : '' }}">
            {!! Form::label('fax', trans('company.fax'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('fax', null, array('class' => 'form-control','data-fv-integer' => "true")) !!}
                <span class="help-block">{{ $errors->first('fax', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
            {!! Form::label('country_id', trans('company.country'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('country_id', $countries, null, array('id'=>'country_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('country_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('state_id') ? 'has-error' : '' }}">
            {!! Form::label('state_id', trans('company.state'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('state_id', isset($company)?$states:array(0=>trans('company.select_state')), null, array('id'=>'state_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('state_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('city_id') ? 'has-error' : '' }}">
            {!! Form::label('city_id', trans('company.city'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('city_id', isset($company)?$cities:array(0=>trans('company.select_city')), null, array('id'=>'city_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('city_id', ':message') }}</span>
            </div>
        </div>
        {!! Form::hidden('latitude', null, array('class' => 'form-control', 'id'=>"latitude")) !!}
        {!! Form::hidden('longitude', null, array('class' => 'form-control', 'id'=>"longitude")) !!}
        <div class="form-group required {{ $errors->has('main_contact_person') ? 'has-error' : '' }}">
            {!! Form::label('main_contact_person', trans('company.main_contact_person'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('main_contact_person', $customers, null, array('id'=>'main_contact_person', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('main_contact_person', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('sales_team_id') ? 'has-error' : '' }}">
            {!! Form::label('sales_team_id', trans('company.sales_team_id'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('sales_team_id', $salesteams, null, array('id'=>'sales_team_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('sales_team_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('email') ? 'has-error' : '' }}">
            {!! Form::label('email', trans('company.email'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::email('email', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('email', ':message') }}</span>
            </div>
        </div>

        <div class="form-group required {{ $errors->has('company_avatar_file') ? 'has-error' : '' }}">
            {!! Form::label('company_avatar_file', trans('company.company_avatar'), array('class' => 'control-label')) !!}
            <div class="controls row" v-image-preview>
                <div class="col-sm-2">
                    @if(isset($company->company_avatar) && $company->company_avatar!="")
                        <img src="{{ url('uploads/company/thumb_'.$company->company_avatar) }}"
                             alt="Image">
                    @endif
                </div>
                <div class="col-sm-6">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                             style="width: 200px; height: 150px;">
                            <img id="image-preview" width="300">
                        </div>
                        <div>
                        <span class="btn btn-default btn-file"><span
                                    class="fileinput-new">{{trans('dashboard.select_image')}}</span>
                            <span class="fileinput-exists">{{trans('dashboard.change')}}</span>
                            <input type="file" name="company_avatar_file"></span>
                            <a href="#" class="btn btn-default fileinput-exists"
                               data-dismiss="fileinput">{{trans('dashboard.remove')}}</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <span class="help-block">{{ $errors->first('company_avatar_file', ':message') }}</span>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-group">
            <div class="controls">
                <a href="{{ route($type.'.index') }}" class="btn btn-primary"><i
                            class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                <button type="submit" class="btn btn-success"><i
                            class="fa fa-check-square-o"></i> {{trans('table.ok')}}</button>
            </div>
        </div>
        <!-- ./ form actions -->

        {!! Form::close() !!}
    </div>
</div>

@section('scripts')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
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
        });
        $('#city_id').change(function () {
            var geocoder = new google.maps.Geocoder();
            if (typeof $('#city_id').select2('data')[0] !== "undefined" && typeof $('#state_id').select2('data')[0] !== "undefined") {
                geocoder.geocode({'address': '"' + $('#city_id').select2('data')[0].text + '",' + $('#state_id').select2('data')[0].text + '"'}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        $('#latitude').val(results[0].geometry.location.lat());
                        $('#longitude').val(results[0].geometry.location.lng());
                    }
                });
            }
        })
    </script>
@endsection

