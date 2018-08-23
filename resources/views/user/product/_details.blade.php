<div class="panel panel-primary">
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('product.product_name')}}</label>
            <div class="controls">
                    {{ $product->product_name }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('product.category_id')}}</label>
            <div class="controls">
                {{ $product->category->name }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('product.product_type')}}</label>
            <div class="controls">
                {{ $product->product_type }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('product.status')}}</label>
            <div class="controls">
                {{ $product->status }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('product.quantity_on_hand')}}</label>
            <div class="controls">
                {{ $product->quantity_on_hand }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('product.quantity_available')}}</label>
            <div class="controls">
                    {{ $product->quantity_available }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('product.sale_price')}}</label>
            <div class="controls">
                {{ $product->sale_price }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('product.description')}}</label>
            <div class="controls">
                    {{ $product->description }}
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                @if (@$action == 'show')
                    <a href="{{ url($type) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{trans('table.close')}}</a>
                @else
                    <a href="{{ url($type) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> {{trans('table.delete')}}</button>
                @endif
            </div>
        </div>
    </div>
</div>