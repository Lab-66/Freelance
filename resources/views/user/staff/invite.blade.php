@extends('layouts.user')
@section('title')
    {{ $title }}
@stop
@section('content')
    <div class="panel panel-primary">
        <div class="panel-body">
            {!! Form::open(array('url' => $type.'/invite', 'method' => 'post', 'files'=> true)) !!}
            <div class="form-group required {{ $errors->has('email') ? 'has-error' : '' }}">
                {!! Form::label('email', trans('staff.emails'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::text('emails', null, array('class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    <a href="{{ route($type.'.index') }}" class="btn btn-primary"><i
                                class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                    <button type="submit" class="btn btn-success"><i
                                class="fa fa-check-square-o"></i> {{trans('table.ok')}}</button>
                </div>
            </div>
            {!! Form::close() !!}
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-striped table-bordered dataTable no-footer">
                        <thead>
                        <td>{{trans('staff.email')}}</td>
                        <td>{{trans('staff.send_invitation')}}</td>
                        <td>{{trans('staff.accept_invitation')}}</td>
                        </thead>
                        <tbody>
                        @foreach ($user_data->invite as $item)
                            <tr>
                                <td>{{$item->email}}</td>
                                <td>{{$item->created_at->format($date_format)}}</td>
                                <td>{{isset($item->claimed_at)?$item->claimed_at->format($date_format):""}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection