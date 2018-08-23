@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/icheck.css') }}" type="text/css">
@stop
{{-- Content --}}
@section('content')
    @include('vendor.flash.message')
    <div class="panel panel-primary" xmlns:v-bind="http://symfony.com/schema/routing">
        <div class="panel-body">
            <span class="pull-right">
                <a href="#" class="text-muted">
                    <i class="fa fa-gear"></i>
                </a>
            </span>
            {!! Form::open(array('url' => '/setting', 'method' => 'post', 'files'=> true, 'id' => 'setting_submit')) !!}

            <div class="nav-tabs-custom" id="setting_tabs">
                <ul class="nav nav-tabs" style="display:list-item;">
                    <li class="active">
                        <a href="#general_configuration"
                           data-toggle="tab" title="{{ trans('settings.general_configuration') }}"><i class="material-icons md-24">build</i></a>
                    </li>
                    <li>
                        <a href="#email_configuration"
                           data-toggle="tab" title="{{ trans('settings.email_configuration') }}"><i class="material-icons md-24">email</i></a>
                    </li>
                    <li>
                        <a href="#payment_configuration"
                           data-toggle="tab" title="{{ trans('settings.payment_configuration') }}"><i class="material-icons md-24">attach_money</i></a>
                    </li>
                    <li>
                        <a href="#start_number_prefix_configuration"
                           data-toggle="tab" title="{{ trans('settings.start_number_prefix_configuration') }}"><i class="material-icons md-24">settings_applications</i></a>
                    </li>
                    <li>
                        <a href="#pusher_configuration"
                           data-toggle="tab" title="{{ trans('settings.pusher_configuration') }}"><i class="material-icons md-24">receipt</i></a>
                    </li>
                    <!--/////////////////////////////-->
                     <li>
                        <a href="#slider_settings"
                           data-toggle="tab" title="{{ trans('Slider Settings') }}"><i class="fa fa-sliders" style="font-size: 27px; "></i></a>
                    </li>
                     <li>
                        <a href="#mollie_settings"
                           data-toggle="tab" title="{{ trans('Mollie Settings') }}"><i class="fa fa-money" style="font-size: 27px;"></i></a>
                    </li>
                    <!--////////////////////////////-->
                    <li>
                        <a href="#paypal_settings"
                           data-toggle="tab" title="{{ trans('settings.paypal_settings') }}"><i class="material-icons md-24">payment</i></a>
                    </li>
                    <li>
                        <a href="#stripe_settings"
                           data-toggle="tab" title="{{ trans('settings.stripe_settings') }}"><i class="material-icons md-24">vpn_key</i></a>
                    </li>
                    <!--li>
                        <a href="#available_modules"
                           data-toggle="tab" title="{{ trans('settings.available_modules') }}"><i class="material-icons md-24">widgets</i></a>
                    </li-->
                    <li>
                        <a href="#backup_configuration"
                           data-toggle="tab" title="{{ trans('settings.backup_configuration') }}"><i class="material-icons md-24">backup</i></a>
                    </li>
                    <li>
                        <a href="#social_configuration"
                           data-toggle="tab" title="{{ trans('settings.social_configuration') }}"><i class="material-icons md-24">share</i></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="general_configuration">
                        <div class="form-group required {{ $errors->has('site_logo') ? 'has-error' : '' }} ">
                            {!! Form::label('site_logo_file', trans('settings.site_logo'), array('class' => 'control-label')) !!}
                            <div class="controls row" v-image-preview>
                                <img src="{{ url('uploads/site/'.Settings::get('site_logo')) }}"
                                     class="img-l col-sm-2">
                                {!! Form::file('site_logo_file', null, array('id'=>'site_logo', 'class' => 'form-control')) !!}
                                <img id="image-preview" width="300">
                                <span class="help-block">{{ $errors->first('site_logo', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('pdf_logo') ? 'has-error' : '' }} ">
                            {!! Form::label('pdf_logo_file', trans('settings.pdf_logo'), array('class' => 'control-label')) !!}
                            <div class="controls row" v-image-preview>
                                <img src="{{ url('uploads/site/'.Settings::get('pdf_logo')) }}"
                                     class="img-l col-sm-2">
                                {!! Form::file('pdf_logo_file', null, array('id'=>'pdf_logo', 'class' => 'form-control')) !!}
                                <img id="image-preview" width="300">
                                <span class="help-block">{{ $errors->first('pdf_logo', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('site_name') ? 'has-error' : '' }}">
                            {!! Form::label('site_name', trans('settings.site_name'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::text('site_name', old('site_name', Settings::get('site_name')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('site_name', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('address1') ? 'has-error' : '' }}">
                            {!! Form::label('site_name', trans('settings.address1'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::text('address1', old('address1', Settings::get('address1')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('address1', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('address2') ? 'has-error' : '' }}">
                            {!! Form::label('address2', trans('settings.address2'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::text('address2', old('address2', Settings::get('address2')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('address2', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('site_email') ? 'has-error' : '' }}">
                            {!! Form::label('site_email', trans('settings.site_email'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::text('site_email', old('site_email', Settings::get('site_email')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('site_email', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('phone') ? 'has-error' : '' }}">
                            {!! Form::label('phone', trans('settings.phone'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::text('phone', old('phone', Settings::get('phone')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('fax') ? 'has-error' : '' }}">
                            {!! Form::label('fax', trans('settings.fax'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::text('fax', old('fax', Settings::get('fax')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('currency') ? 'has-error' : '' }}">
                            {!! Form::label('currency', trans('settings.currency'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::select('currency', $currency, old('currency', Settings::get('currency')), array('id'=>'currency','class' => 'form-control select2')) !!}
                                <span class="help-block">{{ $errors->first('currency', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('currency_position') ? 'has-error' : '' }}">
                            {!! Form::label('currency', trans('settings.currency_position'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::select('currency_position', $currency_positions, old('currency_position', Settings::get('currency_position')), array('id'=>'currency_position','class' => 'form-control select2')) !!}
                                <span class="help-block">{{ $errors->first('currency_position', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('allowed_extensions') ? 'has-error' : '' }}">
                            {!! Form::label('allowed_extensions', trans('settings.allowed_extensions'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::text('allowed_extensions', old('allowed_extensions', Settings::get('allowed_extensions')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('allowed_extensions', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('max_upload_file_size') ? 'has-error' : '' }}">
                            {!! Form::label('max_upload_file_size', trans('settings.max_upload_file_size'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::select('max_upload_file_size', $max_upload_file_size, old('max_upload_file_size', Settings::get('max_upload_file_size')), array('id'=>'max_upload_file_size','class' => 'form-control select2')) !!}
                                <span class="help-block">{{ $errors->first('max_upload_file_size', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('minimum_characters') ? 'has-error' : '' }}">
                            {!! Form::label('minimum_characters', trans('settings.minimum_characters'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::text('minimum_characters', old('minimum_characters', Settings::get('minimum_characters')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('minimum_characters', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('date_format') ? 'has-error' : '' }}">
                            {!! Form::label('date_format', trans('settings.date_format'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                <div class="radio">
                                    {!! Form::radio('date_format', 'F j,Y',(Settings::get('date_format')=='F j,Y')?true:false,array('class' => 'icheck'))  !!}
                                    {!! Form::label('true', date('F j,Y'))  !!}
                                </div>
                                <div class="radio">
                                    {!! Form::radio('date_format', 'Y-d-m',(Settings::get('date_format')=='Y-d-m')?true:false,array('class' => 'icheck'))  !!}
                                    {!! Form::label('date_format', date('Y-d-m'))  !!}
                                </div>
                                <div class="radio">
                                    {!! Form::radio('date_format', 'd.m.Y.',(Settings::get('date_format')=='d.m.Y.')?true:false,array('class' => 'icheck'))  !!}
                                    {!! Form::label('date_format', date('d.m.Y.'))  !!}
                                </div>
                                <div class="radio">
                                    {!! Form::radio('date_format', 'd.m.Y',(Settings::get('date_format')=='d.m.Y')?true:false,array('class' => 'icheck'))  !!}
                                    {!! Form::label('date_format', date('d.m.Y'))  !!}
                                </div>
                                <div class="radio">
                                    {!! Form::radio('date_format', 'd/m/Y',(Settings::get('date_format')=='d/m/Y')?true:false,array('class' => 'icheck'))  !!}
                                    {!! Form::label('date_format', date('d/m/Y'))  !!}
                                </div>
                                <div class="radio">
                                    {!! Form::radio('date_format', 'm/d/Y',(Settings::get('date_format')=='m/d/Y')?true:false,array('class' => 'icheck'))  !!}
                                    {!! Form::label('date_format', date('m/d/Y'))  !!}
                                </div>
                                <div class="form-inline">
                                    {!! Form::radio('date_format', '',false,array('class' => 'icheck', 'id'=>'date_format_custom_radio'))  !!}
                                    {!! Form::label('custom_format', trans('settings.custom_format'))  !!}
                                    {!! Form::input('text','date_format_custom', Settings::get('date_format'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <span class="help-block">{{ $errors->first('date_format', ':message') }}</span>
                        </div>
                        <a href="{{url('http://php.net/manual/en/function.date.php')}}">{!! trans('settings.date_time_format') !!}</a>
                        <div class="form-group required {{ $errors->has('time_format') ? 'has-error' : '' }}">
                            {!! Form::label('time_format', trans('settings.time_format'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                <div class="radio">
                                    {!! Form::radio('time_format', 'g:i a',(Settings::get('time_format')=='g:i a')?true:false,array('class' => 'icheck'))  !!}
                                    {!! Form::label('time_format', date('g:i a'))  !!}
                                </div>
                                <div class="radio">
                                    {!! Form::radio('time_format', 'g:i A',(Settings::get('time_format')=='g:i A')?true:false,array('class' => 'icheck'))  !!}
                                    {!! Form::label('time_format', date('g:i A'))  !!}
                                </div>
                                <div class="radio">
                                    {!! Form::radio('time_format', 'H:i',(Settings::get('time_format')=='H:i')?true:false,array('class' => 'icheck'))  !!}
                                    {!! Form::label('time_format', date('H:i'))  !!}
                                </div>
                                <div class="form-inline">
                                    {!! Form::radio('time_format', '',false,array('class' => 'icheck', 'id'=>'time_format_custom_radio'))  !!}
                                    {!! Form::label('custom_format', trans('settings.custom_format'))  !!}
                                    {!! Form::input('text','time_format_custom', Settings::get('time_format'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <span class="help-block">{{ $errors->first('date_format', ':message') }}</span>
                        </div>
                    </div>
                    <div class="tab-pane" id="email_configuration">
                        <div class="form-group required {{ $errors->has('email_driver') ? 'has-error' : '' }}">
                            {!! Form::label('email_driver', trans('settings.email_driver'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                <div class="form-inline">
                                    <div class="radio">
                                        {!! Form::radio('email_driver', 'mail',(Settings::get('email_driver')=='mail')?true:false,array('id'=>'mail','class' => 'email_driver'))  !!}
                                        {!! Form::label('true', 'MAIL')  !!}
                                    </div>
                                    <div class="radio">
                                        {!! Form::radio('email_driver', 'smtp', (Settings::get('email_driver')=='smtp')?true:false,array('id'=>'smtp','class' => 'email_driver'))  !!}
                                        {!! Form::label('false', 'SMTP') !!}
                                    </div>
                                </div>
                                <span class="help-block">{{ $errors->first('email_driver', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group smtp required {{ $errors->has('email_host') ? 'has-error' : '' }}">
                            {!! Form::label('email_host', trans('settings.email_host'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('text','email_host', old('email_host', Settings::get('email_host')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('email_host', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group smtp required {{ $errors->has('email_port') ? 'has-error' : '' }}">
                            {!! Form::label('email_port', trans('settings.email_port'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('text','email_port', old('email_port', Settings::get('email_port')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('email_port', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group smtp required {{ $errors->has('email_username') ? 'has-error' : '' }}">
                            {!! Form::label('email_username', trans('settings.email_username'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('text','email_username', old('email_username', Settings::get('email_username')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('email_username', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group smtp required {{ $errors->has('email_password') ? 'has-error' : '' }}">
                            {!! Form::label('email_password', trans('settings.email_password'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('text','email_password', old('email_password', Settings::get('email_password')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('email_password', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="payment_configuration">
                        <div class="form-group required {{ $errors->has('sales_tax') ? 'has-error' : '' }}">
                            {!! Form::label('sales_tax', trans('settings.sales_tax').'%', array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('number','sales_tax', old('sales_tax', floatval(Settings::get('sales_tax'))), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('sales_tax', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('payment_term1') ? 'has-error' : '' }}">
                            {!! Form::label('payment_term1', trans('settings.payment_term1'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('number','payment_term1', old('payment_term1', Settings::get('payment_term1')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('payment_term1', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('payment_term2') ? 'has-error' : '' }}">
                            {!! Form::label('payment_term2', trans('settings.payment_term2'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('number','payment_term2', old('payment_term2', Settings::get('payment_term2')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('payment_term2', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('payment_term3') ? 'has-error' : '' }}">
                            {!! Form::label('payment_term3', trans('settings.payment_term3'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('number','payment_term3', old('payment_term3', Settings::get('payment_term3')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('payment_term3', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('opportunities_reminder_days') ? 'has-error' : '' }}">
                            {!! Form::label('opportunities_reminder_days', trans('settings.opportunities_reminder_days'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('number','opportunities_reminder_days', old('opportunities_reminder_days', Settings::get('opportunities_reminder_days')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('opportunities_reminder_days', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('contract_renewal_days') ? 'has-error' : '' }}">
                            {!! Form::label('contract_renewal_days', trans('settings.contract_renewal_days'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('number','contract_renewal_days', old('contract_renewal_days', Settings::get('contract_renewal_days')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('contract_renewal_days', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('invoice_reminder_days') ? 'has-error' : '' }}">
                            {!! Form::label('invoice_reminder_days', trans('settings.invoice_reminder_days'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('number','invoice_reminder_days', old('invoice_reminder_days', Settings::get('invoice_reminder_days')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('invoice_reminder_days', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="start_number_prefix_configuration">
                        <div class="form-group required {{ $errors->has('quotation_prefix') ? 'has-error' : '' }}">
                            {!! Form::label('quotation_prefix', trans('settings.quotation_prefix'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::text('quotation_prefix', old('quotation_prefix', Settings::get('quotation_prefix')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('quotation_prefix', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('quotation_start_number') ? 'has-error' : '' }}">
                            {!! Form::label('quotation_start_number', trans('settings.quotation_start_number'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('number','quotation_start_number', old('quotation_start_number', Settings::get('quotation_start_number')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('quotation_start_number', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('quotation_template') ? 'has-error' : '' }}">
                            {!! Form::label('quotation_template', trans('settings.quotation_template'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::select('quotation_template', $quotation_template, old('quotation_template', Settings::get('quotation_template')), array('id'=>'quotation_template','class' => 'form-control select2')) !!}
                                <span class="help-block">{{ $errors->first('quotation_template', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('sales_prefix') ? 'has-error' : '' }}">
                            {!! Form::label('sales_prefix', trans('settings.sales_prefix'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::text('sales_prefix', old('sales_prefix', Settings::get('sales_prefix')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('sales_prefix', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('sales_start_number') ? 'has-error' : '' }}">
                            {!! Form::label('sales_start_number', trans('settings.sales_start_number'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('number','sales_start_number', old('sales_start_number', Settings::get('sales_start_number')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('sales_start_number', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('saleorder_template') ? 'has-error' : '' }}">
                            {!! Form::label('saleorder_template', trans('settings.saleorder_template'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::select('saleorder_template', $saleorder_template, old('saleorder_template', Settings::get('saleorder_template')), array('id'=>'saleorder_template','class' => 'form-control select2')) !!}
                                <span class="help-block">{{ $errors->first('saleorder_template', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('invoice_prefix') ? 'has-error' : '' }}">
                            {!! Form::label('invoice_prefix', trans('settings.invoice_prefix'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::text('invoice_prefix', old('invoice_prefix', Settings::get('invoice_prefix')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('invoice_prefix', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('invoice_start_number') ? 'has-error' : '' }}">
                            {!! Form::label('invoice_start_number', trans('settings.invoice_start_number'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('number','invoice_start_number', old('invoice_start_number', Settings::get('invoice_start_number')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('invoice_start_number', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('invoice_template') ? 'has-error' : '' }}">
                            {!! Form::label('invoice_template', trans('settings.invoice_template'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::select('invoice_template', $invoice_template, old('invoice_template', Settings::get('invoice_template')), array('id'=>'invoice_template','class' => 'form-control select2')) !!}
                                <span class="help-block">{{ $errors->first('invoice_template', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('invoice_payment_prefix') ? 'has-error' : '' }}">
                            {!! Form::label('invoice_payment_prefix', trans('settings.invoice_payment_prefix'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::text('invoice_payment_prefix', old('invoice_payment_prefix', Settings::get('invoice_payment_prefix')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('invoice_payment_prefix', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('invoice_payment_start_number') ? 'has-error' : '' }}">
                            {!! Form::label('invoice_payment_start_number', trans('settings.invoice_payment_start_number'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('number','invoice_payment_start_number', old('invoice_payment_start_number', Settings::get('invoice_payment_start_number')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('invoice_payment_start_number', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="pusher_configuration">
                        <div class="form-group required {{ $errors->has('pusher_app_id') ? 'has-error' : '' }}">
                            {!! Form::label('pusher_app_id', trans('settings.pusher_app_id'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('text','pusher_app_id', old('pusher_app_id', Settings::get('pusher_app_id')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('pusher_app_id', ':message') }}</span>
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('pusher_key') ? 'has-error' : '' }}">
                            {!! Form::label('pusher_key', trans('settings.pusher_key'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('text','pusher_key', old('pusher_key', Settings::get('pusher_key')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('pusher_key', ':message') }}</span>
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('pusher_secret') ? 'has-error' : '' }}">
                            {!! Form::label('pusher_secret', trans('settings.pusher_secret'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('text','pusher_secret', old('pusher_secret', Settings::get('pusher_secret')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('pusher_secret', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <!--////////////////////////////////////-->
                    <div class="tab-pane" id="slider_settings">Slider
                        <div class="imag-upload">
                            <iframe src="http://93.158.221.197/files/public/bg_slider" width="100%" border="0" height="900" style="border:none;"></iframe>
                        </div>
                    </div>
                    <div class="tab-pane" id="mollie_settings">Mollie
                            <iframe src="http://93.158.221.197/files/public/mollie_requirements" width="100%" border="0" height="900" style="border:none;"></iframe>
                    </div>
                    <!--////////////////////////////////////-->
                    <div class="tab-pane" id="paypal_settings">
                        <div class="form-group required {{ $errors->has('paypal_testmode') ? 'has-error' : '' }}">
                            {!! Form::label('paypal_testmode', trans('settings.paypal_testmode'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                <div class="form-inline">
                                    <div class="radio">
                                        {!! Form::radio('paypal_testmode', 'true',(Settings::get('paypal_testmode')=='true')?true:false,array('class' => 'icheck'))  !!}
                                        {!! Form::label('true', 'True')  !!}
                                    </div>
                                    <div class="radio">
                                        {!! Form::radio('paypal_testmode', 'false', (Settings::get('paypal_testmode')=='false')?true:false,array('class' => 'icheck'))  !!}
                                        {!! Form::label('false', 'False') !!}
                                    </div>
                                </div>
                                <span class="help-block">{{ $errors->first('paypal_testmode', ':message') }}</span>
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('paypal_username') ? 'has-error' : '' }}">
                            {!! Form::label('paypal_username', trans('settings.paypal_username'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('text','paypal_username', old('paypal_username', Settings::get('paypal_username')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('paypal_username', ':message') }}</span>
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('paypal_password') ? 'has-error' : '' }}">
                            {!! Form::label('paypal_password', trans('settings.paypal_password'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('text','paypal_password', old('paypal_password', Settings::get('paypal_password')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('paypal_password', ':message') }}</span>
                            </div>
                        </div>

                        <div class="form-group required {{ $errors->has('paypal_signature') ? 'has-error' : '' }}">
                            {!! Form::label('paypal_signature', trans('settings.paypal_signature'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('text','paypal_signature', old('paypal_signature', Settings::get('paypal_signature')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('paypal_signature', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="stripe_settings">
                        <div class="form-group required {{ $errors->has('stripe_secret') ? 'has-error' : '' }}">
                            {!! Form::label('stripe_secret', trans('settings.stripe_publishable'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('text','stripe_secret', old('stripe_secret', Settings::get('stripe_secret')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('stripe_secret', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('stripe_publishable') ? 'has-error' : '' }}">
                            {!! Form::label('stripe_publishable', trans('settings.stripe_secret'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::input('text','stripe_publishable', old('stripe_publishable', Settings::get('stripe_publishable')), array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('stripe_publishable', ':message') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="backup_configuration">
                        <backup-settings backup_type="{{ Settings::get('backup_type') }}"
                                         :options="{{ $backup_type }}" inline-template>
                            <div class="form-group required {{ $errors->has('backup_type') ? 'has-error' : '' }}">
                                {!! Form::label('backup_type', trans('settings.backup_type'), array('class' => 'control-label')) !!}
                                <div class="controls">
                                    <select v-model="backup_type" name="backup_type" class="form-control">
                                        <option v-for="option in options" v-bind:value="option.id">
                                            @{{ option.text }}
                                        </option>
                                    </select>
                                    <span class="help-block">{{ $errors->first('backup_type', ':message') }}</span>
                                </div>
                            </div>

                            {{-- Dropbox --}}
                            <div v-if="backup_type=='dropbox'">
                                <div class="form-group required {{ $errors->has('disk_dbox_key') ? 'has-error' : '' }}">
                                    {!! Form::label('disk_dbox_key', trans('settings.disk_dbox_key'), array('class' => 'control-label')) !!}
                                    <div class="controls">
                                        {!! Form::text('disk_dbox_key', old('disk_dbox_key', Settings::get('disk_dbox_key')), array('class' => 'form-control')) !!}
                                        <span class="help-block">{{ $errors->first('disk_dbox_key', ':message') }}</span>
                                    </div>
                                </div>


                                <div class="form-group required {{ $errors->has('disk_dbox_secret') ? 'has-error' : '' }}">
                                    {!! Form::label('disk_dbox_secret', trans('settings.disk_dbox_secret'), array('class' => 'control-label')) !!}
                                    <div class="controls">
                                        {!! Form::text('disk_dbox_secret', old('disk_dbox_secret', Settings::get('disk_dbox_secret')), array('class' => 'form-control')) !!}
                                        <span class="help-block">{{ $errors->first('disk_dbox_secret', ':message') }}</span>
                                    </div>
                                </div>

                                <div class="form-group required {{ $errors->has('disk_dbox_token') ? 'has-error' : '' }}">
                                    {!! Form::label('disk_dbox_token', trans('settings.disk_dbox_token'), array('class' => 'control-label')) !!}
                                    <div class="controls">
                                        {!! Form::text('disk_dbox_token', old('disk_dbox_token', Settings::get('disk_dbox_token')), array('class' => 'form-control')) !!}
                                        <span class="help-block">{{ $errors->first('disk_dbox_token', ':message') }}</span>
                                    </div>
                                </div>

                                <div class="form-group required {{ $errors->has('disk_dbox_app') ? 'has-error' : '' }}">
                                    {!! Form::label('disk_dbox_app', trans('settings.disk_dbox_app'), array('class' => 'control-label')) !!}
                                    <div class="controls">
                                        {!! Form::text('disk_dbox_app', old('disk_dbox_app', Settings::get('disk_dbox_app')), array('class' => 'form-control')) !!}
                                        <span class="help-block">{{ $errors->first('disk_dbox_app', ':message') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div v-if="backup_type=='s3'">
                                {{-- AWS S3 --}}
                                <div class="form-group required {{ $errors->has('disk_aws_key') ? 'has-error' : '' }}">
                                    {!! Form::label('disk_aws_key', trans('settings.disk_aws_key'), array('class' => 'control-label')) !!}
                                    <div class="controls">
                                        {!! Form::text('disk_aws_key', old('disk_aws_key', Settings::get('disk_aws_key')), array('class' => 'form-control')) !!}
                                        <span class="help-block">{{ $errors->first('disk_aws_key', ':message') }}</span>
                                    </div>
                                </div>

                                <div class="form-group required {{ $errors->has('disk_aws_secret') ? 'has-error' : '' }}">
                                    {!! Form::label('disk_aws_secret', trans('settings.disk_aws_secret'), array('class' => 'control-label')) !!}
                                    <div class="controls">
                                        {!! Form::text('disk_aws_secret', old('disk_aws_secret', Settings::get('disk_aws_secret')), array('class' => 'form-control')) !!}
                                        <span class="help-block">{{ $errors->first('disk_aws_secret', ':message') }}</span>
                                    </div>
                                </div>


                                <div class="form-group required {{ $errors->has('disk_aws_bucket') ? 'has-error' : '' }}">
                                    {!! Form::label('disk_aws_bucket', trans('settings.disk_aws_bucket'), array('class' => 'control-label')) !!}
                                    <div class="controls">
                                        {!! Form::text('disk_aws_bucket', old('disk_aws_bucket', Settings::get('disk_aws_bucket')), array('class' => 'form-control')) !!}
                                        <span class="help-block">{{ $errors->first('site_nbucket', ':message') }}</span>
                                    </div>
                                </div>


                                <div class="form-group required {{ $errors->has('disk_aws_region') ? 'has-error' : '' }}">
                                    {!! Form::label('disk_aws_region', trans('settings.disk_aws_region'), array('class' => 'control-label')) !!}
                                    <div class="controls">
                                        {!! Form::text('disk_aws_region', old('disk_aws_region', Settings::get('disk_aws_region')), array('class' => 'form-control')) !!}
                                        <span class="help-block">{{ $errors->first('site_nregion', ':message') }}</span>
                                    </div>
                                </div>
                            </div>
                        </backup-settings>
                    </div>

                    <div class="tab-pane" id="social_configuration">
                        @include('user.setting.social-tab')
                    </div>
                </div>
            </div>
            <!-- Form Actions -->
            <div class="form-group fdf">
                <div class="controls">
                    <button type="submit" class="btn btn-success"><i
                                class="fa fa-check-square-o"></i> {{trans('table.ok')}}</button>
                </div>
            </div>
            <!-- ./ form actions -->

            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('scripts')

<script> 
    $(document).on("click", "#upload", function() {
  var file_data = $("#avatar").prop("files")[0]; // Getting the properties of file from file field
  var form_data = new FormData(); // Creating object of FormData class
  form_data.append("file", file_data) // Appending parameter named file with properties of file_field to form_data
  form_data.append("user_id", 123) // Adding extra parameters to form_data
  $.ajax({
    url: "http://93.158.221.197/files/public/slider_upload", // Upload Script
    dataType: 'script',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data, // Setting the data attribute of ajax with file_data
    type: 'post',
    success: function(data) {
        alert('success');
      // Do something after Ajax completes 
    }
  });
});
</script>
    <script type="text/javascript" src="{{ asset('js/icheck.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.icheck').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });

            $("input[name='date_format']").on('ifChecked', function () {
                if ("date_format_custom_radio" != $(this).attr("id"))
                    $("input[name='date_format_custom']").val($(this).val()).siblings('.example').text($(this).siblings('span').text());
            });
            $("input[name='date_format_custom']").focus(function () {
                $("#date_format_custom_radio").attr("checked", "checked");
            });

            $("input[name='time_format']").on('ifChecked', function () {
                if ("time_format_custom_radio" != $(this).attr("id"))
                    $("input[name='time_format_custom']").val($(this).val()).siblings('.example').text($(this).siblings('span').text());
            });
            $("input[name='time_format_custom']").focus(function () {
                $("#time_format_custom_radio").attr("checked", "checked");
            });
            $("input[name='date_format_custom'], input[name='time_format_custom']").on('ifChecked', function () {
                var format = $(this);
                format.siblings('img').css('visibility', 'visible');
                $.post(ajaxurl, {
                    action: 'date_format_custom' == format.attr('name') ? 'date_format' : 'time_format',
                    date: format.val()
                }, function (d) {
                    format.siblings('img').css('visibility', 'hidden');
                    format.siblings('.example').text(d);
                });
            });
        });
        jQuery(document).ready(function($) {
            $('.smtp').hide();
            $('.email_driver').change(function () {
                if($(this).filter(':checked').val()=='smtp')
                {
                    $('.smtp').show();
                }
                else {
                    $('.smtp').hide();
                }
            });
            if($(this).filter(':checked').val()=='smtp')
            {
                $('.smtp').show();
            }
        })
    </script>
@stop
