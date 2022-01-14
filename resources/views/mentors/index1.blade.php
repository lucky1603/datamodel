@extends('layouts.hyper-vertical-mainframe')

@section('content')
    @php
        foreach (['name', 'profile_state', 'is_company', 'ntp', 'page'] as $key) {
            \Illuminate\Support\Facades\Session::forget($key);
        }
    @endphp

    <mentor-explorer></mentor-explorer>
@endsection
