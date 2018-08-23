@extends('layouts/emails')
@section('content')
    <p>Hello,</p>
    <p>Please click on the following link to accept invitation to create account:</p>
    <p><a href="{!! $inviteUrl !!}">{!! $inviteUrl !!}</a></p>
@stop
