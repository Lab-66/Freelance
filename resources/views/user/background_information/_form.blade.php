<div class="panel panel-primary">
    <div class="panel-body">
    @if(isset($id))
    	{!! Form::open(array('url' => $type.'/'.$id.'/update', 'method' => 'post')) !!}
    @else
    	{!! Form::open(array('url' => $type.'/store', 'method' => 'post')) !!}
    @endif
        
        <!--<form method="POST" action="http://full.url/here" accept-charset="UTF-8">
			<input name="_token" type="hidden" value="somelongrandom string">-->
       	<div class="form-group">
            {!! Form::label('name', trans('Name'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('name', isset($name) ?$name:null, array('class' => 'form-control')) !!}
            </div>
        </div>
        
         <div class="form-group">
            {!! Form::label('content', trans('Content'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('content', isset($content) ?$content:null, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="form-group" style="display:none">
            <div class="controls">
            	{!! Form::text('date', isset($date) ?$date:date("d-m-Y"), array('class' => 'form-control')) !!}
            </div>
        </div>
        
         <div class="form-group">
            <div class="controls">
                {!! Form::submit('Click Me!'); !!}
                <!--<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> {{trans('table.ok')}}</button>-->
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
