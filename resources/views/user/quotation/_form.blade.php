<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($quotation))
            {!! Form::model($quotation, array('url' => $type . '/' . $quotation->id, 'method' => 'put', 'files'=> true, 'id'=>'form')) !!}
        @else
            {!! Form::open(array('url' => $type, 'method' => 'post', 'files'=> true, 'id'=>'form')) !!}
        @endif
        <div class="form-group required {{ $errors->has('customer_id') ? 'has-error' : '' }}">
            {!! Form::label('customer_id', trans('quotation.customer'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('customer_id', $customers, (isset($quotation->customer_id)?$quotation->customer_id:null), array('id'=>'customer_id','class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('customer_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('qtemplate_id') ? 'has-error' : '' }}">
            {!! Form::label('qtemplate_id', trans('quotation.quotation_template'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('qtemplate_id', $qtemplates, (isset($quotation)?$quotation->qtemplate_id:null), array('id'=>'qtemplate_id','class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('qtemplate_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('date') ? 'has-error' : '' }}">
            {!! Form::label('date', trans('quotation.date'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('date', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('date', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('exp_date') ? 'has-error' : '' }}">
            {!! Form::label('exp_date', trans('quotation.exp_date'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('exp_date', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('exp_date', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('payment_term') ? 'has-error' : '' }}">
            {!! Form::label('payment_term', trans('quotation.payment_term'), array('class' => 'control-label required')) !!}
            <div class="controls">

                <select name="payment_term" class="form-control">
                    <option value=""></option>
                    @if(Settings::get('payment_term1')!='0')
                        <option value="{{ Settings::get('payment_term1') }}"
                            @if(isset($quotation) &&  Settings::get('payment_term1') == $quotation->payment_term) selected @endif>{{ Settings::get('payment_term1') }} {{trans('quotation.days')}}</option>
                    @endif
                    @if( Settings::get('payment_term2') !='0')
                        <option value="{{ Settings::get('payment_term2') }}"
                                @if(isset($quotation) &&  Settings::get('payment_term2') == $quotation->payment_term) selected @endif>{{ Settings::get('payment_term2') }} {{trans('quotation.days')}}</option>
                    @endif
                    @if( Settings::get('payment_term3') !='0')
                        <option value="{{ Settings::get('payment_term3') }}"
                                @if(isset($quotation) &&  Settings::get('payment_term3') == $quotation->payment_term) selected @endif>{{ Settings::get('payment_term3') }} {{trans('quotation.days')}}</option>
                    @endif
                    <option value="0"
                            @if(isset($quotation) && $quotation->payment_term==0) selected @endif>{{trans('quotation.immediate_payment')}}</option>
                </select>
                <span class="help-block">{{ $errors->first('payment_term', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('sales_team_id') ? 'has-error' : '' }}">
            {!! Form::label('sales_team_id', trans('quotation.sales_team_id'), array('class' => 'control-label  required')) !!}
            <div class="controls">
                {!! Form::select('sales_team_id', $salesteams, (isset($quotation)?$quotation->sales_team_id:null), array('id'=>'sales_team_id','class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('sales_team_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('sales_person_id') ? 'has-error' : '' }}">
            {!! Form::label('sales_person_id', trans('quotation.sales_person'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('sales_person_id', $staffs, (isset($quotation)?$quotation->sales_person_id:null), array('id'=>'sales_person_id','class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('sales_person_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('status') ? 'has-error' : '' }}">
            {!! Form::label('status', trans('quotation.status'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('status', $statuses, (isset($quotation)?$quotation->status:null), array('id'=>'status','class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('status', ':message') }}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label class="control-label required">{{trans('quotation.products')}}
                    <span>{!! $errors->first('products') !!}</span></label>
                <table class="table table-bordered">
                    <thead>
                    <tr style="font-size: 12px;">
                        <th>{{trans('quotation.product')}}</th>
                        <th>{{trans('quotation.description')}}</th>
                        <th>{{trans('quotation.quantity')}}</th>
                        <th>{{trans('quotation.unit_price')}}</th>
                        <th>{{trans('quotation.subtotal')}}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="InputsWrapper">
                    @if(isset($quotation) && $quotation->products->count()>0)
                        @foreach($quotation->products as $index => $variants)
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
                        class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> {{trans('quotation.add_product')}}
                </button>
                <div class="row">&nbsp;</div>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('total') ? 'has-error' : '' }}">
            {!! Form::label('total', trans('quotation.total'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('total', null, array('class' => 'form-control','readonly')) !!}
                <span class="help-block">{{ $errors->first('total', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('tax_amount') ? 'has-error' : '' }}">
            {!! Form::label('tax_amount', trans('quotation.tax_amount').' ('.floatval(Settings::get('sales_tax')).'%)', array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('tax_amount', null, array('class' => 'form-control','readonly')) !!}
                <span class="help-block">{{ $errors->first('tax_amount', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('grand_total') ? 'has-error' : '' }}">
            {!! Form::label('grand_total', trans('quotation.grand_total'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('grand_total', null, array('class' => 'form-control','readonly')) !!}
                <span class="help-block">{{ $errors->first('grand_total', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('discount') ? 'has-error' : '' }}">
            {!! Form::label('discount', trans('quotation.discount').' (%)', array('class' => 'control-label')) !!}
            <div class="controls">
                <input type="text" name="discount" id="discount"
                       value="{{(isset($quotation)?$quotation->discount:"0.00")}}"
                       class="form-control number"
                       onchange="update_total_price();">
                <span class="help-block">{{ $errors->first('discount', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('final_price') ? 'has-error' : '' }}">
            {!! Form::label('final_price', trans('quotation.final_price'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('final_price', null, array('class' => 'form-control','readonly')) !!}
                <span class="help-block">{{ $errors->first('final_price', ':message') }}</span>
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
            $('#qtemplate_id').change(function () {
                if ($(this).val() > 0) {
                    $.ajax({
                        type: "GET",
                        url: '{{url("quotation/ajax_qtemplates_products")}}/' + $(this).val(),
                        success: function (data) {
                            content_data = '';
                            $.each(data, function (i, item) {
                                content_data += makeContent(FieldCount, item);
                                FieldCount++;
                            });
                            $("#InputsWrapper").html(content_data);
                            update_total_price();
                        }
                    });
                }
            });
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
            tax_amount = (sub_total * {{ floatval(Settings::get('sales_tax')) }}) / 100;
            $('#taxes').val(tax_amount.toFixed(2));

            $('#' + sub_total_id).val(sub_total);
            update_total_price();

        }

        function update_total_price() {
            var sub_total = 0;
            $('#total').val(0);
            $('#tax_amount').val(0);
            $('#grand_total').val(0);
            $('#final_price').val(0);
            $('input[name^="sub_total"]').each(function () {
                sub_total += parseFloat($(this).val());
                $('#total').val(sub_total.toFixed(2));

                var tax_per = "{{ floatval(Settings::get('sales_tax')) }}";
                var tax_amount = 0;

                tax_amount = (sub_total * tax_per) / 100;
                $('#tax_amount').val(tax_amount.toFixed(2));
                var grand_total = 0;
                grand_total = sub_total + tax_amount;
                $('#grand_total').val(grand_total.toFixed(2));

                var discount = $("#discount").val();
                discount_amount = (grand_total * discount) / 100;
                final_price = grand_total - discount_amount;
                $('#final_price').val(final_price.toFixed(2));
            });
        }

        function makeContent(number, item) {
            item = item || '';

            var content = '<tr class="remove_tr"><td>';
            content += '<input type="hidden" name="product_id[]" id="product_id' + number + '" value="' + ((typeof item.product_id == 'undefined') ? '' : item.product_id) + '" readOnly>';
            content += '<input type="hidden" name="product_name[]" id="product_name' + number + '" value="' + ((typeof item.product_name == 'undefined') ? '' : item.product_name) + '" readOnly>';
            content += '<select name="product_list" id="product_list' + number + '" class="form-control" data-search="true" onchange="product_value(' + number + ');">' +
                    '<option value=""></option>';
            @foreach( $products as $product)
                    content += '<option value="{{ $product->id . '_' . $product->product_name . '_' . $product->sale_price . '_' . $product->description}}"';
            if (item.product_id =={{$product->id}}) {
                content += 'selected';
            }
            content += '>' +
                    '{{ $product->product_name}}</option>';
            @endforeach
                    content += '</select>' +
                    '<td><textarea name=description[]" id="description' + number + '" rows="2" class="form-control" readOnly>' + ((typeof item.description == 'undefined') ? '' : item.description) + '</textarea>' +
                    '</td>' +
                    '<td><input type="text" name="quantity[]" id="quantity' + number + '" value="' + ((typeof item.quantity == 'undefined') ? '' : item.quantity) + '" class="form-control number" onchange="product_price_changes(\'quantity' + number + '\',\'price' + number + '\',\'sub_total' + number + '\');"></td>' +
                    '<td><input type="text" name="price[]" id="price' + number + '" value="' + ((typeof item.price == 'undefined') ? '' : item.price) + '" class="form-control" readOnly>' +
                    '<input type="hidden" name="taxes[]" id="taxes' + number + '" value="{{ floatval(Settings::get('sales_tax')) }}" class="form-control" readOnly></td>' +
                    '<td><input type="text" name="sub_total[]" id="sub_total' + number + '" value="' + ((typeof item.sub_total == 'undefined') ? '' : item.sub_total) + '" class="form-control" readOnly></td>' +
                    '<td><a href="javascript:void(0)" class="delete removeclass" title="{{ trans('table.delete') }}"><i class="fa fa-fw fa-times fa-lg text-danger"></i></a></td>' +
                    '</tr>';
            return content;
        }

        var FieldCount = 1; //to keep track of text box added
        var MaxInputs = 50; //maximum input boxes allowed
        var InputsWrapper = $("#InputsWrapper"); //Input boxes wrapper ID
        var AddButton = $("#AddMoreFile"); //Add button ID

        var x = InputsWrapper.length; //initlal text box count


        $("#total").val("0");

        $(AddButton).click(function (e)  //on add input button click
        {
            if (x <= MaxInputs) //max input box allowed
            {
                FieldCount++; //text box added increment
                content = makeContent(FieldCount);
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
        })

        function create_pdf(quotation_id) {
            $.ajax({
                type: "GET",
                url: "{{url('quotation' )}}/" + quotation_id + "/ajax_create_pdf",
                data: {'_token': '{{csrf_token()}}'},
                success: function (msg) {
                    if (msg != '') {
                        $("#pdf_url").attr("href", msg)
                        var index = msg.lastIndexOf("/") + 1;
                        var filename = msg.substr(index);
                        $("#pdf_url").html(filename);
                        $("#quotation_pdf").val(filename);
                    }
                }
            });
        }
        $("form[name='send_quotation']").submit(function (e) {
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "{{url('quotation/send_quotation')}}",
                type: "POST",
                data: formData,
                async: false,
                success: function (msg) {
                    $('body,html').animate({scrollTop: 0}, 200);
                    $("#sendby_ajax").html(msg);
                },
                cache: false,
                contentType: false,
                processData: false
            });
            e.preventDefault();
        });


        $('#form').on('keyup keypress', function (e) {
            var code = e.keyCode || e.which;
            if (code == 13) {
                e.preventDefault();
                return false;
            }
        });
        $('#form').submit(function () {
            if (parseInt($('#final_price').val(), 10) > 0) {
                return true;
            }
            else {
                $('.btn-success').prop("disabled", false);
                return false;
            }
        });
    </script>
@endsection