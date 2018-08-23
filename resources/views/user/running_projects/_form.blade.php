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
            {!! Form::label('budget', trans('Budget (in &euro;)'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('budget', isset($budget) ?$budget:null, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('consumed', trans('Budget consumed(in &euro;)'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('consumed', isset($consumed) ?$consumed:null, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('deadline', trans('Deadline'), array('class' => 'control-label')) !!}
            <div class="controls">
            	{!! Form::text('deadline', isset($deadline) ?$deadline:null, array('class' => 'form-control date')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('milestone', trans('Milestone'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('milestone', isset($milestone) ?$milestone:null, array('class' => 'form-control')) !!}
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
