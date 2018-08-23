<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($category))
            {!! Form::model($category, array('url' => $type . '/' . $category->id, 'method' => 'put', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => $type, 'method' => 'post', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
            {!! Form::label('name', trans('category.name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('name', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('name', ':message') }}</span>
            </div>
        </div>
         <div class="form-group">
            {!! Form::label('des', trans('Category description'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
            </div>
        </div>
        @if(isset($category_data->id))
		<div class="form-group">
            {!! Form::label('des', trans('All products'), array('class' => 'control-label')) !!}
            <div class="controls">
            	@if(isset($allProducts))
                    <!--<select name="sp" >-->
                    @foreach($allProducts as $eachProduct)
                        <!--<option value="{{$eachProduct->id}}"></option></select>-->
                        	@if($eachProduct->category_id == $category_data->id)
                            	{{$eachProduct->product_name}},
                            @endif
                        
                    @endforeach
                    
               @endif
                
            </div>
        </div>
        @endif
        <!-- Form Actions -->
        <div class="form-group">
            <div class="controls">
                <a href="{{ route($type.'.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> {{trans('table.ok')}}</button>
            </div>
        </div>
        <!-- ./ form actions -->

        {!! Form::close() !!}
    </div>
</div>
