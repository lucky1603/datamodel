@extends('layouts.hyper-vertical')

@php
    $locale = session('locale');
    if($locale == null) {
        $locale = app()->getLocale();
    } else {
        app()->setLocale($locale);
    }

@endphp

@section('sidemenu')
    @can('read_statistics')
    <li class="side-nav-item">
        <a href="javascript:void(0);" class="side-nav-link" aria-expanded="false">
            <i class="uil-dashboard"></i>
            <span>{{ mb_strtoupper( __('Statistics') ) }}</span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="side-nav-second-level mm-collapse" aria-expanded="false">
            <li><a href="{{ route('home') }}">{{ mb_strtoupper(__('RAISING STARTS APPLICATIONS')) }}</a></li>
            {{-- <li><a href="{{ route('analytics.RsDashboard') }}">{{ mb_strtoupper(__('RAISING STARTS')) }}</a></li> --}}
            <li><a href="{{ route('profiles.programStatisticsDashboard') }}">{{ mb_strtoupper(__('RAISING STARTS COMPANIES')) }}</a></li>

        </ul>
    </li>
    @endcan

    @can('list_client_profiles')
    <li class="side-nav-item">
        <a href="javascript:void(0);" class="side-nav-link" aria-expanded="false">
            <i class="uil-bag"></i>
            <span>{{ mb_strtoupper( __('Companies') ) }}</span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="side-nav-second-level mm-collapse" aria-expanded="false">
            <li><a href="{{ route('profiles.index') }}">{{ mb_strtoupper(__('List'))  }}</a></li>
            @can('manage_client_profiles')
                <li><a href="{{ route('profiles.create') }}">{{ mb_strtoupper(__('Create New'))  }}</a></li>
                <li><a href="{{ route('profiles.prepareMail') }}">{{ mb_strtoupper(__('Send Reminder')) }}</a></li>
            @endcan
        </ul>
    </li>
    @endcan

    @can('list_programs')
    <li class="side-nav-item">
        <a href="{{ route('programs.index') }}" class="side-nav-link">
            <i class="uil-laptop-cloud"></i>
            <span>{{ mb_strtoupper(__('Programs')) }}</span>
        </a>
    </li>
    @endcan

    @can('list_mentors')
    <li class="side-nav-item">
        <a href="{{ route('mentors.index') }}" class="side-nav-link">
            <i class="uil-chat-bubble-user"></i>
            <span>{{ strtoupper(__('Mentors')) }}</span>
        </a>
    </li>
    @endcan

    @canany('read_user_data', 'manage_forms')
    <li class="side-nav-item">
        <a href="javascript:void(0);" class="side-nav-link" aria-expanded="false">
            <i class="uil-bag"></i>
            <span>{{ mb_strtoupper( __('Administration') ) }}</span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="side-nav-second-level mm-collapse" aria-expanded="false">
            @can('read_user_data')
                <li><a href="{{ route('abilities') }}">{{ mb_strtoupper(__('Abilities'))  }}</a></li>
                <li><a href="{{ route('roles') }}">{{ mb_strtoupper(__('Roles'))  }}</a></li>
                <li><a href="{{ route('users') }}">{{ mb_strtoupper(__('Users')) }}</a></li>
            @endcan
            @can('manage_forms')
                <li><a href="{{ route('forms.showForms') }}">{{ mb_strtoupper(__('Forms')) }}</a></li>
            @endcan
        </ul>
    </li>
    @endcan

    {{-- <li class="side-nav-item">
        <a href="{{ route('trainings') }}" class="side-nav-link">
            <i class="uil-rss-alt"></i>
            <span>{{ mb_strtoupper(__('Events')) }}</span>
        </a>
    </li> --}}

    @can('read_event_data')
    <li class="side-nav-item">
        <a href="javascript:void(0);" class="side-nav-link" aria-expanded="false">
            <i class="uil-dashboard"></i>
            <span>{{ mb_strtoupper( __('Events') ) }}</span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="side-nav-second-level mm-collapse" aria-expanded="false">
            <li><a href="{{ route('trainings') }}">{{ mb_strtoupper(__('List')) }}</a></li>
            <li><a href="{{ route('trainings.showStatistics') }}">{{ mb_strtoupper(__('Statistics')) }}</a></li>
        </ul>
    </li>
    @endcan

@endsection
