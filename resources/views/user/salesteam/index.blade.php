@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
        @if($user_data->hasAccess(['sales_team.write']) || $user_data->inRole('admin'))
            <div class="pull-right">
                <a href="{{ request()->url() }}/import"
                   class="btn btn-primary">
                    <i class="fa fa-download"></i> {{ trans('table.import') }}
                </a>

                <a href="{{ url($type.'/create') }}" class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
            </div>
        @endif
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <i class="material-icons">groups</i>
                {{ $title }}
            </h4>
                                <span class="pull-right">
                                    <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    <i class="fa fa-fw fa-times removepanel clickable"></i>
                                </span>
        </div>
        <div class="panel-body">
            <table id="data" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>{{ trans('salesteam.salesteam') }}</th>
                    <th>{{ trans('salesteam.invoice_target') }}</th>
                    <th>{{ trans('salesteam.invoice_forecast') }}</th>
                    <th>{{ trans('salesteam.actual_invoice') }}</th>
                    <th>{{ trans('table.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>


    <div class="modal fade" id="importModal">
        <div class="modal-dialog">
            <form action="" method="post" class="form-horizontal" role="form" v-on:submit.prevent="uploadFile()">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Salesteam Import</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">File</label>
                            <div class="col-sm-10">
                                <input type="file"
                                       v-el:fileInput
                                       id=""
                                       name="file"
                                       placeholder="">
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <a href="{{ request()->path() }}/download-template" class="btn btn-default">Download
                            Template</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </form>
        </div>
        <!-- /.modal-dialog -->
    </div>

@stop

{{-- Scripts --}}
@section('scripts')

@stop