<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($opportunity))
            {!! Form::model($opportunity, array('url' => $type . '/' . $opportunity->id, 'method' => 'put', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => $type, 'method' => 'post', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('opportunity') ? 'has-error' : '' }}">
            {!! Form::label('opportunity', trans('opportunity.opportunity'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('opportunity', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('opportunity', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('stages') ? 'has-error' : '' }}">
            {!! Form::label('stages', trans('opportunity.stages'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('stages', $stages, null, array('id'=>'stages', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('stages', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('expected_revenue') ? 'has-error' : '' }}">
            {!! Form::label('expected_revenue', trans('opportunity.expected_revenue'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('expected_revenue', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('expected_revenue', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('probability') ? 'has-error' : '' }}">
            {!! Form::label('probability', trans('opportunity.probability'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('probability', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('probability', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('customer_id') ? 'has-error' : '' }}">
            {!! Form::label('customer_id', trans('opportunity.customer'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('customer_id', $companies, null, array('id'=>'customer_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('customer_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('email') ? 'has-error' : '' }}">
            {!! Form::label('email', trans('opportunity.email'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::email('email', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('email', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('phone') ? 'has-error' : '' }}">
            {!! Form::label('phone', trans('opportunity.phone'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('phone', null, array('class' => 'form-control','data-fv-integer' => "true")) !!}
                <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('sales_person_id') ? 'has-error' : '' }}">
            {!! Form::label('sales_person_id', trans('opportunity.salesperson'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('sales_person_id', $staffs, null, array('id'=>'sales_person_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('sales_person_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('sales_team_id') ? 'has-error' : '' }}">
            {!! Form::label('sales_team_id', trans('opportunity.salesteam'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('sales_team_id', $salesteams, null, array('id'=>'sales_team_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('sales_team_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('next_action') ? 'has-error' : '' }}">
            {!! Form::label('next_action', trans('opportunity.next_action'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('next_action', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('next_action', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('next_action_title') ? 'has-error' : '' }}">
            {!! Form::label('next_action_title', trans('opportunity.next_action_title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('next_action_title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('next_action_title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('expected_closing') ? 'has-error' : '' }}">
            {!! Form::label('expected_closing', trans('opportunity.expected_closing'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('expected_closing', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('expected_closing', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('priority') ? 'has-error' : '' }}">
            {!! Form::label('priority', trans('opportunity.priority'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('priority', $priority, null, array('id'=>'priority','class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('priority', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('tags') ? 'has-error' : '' }}">
            {!! Form::label('tags', trans('opportunity.tags'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('tags[]', $tags, (isset($opportunity)?explode(',',$opportunity->tags):null), array('id'=>'tags','multiple'=>true, 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('tags', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('assigned_partner_id') ? 'has-error' : '' }}">
            {!! Form::label('assigned_partner_id', trans('opportunity.assigned_partner_id'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('assigned_partner_id', $companies, null, array('id'=>'assigned_partner_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('assigned_partner_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('internal_notes') ? 'has-error' : '' }}">
            {!! Form::label('internal_notes', trans('opportunity.internal_notes'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('internal_notes', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('internal_notes', ':message') }}</span>
            </div>
        </div>
        <!-- Form Actions -->
        <div class="form-group">
            <div class="controls">
                <a href="{{ route($type.'.index') }}" class="btn btn-primary"><i
                            class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> {{trans('table.ok')}}
                </button>
            </div>
        </div>
        <!-- ./ form actions -->

        {!! Form::close() !!}
    </div>
</div>

@section('scripts')
    <script>
        //Stages Select
        $(function () {
            $('#stages').change(function () {
                var stage = $(this).val();
                if (stage == 'New' || stage == 'Lost' || stage == 'Dead') {
                    $('#probability').val(0);
                }
                if (stage == 'Qualification') {
                    $('#probability').val(20);
                }
                if (stage == 'Proposition') {
                    $('#probability').val(40);
                }
                if (stage == 'Negotiation') {
                    $('#probability').val(60);
                }
                if (stage == 'Won') {
                    $('#probability').val(100);
                }
            }).change();
        });
    </script>
@endsection
