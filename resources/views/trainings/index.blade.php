@extends('layouts.hyper-vertical-mainframe')

{{--@section('page-title')--}}
{{--    {{ mb_strtoupper(__('Events')) }}--}}
{{--@endsection--}}

@section('page-header')
    <span class="h4" style="position: relative; top:3vh; left: 2vh">{{ mb_strtoupper(__('Events')) }}</span>
@endsection

@section('content')
    @php
        foreach (['name', 'profile_state', 'is_company', 'ntp', 'page'] as $key) {
            \Illuminate\Support\Facades\Session::forget($key);
        }
    @endphp

    <event-explorer :can_create="true"></event-explorer>
@endsection




