<div class="panel panel-primary">
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('lead.opportunity')}}</label>
            <div class="controls">
                    {{ $lead->opportunity }}
            </div>
        </div>
        <a href="{{ url('leadcall/' . $lead->id ) }}" class="btn btn-info">
            <i class="fa fa-phone"></i>  <b>{{$lead->calls()->count()}}</b> {{ trans("table.calls") }}
        </a>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('lead.sales_team')}}</label>
            <div class="controls">
                {{ is_null($lead->salesteam)?"":$lead->salesTeam->salesteam }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('lead.salesperson')}}</label>
            <div class="controls">
                {{ is_null($lead->salesPerson)?"":$lead->salesPerson->full_name }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('lead.customer')}}</label>
            <div class="controls">
                {{ is_null($lead->customerCompany)?"":$lead->customerCompany->name }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('lead.phone')}}</label>
            <div class="controls">
                {{ $lead->phone }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('lead.mobile')}}</label>
            <div class="controls">
                {{ $lead->mobile }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('lead.fax')}}</label>
            <div class="controls">
                {{ $lead->fax }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('lead.priority')}}</label>
            <div class="controls">
                {{ $lead->priority }}
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