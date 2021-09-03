@extends('layouts.hyper-vertical-mainframe')

@section('content')
        <div class="row" style="height: 100%; overflow: hidden">
            <div class="col-sm-2">
                <div class="card text-center">
                    <div class="card-header p-0">
                        @yield('profile-short-header')
                    </div>
                    <div class="card-body">
                        @yield('profile-short-data')
                        <ul class="social-list list-inline mt-3 mb-0">
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i
                                        class="mdi mdi-facebook"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i
                                        class="mdi mdi-google"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-info text-info"><i
                                        class="mdi mdi-twitter"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i
                                        class="mdi mdi-github-circle"></i></a>
                            </li>
                        </ul>
                    </div> <!-- end card-body -->
                </div> <!-- end card -->

                <!-- Messages-->
                <div class="card">
                    <div class="card-header p-2">
                        <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">

                                <!-- item-->
                                <a href="{{ route('user.add') }}" class="dropdown-item nav-link edituser" data-toggle="modal" data-target="#dialogHost" >{{ __('Add User') }}</a>
                            </div>
                        </div>
                        <h4 class="header-title">{{__('SUPPORT TEAM')}}</h4>
                    </div>
                    <div class="card-body p-1">
                        @yield('users')
                    </div> <!-- end card-body-->
                </div> <!-- end card-->

            </div> <!-- end col-->

            <div class="col-sm-10" style="height: 100%; overflow: auto">
                @yield('profile-content')
            </div> <!-- end col -->
        </div>
        <!-- end row-->
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
            <span>{{ mb_strtoupper(__('Menthoring Sessions')) }}</span>
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

        <li class="side-nav-item mt-4">
            <a href="{{ route('user.logout') }}" class="side-nav-link">
                <i class="uil-backspace"></i>
                <span>{{ mb_strtoupper(__('Logout')) }}</span>
            </a>
        </li>
    @endif
@endsection

@section('scripts')

@endsection


