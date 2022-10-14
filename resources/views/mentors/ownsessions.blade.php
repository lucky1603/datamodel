@extends('layouts.hyper-vertical')

@php
    $locale = session('locale');
    if($locale == null) {
        $locale = app()->getLocale();
    } else {
        app()->setLocale($locale);
    }

@endphp

@php
    $mentorId = $mentor->getId();
@endphp

@section('page-header')
    <span class="h4" style="position: relative; top:3vh; left: 2vh">{{ mb_strtoupper(__('Mentoring Sessions')) }} -
        <span class="attribute-label">{{ $mentor->getValue('name') }}</span>
    </span>
@endsection

@section('content')
    <mentor-sessions
        :mentorid="{{ $mentorId }}"
        usertype="{{ \Illuminate\Support\Facades\Auth::user()->roles->first()->name }}"
        token="{{ $token }}"
        programid="{{ $programId }}" title="{{ __('Sessions') }}"></mentor-sessions>
@endsection

@section('sidemenu')
    <li class="side-nav-item" id="navProfile">
        <a href="{{ route('mentors.profile', ['mentor' => $mentorId]) }}" class="side-nav-link">
            <i class="uil-user"></i>
            <span>{{ mb_strtoupper( __('Mentor Profile')) }}</span>
        </a>
    </li>
    <li class="side-nav-item mm-active" id="navSessions">
        <a href="{{ route('mentors.ownsessions', ['mentor' => $mentorId]) }}" class="side-nav-link">
            <i class="uil-users-alt"></i>
            <span>{{ mb_strtoupper( __('Mentoring Sessions')) }}</span>
        </a>
    </li>
    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
    <li class="side-nav-item" id="navGoBack">
        <a href="{{route('mentors.index')}}" class="side-nav-link">
            <i class="uil-backward"></i>
            <span>{{ mb_strtoupper( __('Back to List')) }}</span>
        </a>
    </li>
    @endif
@endsection



