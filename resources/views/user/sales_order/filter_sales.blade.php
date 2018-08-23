@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
<div class="page-header clearfix">
<a href="http://93.158.221.197/files/public/sales_orders/prev_month" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
</div>
<div class="panel panel-default">
<div class="panel-body">
            <table id="filter" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>{{ trans('sales_order.sale_number') }}</th>
                    <th>{{ trans('sales_order.date') }}</th>
                    <th class="sorting">{{ trans('sales_order.customer') }}</th>
                    <th>{{ trans('sales_order.total') }}</th>
                    <th>{{ trans('sales_order.status') }}</th>
                </tr>
                </thead>
                <tbody>
                
                	@foreach($FilterSales as $each)
                    <tr>
                    	<td>{{$each->sale_number}}</td>
                        <td>{{$each->date}}</td>
                        <td>{{$each->first_name.' '.$each->last_name}}</td>
                        <td>{{$each->total}}</td>
                        <td>{{$each->status}}</td>
                    </tr>
                    @endforeach
                
                </tbody>
            </table>
        </div>
        </div>
@stop
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