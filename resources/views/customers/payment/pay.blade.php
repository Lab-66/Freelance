@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}

@section('content')
    <div class="page-header clearfix">
    </div>
    <div class="panel panel-primary">
        <div class="panel-body">
            {!! Form::open(array('url' => url('customers/payment/'.$invoice->id.'/paypal'), 'method' => 'post', 'class' => 'form-horizontal')) !!}
            <div class="form-group">
                {!! Form::label('title', trans('invoice.invoice_number'), array('class' => 'control-label')) !!}
                {!! Form::label('invoice_number', $invoice->invoice_number, null, array('id'=>'invoice_number', 'class' => 'form-control')) !!}
                {!! Form::hidden('invoice_number', $invoice->invoice_number) !!}
            </div>
            <div class="form-group">
                {!! Form::label('title', trans('invoice.unpaid_amount'), array('class' => 'control-label')) !!}
                {!! Form::label('unpaid_amount',
                (Settings::get('currency_position')=='left')?
                        Settings::get('currency').$invoice->unpaid_amount:
                        $invoice->unpaid_amount.' '.Settings::get('currency'), null, array('id'=>'invoice_number', 'class' => 'form-control')) !!}
                {!! Form::hidden('unpaid_amount', $invoice->unpaid_amount) !!}
            </div>
            <div class="form-group">
                @if(Settings::get('paypal_username')!="" && Settings::get('paypal_password')!="")
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-check-square-o"></i> {{trans('payment.pay_paypal')}}
                    </button>
                @endif
                <br>
            </div>
            {!! Form::close() !!}
            @if(Settings::get('stripe_secret')!="" && Settings::get('stripe_publishable')!="")
                {!! Form::open(array('url' => url('customers/payment/'.$invoice->id.'/stripe'), 'method' => 'post')) !!}
                <script
                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="{!!Settings::get('stripe_secret') !!}"
                        data-amount="{!! $invoice->unpaid_amount*100 !!}"
                        data-name="{!! $invoice->invoice_number !!}"
                        data-currency="{!! Settings::get('currency') !!}"
                        data-locale="auto">
                </script>
                {!! Form::close() !!}
            @endif
            <hr>
        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop

