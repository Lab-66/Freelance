<div class="panel panel-primary">
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('opportunity.opportunity')}}</label>
            <div class="controls">
                {{ $opportunity->opportunity }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('opportunity.next_action')}}</label>
            <div class="controls">
                {{ $opportunity->next_action }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('opportunity.next_action_title')}}</label>
            <div class="controls">
                {{ $opportunity->next_action_title }}
            </div>
        </div>
        <div class="form-group">
        <a href="{{ url('opportunitycall/' . $opportunity->id ) }}" class="btn btn-info">
            <i class="fa fa-phone"></i>  <b>{{$opportunity->calls()->count()}}</b> {{ trans("table.calls") }}
        </a>
        </div>
        <div class="form-group">
            <a href="{{ url('opportunitycall/' . $opportunity->id ) }}" class="btn btn-info">
                <i class="fa fa-users"></i>  <b>{{$opportunity->meetings()->count()}}</b> {{ trans("opportunity.meetings") }}
            </a>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('opportunity.stages')}}</label>
            <div class="controls">
                {{ $opportunity->stages }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('opportunity.expected_revenue')}}</label>
            <div class="controls">
                {{ $opportunity->expected_revenue }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('opportunity.customer')}}</label>
            <div class="controls">
                {{ is_null($opportunity->customer)?"":$opportunity->customer->name }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('opportunity.email')}}</label>
            <div class="controls">
                {{ $opportunity->email }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('opportunity.phone')}}</label>
            <div class="controls">
                {{ $opportunity->phone }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('opportunity.salesperson')}}</label>
            <div class="controls">
                {{ is_null($opportunity->salesPerson)?"":$opportunity->salesPerson->full_name }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('opportunity.salesteam')}}</label>
            <div class="controls">
                {{ is_null($opportunity->salesTeam)?"":$opportunity->salesTeam->salesteam }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('opportunity.priority')}}</label>
            <div class="controls">
                {{ $opportunity->priority }}
            </div>
        </div>
        @if (@$action == 'won')
            @if($user_data->hasAccess(['quotations.write']) || $user_data->inRole('admin'))
                <div class="page-header clearfix">
                    <a href="{{ url($type . '/'.$opportunity->id.'/convert_to_quotation/') }}"
                       class="btn btn-primary" target="">{{trans('opportunity.convert_to_quotation')}}</a>
                </div>
            @endif
        @elseif(@$action == 'lost')
            {!! Form::model($opportunity, array('url' => $type . '/' . $opportunity->id.'/update_lost', 'method' => 'post', 'files'=> true)) !!}
            <div class="form-group {{ $errors->has('lost_reason') ? 'has-error' : '' }}">
                {!! Form::label('lost_reason', trans('opportunity.lost_reason'), array('class' => 'control-label')) !!}
                <div class="controls">
                    {!! Form::select('lost_reason', $lost_reason, null, array('id'=>'lost_reason','class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('lost_reason', ':message') }}</span>
                </div>
            </div>
        @endif
        <div class="form-group">
            <div class="controls">
                @if (@$action == 'show')
                    <a href="{{ url($type) }}" class="btn btn-primary"><i
                                class="fa fa-arrow-left"></i> {{trans('table.close')}}</a>
                @elseif (@$action == 'lost' || @$action == 'won')
                    <a href="{{ url($type) }}" class="btn btn-primary"><i
                                class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                    <button type="submit" class="btn btn-success"><i
                                class="fa fa-check-square-o"></i> {{trans('table.ok')}}
                    </button>
                    {!! Form::close() !!}
                @else
                    <a href="{{ url($type) }}" class="btn btn-primary"><i
                                class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> {{trans('table.delete')}}
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>