@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
        @if($user_data->hasAccess(['products.write']) || $user_data->inRole('admin'))
            <div class="pull-right">
                <a href="{{ $type.'/create' }}" class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
                
            </div>
        @endif
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <i class="material-icons">layers</i>
                {{ $title }}
            </h4>
                                <span class="pull-right">
                                    <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    <i class="fa fa-fw fa-times removepanel clickable"></i>
                                </span>
        </div>
        <div class="panel-body">
            <table id="filter" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>{{ 'Title' }}</th>
                    <th>{{ 'Content' }}</th>
                    <th>{{ 'Date' }}</th>
                    <th>{{ 'Action' }}</th>
                </tr>
                </thead>
                <tbody>
                
                @foreach($getNotes as $each)
                    <tr>
                        <td>{{ $each->title}}</td>
                        <td>{{ $each->content }}</td>
                        <td>{{ $each->date }}</td>
                        <td> <a href="http://93.158.221.197/files/public/notes/{{$each->note_id}}/edit" title="Edit">
                                            <i class="fa fa-fw fa-pencil text-warning "></i> </a>
                                                                        <a href="http://93.158.221.197/files/public/notes/{{$each->note_id}}/delete" title="Delete">
                                            <i class="fa fa-fw fa-times text-danger"></i> </a>
                                            </td>
                	</tr>
                @endforeach
                </tbody>
            </table>
         </div>
       <div class='popuptext' id='popuptext'></div>
    </div>
@stop

{{-- Scripts --}}
@section('scripts')
<script type="text/javascript" src="http://93.158.221.197/files/public/js/jquery.tablesorter.js"></script> 
  <script type="application/javascript">  
    $(document).ready(function() 
    { 
        $("#filter").tablesorter( {sortList: [[2,1]]} ); 
    } 
); 
</script>
@stop
