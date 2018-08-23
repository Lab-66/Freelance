<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($qtemplate))
            {!! Form::model($qtemplate, array('url' => $type . '/' . $qtemplate->id, 'method' => 'put', 'files'=> true, 'id'=>'form')) !!}
        @else
            {!! Form::open(array('url' => $type, 'method' => 'post', 'files'=> true, 'id'=>'form')) !!}
        @endif
        <div class="form-group required {{ $errors->has('quotation_template') ? 'has-error' : '' }}">
            {!! Form::label('quotation_template', trans('qtemplate.quotation_template'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('quotation_template', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('quotation_template', ':message') }}</span>
            </div>
        </div>

        <div class="form-group required {{ $errors->has('quotation_duration') ? 'has-error' : '' }}">
            {!! Form::label('quotation_duration', trans('qtemplate.quotation_duration'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::input('number','quotation_duration', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('quotation_duration', ':message') }}</span>
            </div>
        </div>
        <div class="form-group">
            <label class="md-check">
                <input type="checkbox" name="immediate_payment" value="1"
                       @if(isset($qtemplate) && $qtemplate->immediate_payment=='1') checked @endif>
                <i class="primary"></i> {{trans('qtemplate.immediate_payment')}} </label>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label class="control-label required">{{trans('qtemplate.products')}}
                    <span>{!! $errors->first('products') !!}</span></label>
                <table class="table table-bordered">
                    <thead>
                    <tr style="font-size: 12px;">
                        <th>{{trans('qtemplate.product')}}</th>
                        <th>{{trans('qtemplate.description')}}</th>
                        <th>{{trans('qtemplate.quantity')}}</th>
                        <th>{{trans('qtemplate.unit_price')}}</th>
                        <th>{{trans('qtemplate.subtotal')}}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="InputsWrapper">
                    @if(isset($qtemplate)&& $qtemplate->products->count()>0)
                        @foreach($qtemplate->products as $index => $variants)
                            <tr class="remove_tr">
                                <td>
                                    <input type="hidden" name="product_id[]" id="product_id{{$index}}"
                                           value="{{$variants->product_id}}"
                                           readOnly>
                                    <input type="hidden" name="product_name[]" id="product_name{{$index}}"
                                           value="{{$variants->product_name}}"
                                           readOnly>
                                    <select name="product_list" id="product_list{{$index}}" class="form-control"
                                            data-search="true" onchange="product_value({{$index}});">
                                        <option value=""></option>
                                        @foreach( $products as $product)
                                            <option value="{{ $product->id . '_' . $product->product_name . '_' . $product->sale_price . '_' . $product->description}}"
                                                    @if($product->id == $variants->product_id) selected="selected" @endif>
                                                {{ $product->product_name}}</option>
                                        @endforeach
                                    </select>
                                <td><textarea name=description[]" id="description{{$index}}" rows="2"
                                              class="form-control" readOnly>{{$variants->description}}</textarea>
                                </td>
                                <td><input type="text" name="quantity[]" id="quantity{{$index}}"
                                           value="{{$variants->quantity}}"
                                           class="form-control number"
                                           onchange="product_price_changes('quantity{{$index}}','price{{$index}}','sub_total{{$index}}');">
                                </td>
                                <td>{{$variants->price}}<input type="hidden" name="price[]" id="price{{$index}}"
                                                               value="{{$variants->price}}"
                                                               class="form-control"></td>
                                <input type="hidden" name="taxes[]" id="taxes{{$index}}"
                                       value="{{ floatval(Settings::get('sales_tax')) }}" class="form-control"></td>
                                <td><input type="text" name="sub_total[]" id="sub_total{{$index}}"
                                           value="{{$variants->sub_total}}"
                                           class="form-control" readOnly></td>
                                <td><a href="javascript:void(0)" class="delete removeclass"><i
                                                class="fa fa-fw fa-times fa-lg text-danger"></i></a></td>
                            </tr>
                        @endforeach
                    @endif

                    </tbody>
                </table>
                <button type="button" id="AddMoreFile"
                        class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> {{trans('qtemplate.add_product')}}
                </button>
                <div class="row">&nbsp;</div>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('total') ? 'has-error' : '' }}">
            {!! Form::label('total', trans('qtemplate.total'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('total', null, array('class' => 'form-control','readonly')) !!}
                <span class="help-block">{{ $errors->first('total', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('tax_amount') ? 'has-error' : '' }}">
            {!! Form::label('tax_amount', trans('qtemplate.tax_amount').' ('.floatval(Settings::get('sales_tax')).'%)', array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('tax_amount', null, array('class' => 'form-control','readonly')) !!}
                <span class="help-block">{{ $errors->first('tax_amount', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('grand_total') ? 'has-error' : '' }}">
            {!! Form::label('grand_total', trans('qtemplate.grand_total'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('grand_total', null, array('class' => 'form-control','readonly')) !!}
                <span class="help-block">{{ $errors->first('grand_total', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('terms_and_conditions') ? 'has-error' : '' }}">
            {!! Form::label('quotation_duration', trans('qtemplate.terms_and_conditions'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('terms_and_conditions', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('terms_and_conditions', ':message') }}</span>
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
        $(function () {
            update_total_price();
        });
        function product_value(FieldCount) {
            var all_Val = $("#product_list" + FieldCount).val();
            var res = all_Val.split("_");

            $('#product_id' + FieldCount).val(res[0]);
            $('#product_name' + FieldCount).val(res[1]);
            $('#price' + FieldCount).val(res[2]);
            $('#description' + FieldCount).val(res[3]);
        }
        function product_price_changes(quantity, product_price, sub_total_id) {
            var no_quantity = $("#" + quantity).val();
            var no_product_price = $("#" + product_price).val();

            var sub_total = parseFloat(no_quantity * no_product_price);

            var tax_amount = 0;
            tax_amount = (sub_total * {{floatval(Settings::get('sales_tax'))}}) / 100;
            $('#taxes').val(tax_amount.toFixed(2));

            $('#' + sub_total_id).val(sub_total);
            update_total_price();

        }

        function update_total_price() {
            var sub_total = 0;
            $('#total').val(0);
            $('#tax_amount').val(0);
            $('#grand_total').val(0);
            $('input[name^="sub_total"]').each(function () {
                sub_total += parseFloat($(this).val());
                $('#total').val(sub_total.toFixed(2));

                var tax_per = '{{floatval(Settings::get('sales_tax'))}}';
                var tax_amount = 0;

                tax_amount = (sub_total * tax_per) / 100;
                $('#tax_amount').val(tax_amount.toFixed(2));
                var grand_total = 0;
                grand_total = sub_total + tax_amount;
                $('#grand_total').val(grand_total.toFixed(2));

            });

        }
        var MaxInputs = 50; //maximum input boxes allowed
        var InputsWrapper = $("#InputsWrapper"); //Input boxes wrapper ID
        var AddButton = $("#AddMoreFile"); //Add button ID

        var x = InputsWrapper.length; //initlal text box count
        var FieldCount = @if(isset($qtemplate)&& $qtemplate->products->count()>0) {{$qtemplate->products->count()}} @else 1 @endif; //to keep track of text box added


        $("#total").val("0");

        $(AddButton).click(function (e)  //on add input button click
        {
            if (x <= MaxInputs) //max input box allowed
            {
                FieldCount++; //text box added increment
                var content = '';
                content += '<tr class="remove_tr"><td>';
                content += '<input type="hidden" name="product_id[]" id="product_id' + FieldCount + '" value="" readOnly>';
                content += '<input type="hidden" name="product_name[]" id="product_name' + FieldCount + '" value="" readOnly>';
                content += '<select name="product_list" id="product_list' + FieldCount + '" class="form-control" data-search="true" onchange="product_value(' + FieldCount + ');">' +
                        '<option value=""></option>';
                @foreach( $products as $product)
                        content += '<option value="{{ $product->id . '_' . $product->product_name . '_' . $product->sale_price . '_' . $product->description}}">' +
                        '{{ $product->product_name}}</option>';
                @endforeach
                        content += '</select>' +
                        '<td><textarea name=description[]" id="description' + FieldCount + '" rows="2" class="form-control" readOnly></textarea>' +
                        '</td>' +
                        '<td><input type="text" name="quantity[]" id="quantity' + FieldCount + '" value="" class="form-control number" onchange="product_price_changes(\'quantity' + FieldCount + '\',\'price' + FieldCount + '\',\'sub_total' + FieldCount + '\');"></td>' +
                        '<td><input type="text" name="price[]" id="price' + FieldCount + '" value="" class="form-control" readOnly>' +
                        '<input type="hidden" name="taxes[]" id="taxes' + FieldCount + '" value="{{floatval(Settings::get('sales_tax'))}}" class="form-control" readOnly></td>' +
                        '<td><input type="text" name="sub_total[]" id="sub_total' + FieldCount + '" value="" class="form-control" readOnly></td>' +
                        '<td><a href="javascript:void(0)" class="delete removeclass" title="{{ trans('table.delete') }}"><i class="fa fa-fw fa-times fa-lg text-danger"></i></a></td>' +
                        '</tr>';
                $(InputsWrapper).append(content);
                x++; //text box increment
                $('.number').keypress(function (event) {
                    if (event.which < 46
                            || event.which > 59) {
                        event.preventDefault();
                    } // prevent if not number/dot

                    if (event.which == 46
                            && $(this).val().indexOf('.') != -1) {
                        event.preventDefault();
                    } // prevent if already dot
                });
            }
            return false;
        });


        $(InputsWrapper).on("click", ".removeclass", function (e) { //user click on remove text
            @if(!isset($qtemplate))
            if (x > 0) {
                $(this).parent().parent().remove(); //remove text box
                x--; //decrement textbox
            }
            @else
                $(this).parent().parent().remove(); //remove text box
            x--; //decrement textbox
            @endif
            update_total_price();
            return false;
        });

        $('#form').on('keyup keypress', function (e) {
            var code = e.keyCode || e.which;
            if (code == 13) {
                e.preventDefault();
                return false;
            }
        });
        $('#form').submit(function () {
            if (parseInt($('#grand_total').val(), 10) > 0) {
                return true;
            }
            else {
                $('.btn-success').prop("disabled", false);
                return false;
            }
        });
    </script>
@endsection