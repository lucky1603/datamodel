@extends('layouts.hyper-vertical-mainframe')

@section('content')
    @yield('profile-content')
@endsection

@section('sidemenu')
    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
        <li class="side-nav-item" id="navProfile">
            <a href="{{route('profiles.show', ['profile' => $model->getId()])}}" class="side-nav-link">
                <i class="uil-dashboard"></i>
                <span>{{ mb_strtoupper( __('Profile')) }}</span>
            </a>
        </li>

        @if($model->getValue('profile_status') == 8 ||
            ($model->getValue('profile_status') > 4 && $model->getActiveProgram()->getValue('program_type') == \App\Business\Program::$RAISING_STARTS))
            <li class="side-nav-item" id="navEvents">
                <a href="{{route('profiles.trainings', ['profile' => $model->getId()])}}" class="side-nav-link">
                    <i class="uil-bill"></i>
                    <span>{{ mb_strtoupper(__('Events')) }}</span>
                </a>
            </li>

            <li class="side-nav-item" id="navSessions">
                <a href="{{route('profiles.sessions', ['profile' => $model->getId()])}}" class="side-nav-link">
                    <i class="uil-bill"></i>
                    <span>{{ mb_strtoupper(__('Mentoring Sessions')) }}</span>
                </a>
            </li>

            <li class="side-nav-item" id="navReports">
                <a href="{{ route('profiles.reports', ['profile' => $model->getId()]) }}" class="side-nav-link">
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
                <span>{{ mb_strtoupper( __('Profile')) }}</span>
            </a>
        </li>
        @if($model->getValue('profile_status') == 9
            || ($model->getValue('profile_status') > 4 && $model->getActiveProgram()->getValue('program_type') == \App\Business\Program::$RAISING_STARTS))
            <li class="side-nav-item" id="navProfile">
                <a href="{{route('profiles.sessions', ['profile' => $model->getId()])}}" class="side-nav-link">
                    <i class="uil-bill"></i>
                    <span>{{ mb_strtoupper(__('Mentoring Sessions')) }}</span>
                </a>
            </li>
            @endif
        @if($model->getValue('profile_status') == 9 ||
            ($model->getValue('profile_status') > 6 && $model->getActiveProgram()->getValue('program_type') == \App\Business\Program::$RAISING_STARTS))
            <li class="side-nav-item" id="navEvents">
                <a href="{{route('profiles.trainings', ['profile' => $model->getId()])}}" class="side-nav-link">
                    <i class="uil-dashboard"></i>
                    <span>{{ mb_strtoupper( __('Events')) }}</span>
                </a>
            </li>
            <li class="side-nav-item" id="navReports">
                <a href="#" class="side-nav-link">
                    <i class="uil-dashboard"></i>
                    <span>{{ mb_strtoupper( __('Reports')) }}</span>
                </a>
            </li>
            <li class="side-nav-item" id="navOtherProfiles">
                <a href="#" class="side-nav-link">
                    <i class="uil-dashboard"></i>
                    <span>{{ mb_strtoupper( __('Other Profiles')) }}</span>
                </a>
            </li>
        @endif

    @endif
@endsection



