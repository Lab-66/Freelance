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
            
            <div class="page-header clearfix">
                    <div class="pull-right">
                        <a href="{{ 'ticket/create' }}" class="btn btn-primary">
                            <i class="fa fa-plus-circle"></i> {{ trans('Create Ticket') }}</a>
                    </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <i class="material-icons">receipt</i>
                        {{ $title }}
                    </h4>
                                <span class="pull-right">
                                    <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    <i class="fa fa-fw fa-times removepanel clickable"></i>
                                </span>
                </div>
                <div class="panel-body">
                    <table id="data" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>{{ trans('Ticket Number') }}</th>
                                <th>{{ trans('Ticket Subject') }}</th>
                                <th>{{ trans('Ticket Email') }}</th>
                                <th>{{ trans('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($records as $rec)
                        <tr>
                        	<td>{{ $rec->ticket_id }}</td>
                            <td>{{ $rec->ticket_subject }}</td>
                            <td>{{ $rec->email }}</td>
                            <td>
                            	<a href="ticket/edit/{{ $rec->ticket_id }}"><i class="fa fa-fw fa-edit text-primary"></i></a>
                                <a href="ticket/delete/{{ $rec->ticket_id }}"><i class="fa fa-fw fa-trash text-danger"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
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