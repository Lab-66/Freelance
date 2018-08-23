<div class="panel panel-primary">
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('sales_order.sale_number')}}</label>

            <div class="controls">
                {{ $saleorder->sale_number }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('quotation.date')}}</label>

            <div class="controls">
                {{ $saleorder->date }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('quotation.exp_date')}}</label>

            <div class="controls">
                {{ $saleorder->exp_date }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('quotation.payment_term')}}</label>

            <div class="controls">
                {{ $saleorder->payment_term }} {{trans('quotation.days')}}
            </div>
        </div>
        <div class="form-group">
            <div>
                <label class="control-label">{{trans('quotation.products')}}</label>
                <table class="table">
                    <thead>
                    <tr style="font-size: 12px;">
                        <th>{{trans('quotation.product')}}</th>
                        <th>{{trans('quotation.description')}}</th>
                        <th>{{trans('quotation.quantity')}}</th>
                        <th>{{trans('quotation.unit_price')}}</th>
                        <th>{{trans('quotation.taxes')}}</th>
                        <th>{{trans('quotation.subtotal')}}</th>
                    </tr>
                    </thead>
                    <tbody id="InputsWrapper">

                    @if(isset($saleorder)&& $saleorder->products->count()>0)
                        @foreach($saleorder->products as $index => $variants)
                            <tr class="remove_tr">
                                <td>
                                    {{$variants->product_name}}
                                </td>
                                <td>
                                    {{$variants->description}}
                                </td>
                                <td>
                                    {{$variants->quantity}}
                                </td>
                                <td>
                                    {{$variants->price}}
                                </td>
                                <td>
                                    {{floatval(Settings::get('sales_tax'))}}
                                </td>
                                <td>
                                    {{$variants->sub_total}}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('quotation.total')}}</label>

            <div class="controls">
                {{ $saleorder->total }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('quotation.tax_amount')}}</label>

            <div class="controls">
                {{ $saleorder->tax_amount }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('quotation.grand_total')}}</label>

            <div class="controls">
                {{ $saleorder->grand_total }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('quotation.discount').' %'}}</label>

            <div class="controls">
                {{ $saleorder->discount }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('quotation.final_price')}}</label>

            <div class="controls">
                {{ $saleorder->final_price }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('quotation.terms_and_conditions')}}</label>

            <div class="controls">
                {{ $saleorder->terms_and_conditions }}
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                @if (@$action == 'show')
                    <a href="{{ url($type) }}" class="btn btn-primary"><i
                                class="fa fa-arrow-left"></i> {{trans('table.close')}}</a>
                @endif
            </div>
        </div>
    </div>
</div>