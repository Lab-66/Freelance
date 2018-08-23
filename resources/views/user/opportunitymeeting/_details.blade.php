<div class="panel panel-primary">
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('meeting.meeting_subject')}}</label>

            <div class="controls">
                @if (isset($meeting))
                    {{ $meeting->meeting_subject }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('meeting.starting_date')}}</label>

            <div class="controls">
                @if (isset($meeting))
                    {{ $meeting->starting_date }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('meeting.ending_date')}}</label>

            <div class="controls">
                @if (isset($meeting))
                    {{ $meeting->ending_date }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                @if (@$action == 'show')
                    <a href="{{ url($type.'/'.$opportunity->id) }}"
                       class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{trans('table.close')}}</a>
                @else
                    <a href="{{ url($type.'/'.$opportunity->id) }}"
                       class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> {{trans('table.delete')}}</button>
                @endif
            </div>
        </div>
    </div>
</div>