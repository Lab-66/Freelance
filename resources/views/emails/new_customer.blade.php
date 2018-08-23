@extends('layouts/emails')

@section('content')
Hello, <br><br><b>Email:</b> ' . {{$email}} . '. <br> <b>Password:</b> ' .
{{$password}} . '. <br>Please <a href="' . url('singup') . '">click here</a> for login
@stop