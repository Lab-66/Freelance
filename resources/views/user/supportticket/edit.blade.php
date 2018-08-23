@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/c3.min.css') }}">
@stop
{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <i class="material-icons">receipt</i>
                        {{ $title }}
                    </h4>
                </div>
                <div class="panel-body">
                   {!! Form::open(array('url' => 'ticket/edit')) !!}
                   				<input type="hidden" name="ticket_id" value="{{$records[0]->ticket_id}}" />
                                <input type="hidden" name="freshdesk_id" value="{{$records[0]->freshdesk_id}}" />
                                <div class="form-group">
                                    <label for="subject" class="control-label">Subject</label>
                                    <div class="controls">
                                        <input disabled="disabled" type="text" name="subject" id="subject" class="form-control" value="{{$records[0]->ticket_subject}}" />
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="description" class="control-label">Description</label>
                                    <div class="controls">
                                    	<textarea name="description" id="description" class="form-control">{{$records[0]->ticket_description}}</textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="requester" class="control-label">Email</label>
                                    <div class="controls">
                                        <input disabled="disabled" type="text" name="email" id="requester" class="form-control" value="{{$records[0]->email}}" />
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="requester" class="control-label">Priority</label>
                                    <div class="controls">
                                        <select name="priority" id="priority" class="form-control">
                                        	<option value="1" 
                                            	@if($records[0]->priority == '1')
                                                	 selected="selected"
                                                @endif
                                                     >Low
                                            </option>
                                            <option value="2"
                                            @if($records[0]->priority == '2')
                                                	 selected="selected"
                                                @endif
                                                >Medium</option>
                                            <option value="3"
                                            @if($records[0]->priority == '3')
                                                	 selected="selected">
                                                @endif
                                                >High</option>
                                            <option value="4"
                                            @if($records[0]->priority == '4')
                                                	 selected="selected"
                                                @endif
                                                >Urgent</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="requester" class="control-label">Status</label>
                                    <div class="controls">
                                        <select  name="status" id="status" class="form-control">
                                        	<option value="2"
                                            @if($records[0]->status == '2')
                                            	 selected="selected"
                                            @endif
                                            >Open</option>
                                        	<option value="3"
                                            @if($records[0]->status == '3')
                                            	 selected="selected"
                                            @endif
                                            >Pending</option>
                                            <option value="4"
                                            @if($records[0]->status == '4')
                                            	 selected="selected"
                                            @endif
                                            >Resolved</option>
                                            <option value="5"
                                            @if($records[0]->status == '5')
                                            	 selected="selected"
                                            @endif
                                            >Closed</option>
                                            <option value="6"
                                            @if($records[0]->status == '6')
                                            	 selected="selected"
                                            @endif
                                            >Waiting on Customer</option>
                                            <option value="7"
                                            @if($records[0]->status == '7')
                                            	 selected="selected"
                                            @endif
                                            >Waiting on Third Party</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="controls">
                                        <button type="submit" class="btn btn-success"><i class="fa  fa-save"></i> save</button>
                                    </div>
                                </div>
    						  
						{!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

{{-- Scripts --}}
@section('scripts')
    <script type="text/javascript" src="{{ asset('js/d3.v3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/d3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/c3.min.js')}}"></script>
    
@stop