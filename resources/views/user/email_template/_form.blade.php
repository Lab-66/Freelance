<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($emailTemplate))
            {!! Form::model($emailTemplate, array('url' => $type . '/' . $emailTemplate->id, 'method' => 'put', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => $type, 'method' => 'post', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('email_template.title'), array('class' => 'control-label  required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
         <div class="form-group">
            {!! Form::label('Subject', trans('email_template.subject')) !!}
            <div class="controls">
                {!! Form::text('subject', null, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="form-group required {{ $errors->has('text') ? 'has-error' : '' }}">
            {!! Form::label('Text', trans('email_template.text'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::textarea('text', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('text', ':message') }}</span>
            </div>
        </div>
        <!-- Form Actions -->
        <div class="form-group">
            <div class="controls">
                <a href="{{ url($type) }}" class="btn btn-primary"><i
                            class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                <button type="submit" class="btn btn-success"><i
                            class="fa fa-check-square-o"></i> {{trans('table.ok')}}</button>
            </div>
        </div>
        <!-- ./ form actions -->

        {!! Form::close() !!}
    </div>
</div>
