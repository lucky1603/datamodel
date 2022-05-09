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
            <a href="{{route('profiles.show', ['profile' => $model->getId()])}}" class="side-nav-link">
                <i class="uil-dashboard"></i>
                <span>{{ mb_strtoupper( __('Application')) }}</span>
            </a>
        </li>

{{--        @if($program instanceof \App\Business\RaisingStartsProgram &&--}}
{{--            ( $program->getStatus() > 2 || $program->getStatus() == \App\Business\Program::$PROGRAM_ACTIVE ))--}}
{{--            <li class="side-nav-item" id="navEvents">--}}
{{--                <a href="{{route('profiles.trainings', ['profile' => $profile->getId()])}}" class="side-nav-link">--}}
{{--                    <i class="uil-bill"></i>--}}
{{--                    <span>{{ mb_strtoupper(__('Events')) }}</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        @elseif($program->getStatus() == \App\Business\Program::$PROGRAM_ACTIVE)--}}
{{--            <li class="side-nav-item" id="navEvents">--}}
{{--                <a href="{{route('profiles.trainings', ['profile' => $profile->getId()])}}" class="side-nav-link">--}}
{{--                    <i class="uil-bill"></i>--}}
{{--                    <span>{{ mb_strtoupper(__('Events')) }}</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        @endif--}}

{{--        @if($program instanceof \App\Business\RaisingStartsProgram &&--}}
{{--            ($program->getStatus()) > 3 || $program->getStatus() == \App\Business\Program::$PROGRAM_ACTIVE))--}}

{{--            <li class="side-nav-item" id="navSessions">--}}
{{--                <a href="{{route('profiles.sessions', ['profile' => $profile->getId()])}}" class="side-nav-link">--}}
{{--                    <i class="uil-bill"></i>--}}
{{--                    <span>{{ mb_strtoupper(__('Mentoring Sessions')) }}</span>--}}
{{--                </a>--}}
{{--            </li>--}}

{{--            <li class="side-nav-item" id="navReports">--}}
{{--                <a href="{{route('reports.programReports', ['program' => $program->getId()])}}" class="side-nav-link">--}}
{{--                    <i class="uil-bill"></i>--}}
{{--                    <span>{{ mb_strtoupper(__('Reports')) }}</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        @elseif($program->getStatus() == \App\Business\RaisingStartsProgram::$PROGRAM_ACTIVE)--}}
{{--            <li class="side-nav-item" id="navSessions">--}}
{{--                <a href="{{route('profiles.sessions', ['profile' => $profile->getId()])}}" class="side-nav-link">--}}
{{--                    <i class="uil-bill"></i>--}}
{{--                    <span>{{ mb_strtoupper(__('Mentoring Sessions')) }}</span>--}}
{{--                </a>--}}
{{--            </li>--}}

{{--            <li class="side-nav-item" id="navReports">--}}
{{--                <a href="{{route('reports.programReports', ['program' => $program->getId()])}}" class="side-nav-link">--}}
{{--                    <i class="uil-bill"></i>--}}
{{--                    <span>{{ mb_strtoupper(__('Reports')) }}</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        @endif--}}

        <li class="side-nav-item mt-4">
            <a href="{{ route('profiles.index') }}" class="side-nav-link">
                <i class="uil-backspace"></i>
                <span>{{ mb_strtoupper(__('Back to List')) }}</span>
            </a>
        </li>
    @else
        <li class="side-nav-item">
            <a href="{{route('profiles.show', ['profile' => $profile->getId()])}}" class="side-nav-link">
                <i class="uil-dashboard"></i>
                <span>{{ mb_strtoupper( __('Moji podaci')) }}</span>
            </a>
        </li>

        <li class="side-nav-item">
            <a href="javascript:void(0);" class="side-nav-link" aria-expanded="false">
                <i class="uil-user-exclamation"></i>
                <span>{{ mb_strtoupper( __('Moji programi') ) }}</span>
                <span class="menu-arrow"></span>
            </a>
            @php
                $programs = $profile->getPrograms();
            @endphp

            <ul class="side-nav-second-level mm-collapse" aria-expanded="false">
                @if(count($programs) > 0)
                    @foreach($programs as $program)
                        <li><a href="{{ route('programs.profile', ['program' => $program->getId()]) }}">{{ mb_strtoupper($program->getValue('program_name')) }}</a></li>
                    @endforeach
                @endif
                <li><a href="{{ route('programs.create') }}">{{ mb_strtoupper(__("New Program")) }}</a></li>
            </ul>
        </li>
    @endif
@endsection



