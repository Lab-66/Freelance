@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-send_by_email"
           onclick="create_pdf({{ $saleorder->id}})"><i class="fa fa-envelope-o"></i> {{trans('quotation.send_email')}}
        </a>
        <a href="{{url('sales_order/'.$saleorder->id.'/print_quot')}}" class="btn btn-primary"><i
                    class="fa fa-print"></i> {{trans('quotation.print')}}</a>
        @if(strtotime(date("m/d/Y"))>strtotime("+".$saleorder->payment_term." days",strtotime($saleorder->exp_date)))
            <button type="button" class="btn btn-danger">{{trans('quotation.expired')}}</button>
        @else
            @if($user_data->hasAccess(['invoices.write']) || $user_data->inRole('admin'))
                <a href="{{url('sales_order/'.$saleorder->id.'/make_invoice')}}" class="btn btn-primary"><i
                            class="fa fa-share"></i> {{trans('quotation.invoice')}}</a>
            @endif
        @endif
    </div>
    <!-- ./ notifications -->
    @include('user/'.$type.'/_form')

    @if($user_data->inRole('admin'))
        <fieldset>
            <legend>{{trans('profile.history')}}</legend>
            <ul>
                @foreach($saleorder->revisionHistory as $history )
                    <li>{{ $history->userResponsible()->first_name }} changed {{ $history->fieldName() }}
                        from {{ $history->oldValue() }} to {{ $history->newValue() }}</li>
                @endforeach
            </ul>
        </fieldset>
        @endif

                <!-- START MODAL SEND BY EMAIL CONTENT -->
        <div class="modal fade" id="modal-send_by_email" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="fa fa-times-circle-o"></i>
                        </button>
                        <h4 class="modal-title">
                            <strong>{{trans('quotation.send')}} </strong>{{trans('quotation.by_email')}}
                        </h4>
                    </div>
                    <div id="sendby_ajax" style="text-align:center;">
                    </div>
                    <div class="modal-body">
                        {!! Form::open(array('url' => $type, 'method' => 'post', 'files'=> true, 'id'=>'send_saleorder', 'name'=>"send_saleorder")) !!}
                        {!! Form::hidden('saleorder_id', $saleorder->id, array('class' => 'form-control', 'id'=>"saleorder_id")) !!}

                        <div class="form-group">
                            {!! Form::label('email_subject', trans('quotation.subject'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::text('email_subject', "Order (Ref ".$saleorder->sale_number.')'
                                , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('recipients', trans('quotation.recipients'), array('class' => 'control-label')) !!}
                            <div class="controls">
                                {!! Form::select('recipients[]', $companies_mail, null, array('id'=>'recipients','multiple','class' => 'form-control select2')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="control-label"></label>
                       <textarea name="message_body" id="message_body" cols="80" rows="10" class="cke-editor">
                       	<p>
                            Hello {{ (isset($saleorder->customer)?$saleorder->customer->full_name:"")}}
                            ,</p>
                            <p>Here is your order confirmation from Demo Company: </p>
                            <p style="border-left: 1px solid #8e0000; margin-left: 30px;">
                                &nbsp;&nbsp;<strong>REFERENCES</strong><br>
                                &nbsp;&nbsp;Order number:
                                <strong>{{ $saleorder->quotations_number}}</strong><br>
                                &nbsp;&nbsp;Order total: <strong>{{ $saleorder->grand_total}}</strong><br>
                                &nbsp;&nbsp;Order date: {{ date('m/d/Y H:i', strtotime($saleorder->date))}}
                                <br>
                            </p>
                       </textarea>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="control-label">{{trans('quotation.file')}}</label>
                            <a href="" id="pdf_url" target="_blank"></a>
                            <input type="hidden" name="saleorder_pdf" id="saleorder_pdf" value=""
                                   class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <div id="sendby_submitbutton">
                            <button type="submit"
                                    class="btn btn-embossed btn-primary">{{trans('quotation.send')}}</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
@stop