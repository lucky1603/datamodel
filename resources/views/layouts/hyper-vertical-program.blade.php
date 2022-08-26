@extends('layouts.hyper-vertical-mainframe')

@section('content')
    @yield('profile-content')
@endsection

@php
    $profile = $program->getProfile();
    $profile_status = $profile->getValue('profile_status');
@endphp

@section('sidemenu')
    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
        <li class="side-nav-item" id="navProfile">
            <a href="{{route('programs.show', ['program' => $program->getId()])}}" class="side-nav-link">
                <i class="uil-dashboard"></i>
                <span>{{ mb_strtoupper( __('Preview')) }}</span>
            </a>
        </li>

        @if($program instanceof \App\Business\RaisingStartsProgram &&
            ( $program->getStatus() > 2 || $program->getStatus() == \App\Business\Program::$PROGRAM_ACTIVE ))
            <li class="side-nav-item" id="navEvents">
                <a href="{{route('programs.trainings', ['program' => $program->getId()])}}" class="side-nav-link">
                    <i class="uil-rss-alt"></i>
                    <span>{{ mb_strtoupper(__('Events')) }}</span>
                </a>
            </li>
        {{-- @elseif($program->getStatus() == \App\Business\Program::$PROGRAM_ACTIVE)
            <li class="side-nav-item" id="navEvents">
                <a href="{{route('programs.trainings', ['program' => $program->getId()])}}" class="side-nav-link">
                    <i class="uil-rss-alt"></i>
                    <span>{{ mb_strtoupper(__('Events')) }}</span>
                </a>
            </li> --}}
        @endif

        @if($program->getStatus() == \App\Business\Program::$PROGRAM_ACTIVE)
            <li class="side-nav-item" id="navSessions">
                <a href="{{route('programs.sessions', ['program' => $program->getId()])}}" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span>{{ mb_strtoupper(__('Mentoring Sessions')) }}</span>
                </a>
            </li>

            <li class="side-nav-item" id="navReports">
                <a href="{{route('reports.programReports', ['program' => $program->getId()])}}" class="side-nav-link">
                    <i class="uil-chart-pie-alt"></i>
                    <span>{{ mb_strtoupper(__('Reports')) }}</span>
                    @if ($program->hasReportAlert())
                        {{-- <img src="/images/custom/Button-warning-icon.png" height="16" style="position: relative; top: -12px; left: -12px; height: 24px"/> --}}
                        <img src="/images/custom/Button-warning-icon.png" style="height: 20px" title="Podsetnik za slanje izveštaja">
                    @endif
                </a>

            </li>
        @endif

        <li class="side-nav-item mt-4">
            <a href="{{ route('programs.index') }}" class="side-nav-link">
                <i class="uil-backspace"></i>
                <span>{{ mb_strtoupper(__('Back to List')) }}</span>
            </a>
        </li>
    @else
        <li class="side-nav-item">
            <a href="{{route('programs.profile', ['program' => $program->getId()])}}" class="side-nav-link">
                <i class="uil-dashboard"></i>
                <span>{{ mb_strtoupper( __('Preview')) }}</span>
            </a>
        </li>
        @if(($program instanceof \App\Business\RaisingStartsProgram && $program->getStatus() >= 3) || $program->getStatus() == \App\Business\Program::$PROGRAM_ACTIVE)
            <li class="side-nav-item" id="navProfile">
                <a href="{{route('programs.trainings', ['program' => $program->getId()])}}" class="side-nav-link">
                    <i class="uil-rss-alt"></i>
                    <span>{{ mb_strtoupper(__('Events')) }}</span>
                </a>
            </li>
        @endif
        @if($program->getStatus() == \App\Business\Program::$PROGRAM_ACTIVE )
            <li class="side-nav-item" id="navEvents">
                <a href="{{route('programs.sessions', ['program' => $program->getId()])}}" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span>{{ mb_strtoupper( __('Mentoring Sessions')) }}</span>
                </a>
            </li>
        @endif
        @if($program->getStatus() == \App\Business\Program::$PROGRAM_ACTIVE)
            <li class="side-nav-item">
                <a href="{{route('reports.programReports', ['program' => $program->getId()])}}" class="side-nav-link">
                    <i class="uil-chart-pie-alt"></i>
                    <span>{{ mb_strtoupper( __('Reports')) }}</span>
                    @if ($program->hasReportAlert())
                        <img src="/images/custom/Button-warning-icon.png" style="height: 20px" title="Podsetnik za slanje izveštaja">
                    @endif
                </a>
            </li>
        @endif
        <li class="side-nav-item">
            <a href="{{ route('profiles.show', ['profile' => $profile->getId()]) }}" class="side-nav-link">
                <i class="uil-exit"></i>
                <span>{{ mb_strtoupper(__('Back')) }}</span>
            </a>
        </li>
    @endif
@endsection



