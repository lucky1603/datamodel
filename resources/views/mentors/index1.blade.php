@extends('layouts.hyper-vertical-mainframe')

@php
    $locale = session('locale');
    if($locale == null) {
        $locale = app()->getLocale();
    } else {
        app()->setLocale($locale);
    }

@endphp

@section('page-header')
    <span class="h4" style="position: relative; top:3vh; left: 2vh">{{ mb_strtoupper(__('Mentors List')) }}</span>
@endsection


@section('content')
    @php
        foreach (['name', 'profile_state', 'is_company', 'ntp', 'page'] as $key) {
            \Illuminate\Support\Facades\Session::forget($key);
        }
    @endphp

    <mentor-explorer row_count="2"></mentor-explorer>
@endsection
