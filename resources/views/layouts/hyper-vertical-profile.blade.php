@extends('layouts.hyper-vertical-mainframe')

@section('content')
    @yield('profile-content')
@endsection

@php
    $profile_status = $model->getValue('profile_status');
@endphp

@section('sidemenu')
    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
        <li class="side-nav-item" id="navProfile">
            <a href="{{route('profiles.show', ['profile' => $model->getId()])}}" class="side-nav-link">
                <i class="uil-dashboard"></i>
                <span>{{ mb_strtoupper( __('Application')) }}</span>
            </a>
        </li>

        @if($profile_status == 4 ||
            ($profile_status == 3 &&
            $model->getActiveProgram() instanceof \App\Business\RaisingStartsProgram &&
            $model->getActiveProgram()->getStatus() > 2))
            <li class="side-nav-item" id="navEvents">
                <a href="{{route('profiles.trainings', ['profile' => $model->getId()])}}" class="side-nav-link">
                    <i class="uil-bill"></i>
                    <span>{{ mb_strtoupper(__('Events')) }}</span>
                </a>
            </li>
        @endif
        @if($profile_status == 4 ||
            ($profile_status == 3 &&
            $model->getActiveProgram() instanceof \App\Business\RaisingStartsProgram &&
            $model->getActiveProgram()->getStatus()) > 3)

            <li class="side-nav-item" id="navSessions">
                <a href="{{route('profiles.sessions', ['profile' => $model->getId()])}}" class="side-nav-link">
                    <i class="uil-bill"></i>
                    <span>{{ mb_strtoupper(__('Mentoring Sessions')) }}</span>
                </a>
            </li>

            <li class="side-nav-item" id="navReports">
                <a href="{{route('reports.programReports', ['program' => $model->getActiveProgram()->getId()])}}" class="side-nav-link">
                    <i class="uil-bill"></i>
                    <span>{{ mb_strtoupper(__('Reports')) }}</span>
                </a>
            </li>
        @endif

        <li class="side-nav-item mt-4">
            <a href="{{ route('profiles.index') }}" class="side-nav-link">
                <i class="uil-backspace"></i>
                <span>{{ mb_strtoupper(__('Back to List')) }}</span>
            </a>
        </li>
    @else
        <li class="side-nav-item">
            <a href="{{route('profiles.profile', ['profile' => $model->getId()])}}" class="side-nav-link">
                <i class="uil-dashboard"></i>
                <span>{{ mb_strtoupper( __('Application')) }}</span>
            </a>
        </li>
        @if($profile_status == 4 ||
            ($profile_status == 3 && $model->getActiveProgram() instanceof \App\Business\RaisingStartsProgram && $model->getActiveProgram()->getStatus() >= 3))
            <li class="side-nav-item" id="navProfile">
                <a href="{{route('profiles.trainings', ['profile' => $model->getId()])}}" class="side-nav-link">
                    <i class="uil-bill"></i>
                    <span>{{ mb_strtoupper(__('Events')) }}</span>
                </a>
            </li>
        @endif
        @if($profile_status == 4 ||
            ($profile_status == 3 &&
             $model->getActiveProgram() instanceof \App\Business\RaisingStartsProgram &&
             $model->getActiveProgram()->getStatus() == 5))
            <li class="side-nav-item" id="navEvents">
                <a href="{{route('profiles.sessions', ['profile' => $model->getId()])}}" class="side-nav-link">
                    <i class="uil-dashboard"></i>
                    <span>{{ mb_strtoupper( __('Mentoring Sessions')) }}</span>
                </a>
            </li>
            <li class="side-nav-item" id="navOtherProfiles">
                <a href="#" class="side-nav-link">
                    <i class="uil-dashboard"></i>
                    <span>{{ mb_strtoupper( __('Other Profiles')) }}</span>
                </a>
            </li>
        @endif
        @if($profile_status == 4)
        <li class="side-nav-item">
            <a href="{{route('reports.programReports', ['program' => $model->getActiveProgram()->getId()])}}" class="side-nav-link">
                <i class="uil-dashboard"></i>
                <span>{{ mb_strtoupper( __('Reports')) }}</span>
            </a>
        </li>
    @endif

    @endif
@endsection



