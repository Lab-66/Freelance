@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <meta name="_token" content="{{ csrf_token() }}">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary todolist">
                <div class="panel-heading border-light">
                    <h4 class="panel-title">
                        <i class="livicon" data-name="medal" data-size="18" data-color="white" data-hc="white"
                           data-l="true"></i>
                        {{trans('task.tasks')}}
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="todolist_list adds">
                        {!! Form::open(['class'=>'form', 'id'=>'main_input_box']) !!}
                        {!! Form::hidden('task_from_user',Sentinel::getUser()->id, ['id'=>'task_from_user']) !!}
                        <div class="form-group">
                            {!! Form::label('task_description', trans('task.description')) !!}
                            {!! Form::text('task_description', null, ['class' => 'form-control','id'=>'task_description']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('task_deadline', trans('task.deadline')) !!}
                            {!! Form::text('task_deadline', null, ['class' => 'form-control date','id'=>'task_deadline']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('user_id', trans('task.user')) !!}
                            {!! Form::select('user_id', $users , Sentinel::getUser()->id, ['class' => 'form-control','id'=>'user_id']) !!}
                        </div>
                        {!!  Form::hidden('full_name', $user_data->full_name, ['id'=> 'full_name'])!!}
                        <button type="submit" class="btn btn-primary add_button">
                            Send
                        </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <i class="livicon" data-name="inbox" data-size="18" data-color="white" data-hc="white"
                           data-l="true"></i>
                        My task list
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row list_of_items">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="office-task">
        <?php
           /*  session_start();
               require('cal/oauth.php');
               require('cal/outlook.php');
               //print_r($_SESSION);die();

               //$loggedIn = !is_null($_SESSION['access_token']);
                $loggedIn = !empty($_SESSION['access_token']);
               $redirectUri = 'http://93.158.221.197/files/public/cal/authorize.php';
         if (!$loggedIn) {
  ?>
      <!-- User not logged in, prompt for login -->
      <p>Please <a href="<?php echo oAuthService::getLoginUrl($redirectUri)?>">sign in</a> with your Office 365 or Outlook.com account.</p>
  <?php
    }
    else {
  ?>
      <!-- User is logged in, do something here -->
      <p>Hello user!</p>
  <?php
    }*/
  ?>
    </div>
@stop

{{-- Scripts --}}
@section('scripts')
    <script src="{{ asset('js/todolist.js') }}"></script>
@stop