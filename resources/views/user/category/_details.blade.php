<div class="panel panel-primary">
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('category.name')}}</label>

            <div class="controls">
                @if (isset($category))
                    {{ $category->name }}
                @endif
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