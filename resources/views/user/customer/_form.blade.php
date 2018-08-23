<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($user))
            {!! Form::model($user, array('url' => $type . '/' . $user->id, 'method' => 'put', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => $type, 'method' => 'post', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('first_name') ? 'has-error' : '' }}">
            {!! Form::label('first_name', trans('customer.first_name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('first_name', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('first_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('last_name') ? 'has-error' : '' }}">
            {!! Form::label('last_name', trans('customer.last_name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('last_name', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('last_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('language', trans('Language'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('language', null, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="form-group required {{ $errors->has('website') ? 'has-error' : '' }}">
            {!! Form::label('website', trans('customer.website'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('website', (isset($user))?$user->customer->website:null, array('class' => 'form-control', 'data-fv-uri'=>'true')) !!}
                <span class="help-block">{{ $errors->first('website', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">
            {!! Form::label('address', trans('customer.address'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('address', (isset($user))?$user->customer->address:null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('address', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('job_position') ? 'has-error' : '' }}">
            {!! Form::label('job_position', trans('customer.job_position'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('job_position', (isset($user))?$user->customer->job_position:null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('job_position', ':message') }}</span>
            </div>
        </div>
        
        <div class="form-group required {{ $errors->has('phone_number') ? 'has-error' : '' }}">
            {!! Form::label('phone_number', trans('customer.phone'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('phone_number', (isset($user))?$user->phone_number:null, array('class' => 'form-control','data-fv-integer' => 'true')) !!}
                <span class="help-block">{{ $errors->first('phone_number', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('mobile') ? 'has-error' : '' }}">
            {!! Form::label('mobile', trans('customer.mobile'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('mobile', (isset($user))?$user->customer->mobile:null, array('class' => 'form-control','data-fv-integer' => 'true')) !!}
                <span class="help-block">{{ $errors->first('mobile', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('fax') ? 'has-error' : '' }}">
            {!! Form::label('fax', trans('customer.fax'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('fax', (isset($user))?$user->customer->fax:null, array('class' => 'form-control','data-fv-integer' => 'true')) !!}
                <span class="help-block">{{ $errors->first('fax', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('customer.title'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('title', $titles, (isset($user))?$user->customer->title:null, array('id'=>'title', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('company_id') ? 'has-error' : '' }}">
            {!! Form::label('company', trans('customer.company'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('company_id', $companies, (isset($user))?$user->customer->company_id:null, array('id'=>'company_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('company_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('sales_team_id') ? 'has-error' : '' }}">
            {!! Form::label('sales_team_id', trans('customer.sales_team_id'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('sales_team_id', $salesteams, (isset($user))?$user->customer->sales_team_id:null, array('id'=>'sales_team_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('sales_team_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('email') ? 'has-error' : '' }}">
            {!! Form::label('email', trans('customer.email'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::email('email', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('email', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('password') ? 'has-error' : '' }}">
            {!! Form::label('password', trans('customer.password'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::password('password', array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('password', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
            {!! Form::label('password_confirmation', trans('customer.password_confirmation'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('password_confirmation', ':message') }}</span>
            </div>
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" value="1" name="status"
                       @if(isset($user->customer) && $user->customer->status==1)checked @endif><i
                        class="primary"></i> {{trans('customer.status')}}
            </label>
        </div>
            <div class="form-group required {{ $errors->has('user_avatar_file') ? 'has-error' : '' }}">
                {!! Form::label('user_avatar_file', trans('customer.customer_avatar'), array('class' => 'control-label')) !!}
                <div class="controls row" v-image-preview>
                    <div class="col-sm-2">
                        @if(isset($user->user_avatar) && $user->user_avatar!="")
                            <img src="{{ url('uploads/avatar/thumb_'.$user->user_avatar) }}"
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
                            <input type="file" name="user_avatar_file"></span>
                                <a href="#" class="btn btn-default fileinput-exists"
                                   data-dismiss="fileinput">{{trans('dashboard.remove')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <span class="help-block">{{ $errors->first('user_avatar_file', ':message') }}</span>
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
