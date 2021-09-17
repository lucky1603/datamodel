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

    <li class="side-nav-item" id="navEvents">
        <a href="{{route('profiles.trainings', ['profile' => $model->getId()])}}" class="side-nav-link">
            <i class="uil-bill"></i>
            <span>{{ mb_strtoupper(__('Events')) }}</span>
        </a>
    </li>

    <li class="side-nav-item" id="navSessions">
        <a href="{{route('profiles.sessions', ['profile' => $model->getId()])}}" class="side-nav-link">
            <i class="uil-bill"></i>
            <span>{{ mb_strtoupper(__('mentoring Sessions')) }}</span>
        </a>
    </li>

    <li class="side-nav-item" id="navReports">
        <a href="{{ route('profiles.reports', ['profile' => $model->getId()]) }}" class="side-nav-link">
            <i class="uil-bill"></i>
            <span>{{ mb_strtoupper(__('Reports')) }}</span>
        </a>
    </li>

    <li class="side-nav-item mt-4">
        <a href="{{ route('profiles.index') }}" class="side-nav-link">
            <i class="uil-backspace"></i>
            <span>{{ mb_strtoupper(__('Back to List')) }}</span>
        </a>
    </li>
    @else
        <li class="side-nav-item">
            <a href="{{route('profiles.show', ['profile' => $model->getId()])}}" class="side-nav-link">
                <i class="uil-dashboard"></i>
                <span>{{ mb_strtoupper( __('Profile')) }}</span>
            </a>
        </li>

    @endif
@endsection

@section('scripts')

@endsection


