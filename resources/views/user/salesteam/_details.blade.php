<div class="panel panel-primary">
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('salesteam.salesteam')}}</label>
            <div class="controls">
                    {{ $salesteam->salesteam }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('salesteam.invoice_target')}}</label>
            <div class="controls">
                {{ $salesteam->invoice_target }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('salesteam.invoice_forecast')}}</label>
            <div class="controls">
                {{ $salesteam->invoice_forecast }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('salesteam.actual_invoice')}}</label>
            <div class="controls">
                {{ $salesteam->actualInvoice->sum('grand_total')}}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('salesteam.actual_invoices')}}</label>
            <div class="controls">
                <ul>
                    @foreach($salesteam->actualInvoice as $item)
                        <li><a href="{{url('invoice/'.$item->id.'/show')}}">{{ $item->invoice_number }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('salesteam.team_leader')}}</label>
            <div class="controls">
                {{ is_null($salesteam->teamLeader)?"":$salesteam->teamLeader->full_name }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('salesteam.responsibility')}}</label>
            <div class="controls">
                <label>
                    <input type="checkbox" value="1" name="quotations" class='icheck' disabled
                           @if(isset($salesteam) && $salesteam->quotations==1) checked @endif>
                    {{trans('salesteam.quotations')}} </label>
                <label>
                    <input type="checkbox" value="1" name="leads" class='icheck' disabled
                           @if(isset($salesteam) && $salesteam->leads==1) checked @endif>
                    {{trans('salesteam.leads')}} </label>
                <label>
                    <input type="checkbox" value="1" name="opportunities" class='icheck' disabled
                           @if(isset($salesteam) && $salesteam->opportunities==1) checked @endif>
                    {{trans('salesteam.opportunities')}} </label>
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

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.icheck').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
        });
    </script>
@stop