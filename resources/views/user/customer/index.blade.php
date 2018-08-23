@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')

    <contacts :companies="{{ json_encode($companies) }}"
              :item="{{ $customers->first() }}"
              url="{{ url('customer') }}/"></contacts>

@stop

{{-- Scripts --}}
@section('scripts')

@stop
