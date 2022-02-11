@extends('layouts.hyper-vertical')

{{--@section('page-title')--}}
{{--    {{ mb_strtoupper(__('Send Reminder')) }}--}}
{{--@endsection--}}

@section('page-header')
    <span class="h4" style="position: relative; top:3vh; left: 2vh">{{ mb_strtoupper(__('Send Reminder')) }}</span>
@endsection

@section('content')
    @php
        foreach (['name', 'profile_state', 'is_company', 'ntp', 'page'] as $key) {
            \Illuminate\Support\Facades\Session::forget($key);
        }
    @endphp

    <div class="container">
        <bulk-mail content="{{ $content }}" token="{{ $token }}" items_source="/profiles/mailClients"></bulk-mail>
    </div>
@endsection

@section('sidemenu')
    <li class="side-nav-item">
        <a href="{{ route('profiles.prepareMail') }}" class="side-nav-link">
            <i class="uil-user-plus"></i>
            <span>{{ mb_strtoupper( __('Send Reminder')) }}</span>
        </a>
    </li>
    <li>
        <a href="{{route('profiles.index')}}" class="side-nav-link">
            <i class="uil-list-ul"></i>
            <span>{{ mb_strtoupper( __('Back to List')) }}</span>
        </a>
    </li>

@endsection
