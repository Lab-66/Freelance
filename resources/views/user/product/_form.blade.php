<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($product))
            {!! Form::model($product, array('url' => $type . '/' . $product->id, 'method' => 'put', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => $type, 'method' => 'post', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('product_name') ? 'has-error' : '' }}">
            {!! Form::label('product_name', trans('product.product_name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('product_name', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('product_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('product_image_file') ? 'has-error' : '' }}">
            {!! Form::label('product_image_file', trans('product.product_image'), array('class' => 'control-label')) !!}
            <div class="controls row" v-image-preview>
                <div class="col-sm-2">
                    @if(isset($product->product_image) && $product->product_image!="")
                        <img src="{{ url('uploads/products/thumb_'.$product->product_image) }}"
                             alt="Image">
                    @endif
                </div>
                <div class="col-sm-6">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                             style="width: 200px; height: 150px;">
                            <img id="image-preview" width="300">
                        </div>
                        <div>
                        <span class="btn btn-default btn-file"><span
                                    class="fileinput-new">{{trans('dashboard.select_image')}}</span>
                            <span class="fileinput-exists">{{trans('dashboard.change')}}</span>
                            <input type="file" name="product_image_file"></span>
                            <a href="#" class="btn btn-default fileinput-exists"
                               data-dismiss="fileinput">{{trans('dashboard.remove')}}</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <span class="help-block">{{ $errors->first('product_image_file', ':message') }}</span>
                </div>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('category_id') ? 'has-error' : '' }}">
            {!! Form::label('category_id', trans('product.category_id'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('category_id', $categories, null, array('id'=>'category_id','class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('category_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('status') ? 'has-error' : '' }}">
            {!! Form::label('status', trans('product.status'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('status', $statuses, (isset($product)?$product->status:null), array('id'=>'status','class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('status', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('quantity_on_hand') ? 'has-error' : '' }}">
            {!! Form::label('quantity_on_hand', trans('product.quantity_on_hand'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::input('number','quantity_on_hand', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('quantity_on_hand', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('quantity_available') ? 'has-error' : '' }}">
            {!! Form::label('quantity_available', trans('product.quantity_available'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::input('number','quantity_available', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('quantity_available', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('product_type') ? 'has-error' : '' }}">
            {!! Form::label('product_type', trans('product.product_type'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('product_type', $product_types, (isset($product)?$product->product_type:null), array('id'=>'product_type','class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('product_type', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('sale_price') ? 'has-error' : '' }}">
            {!! Form::label('sale_price', trans('product.sale_price'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('sale_price', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('sale_price', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('description') ? 'has-error' : '' }}">
            {!! Form::label('description', trans('product.description'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('description', ':message') }}</span>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('variants', trans('product.variants'), array('class' => 'control-label')) !!}
            <div class="panel-content">

                <table class="table">
                    <thead>
                    <tr>
                        <th>{{trans('product.attribute_name')}}</th>
                        <th>{{trans('product.product_attribute_value')}}</th>
                        <th>{{trans('product.options')}}</th>
                    </tr>
                    </thead>
                    <tbody id="InputsWrapper">
                    @if(isset($product) && $product->variants->count()>0)
                        @foreach($product->variants as $variants)
                            <tr>
                                <td><input type="text" class="form-control" value="{{$variants->attribute_name}}"
                                           name="attribute_name[]"></td>
                                <td><input type="text" class="form-control"
                                           value="{{$variants->product_attribute_value}}"
                                           name="product_attribute_value[]">
                                </td>
                                <td><a data-target="#modal-basic" data-toggle="modal"
                                       class="delete removeclass" href="javascript:void(0)">
                                        <i class="fa fa-fw fa-times text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td><input type="text" class="form-control" value="" name="attribute_name[]"></td>
                            <td><input type="text" class="form-control" value="" name="product_attribute_value[]"></td>
                            <td><a data-target="#modal-basic" data-toggle="modal"
                                   class="delete removeclass" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-times text-danger"></i>
                                </a>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <a id="AddMoreFileBox" href="#">
                    <button class="btn btn-sm btn-primary" type="button"><i
                                class="fa fa-plus"></i> {{trans('product.add_item')}}
                    </button>
                </a>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-group">
            <div class="controls">
                <a href="{{ route($type.'.index') }}" class="btn btn-primary"><i
                            class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                <button type="submit" class="btn btn-success"><i
                            class="fa fa-check-square-o"></i> {{trans('table.ok')}}</button>
            </div>
        </div>
        <!-- ./ form actions -->

        {!! Form::close() !!}
    </div>
</div>


@section('scripts')
    <script>
        $(document).ready(function () {

            var MaxInputs = 50; //maximum input boxes allowed
            var InputsWrapper = $("#InputsWrapper"); //Input boxes wrapper ID
            var AddButton = $("#AddMoreFileBox"); //Add button ID

            var x = InputsWrapper.length; //initlal text box count
            var FieldCount = 1; //to keep track of text box added

            $(AddButton).click(function (e)  //on add input button click
            {
                if (x <= MaxInputs) //max input box allowed
                {
                    FieldCount++; //text box added increment
                    //add input box
                    $(InputsWrapper).append('<tr><td><input type="text" name="attribute_name[]" value="" class="form-control"></td><td><input type="text" name="product_attribute_value[]" value="" class="form-control"></td><td><a href="javascript:void(0)" class="delete removeclass" data-toggle="modal" data-target="#modal-basic"><i class="fa fa-fw fa-times text-danger"></i></a></td></tr>');
                    x++; //text box increment
                }
                return false;
            });

            $("#InputsWrapper").on("click", ".removeclass", function (e) { //user click on remove text
                @if(!isset($product))
                if (x > 1) {
                    $(this).parent().parent().remove(); //remove text box
                    x--; //decrement textbox
                }
                @else
                    $(this).parent().parent().remove(); //remove text box
                x--; //decrement textbox
                @endif
                        return false;
            })

        });
    </script>
@endsection
