@extends('layouts.hyper-vertical')

@section('sidemenu')
    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())

    <li class="side-nav-item">
        <a href="javascript:void(0);" class="side-nav-link" aria-expanded="false">
            <i class="uil-dashboard"></i>
            <span>{{ mb_strtoupper( __('Statistics') ) }}</span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="side-nav-second-level mm-collapse" aria-expanded="false">
            <li><a href="{{ route('home') }}">{{ mb_strtoupper(__('RAISING STARTS')) }}</a></li>
            <li><a href="{{ route('profiles.programStatisticsDashboard') }}">{{ mb_strtoupper(__('ZA KOMPANIJE')) }}</a></li>
        </ul>
    </li>

    <li class="side-nav-item">
        <a href="javascript:void(0);" class="side-nav-link" aria-expanded="false">
            <i class="uil-bag"></i>
            <span>{{ mb_strtoupper( __('Companies') ) }}</span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="side-nav-second-level mm-collapse" aria-expanded="false">
            <li><a href="{{ route('profiles.index') }}">{{ mb_strtoupper(__('Lista'))  }}</a></li>
            <li><a href="{{ route('profiles.create') }}">{{ mb_strtoupper(__('Kreiraj novu'))  }}</a></li>
            <li><a href="{{ route('profiles.prepareMail') }}">{{ mb_strtoupper('Pošalji podsetnik') }}</a></li>
        </ul>
    </li>

    <li class="side-nav-item">
        <a href="{{ route('programs.index') }}" class="side-nav-link">
            <i class="uil-laptop-cloud"></i>
            <span>{{ mb_strtoupper(__('Programs')) }}</span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="{{ route('mentors.index') }}" class="side-nav-link">
            <i class="uil-chat-bubble-user"></i>
            <span>{{ strtoupper(__('Mentors')) }}</span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="{{ route('users') }}" class="side-nav-link">
            <i class="uil-users-alt"></i>
            <span>{{ strtoupper(__('Users')) }}</span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="{{ route('trainings') }}" class="side-nav-link">
            <i class="uil-rss-alt"></i>
            <span>{{ mb_strtoupper(__('Events')) }}</span>
        </a>
    </li>
    @elseif(\Illuminate\Support\Facades\Auth::user()->isRole('client'))
        <li class="side-nav-item" id="link_profile">
            <a href="{{route('clients.profile', \Illuminate\Support\Facades\Auth::user()->client()->getId())}}" class="side-nav-link">
                <i class="uil-dashboard"></i>
                <span>{{ strtoupper( __('Profile')) }}</span>
            </a>
        </li>

        @if(isset($model) && $model->getData()['status'] >= 10)
            <li class="side-nav-item">
                <a href="{{route('clients.companylist')}}" class="side-nav-link" id="link_company_list">
                    <i class="uil-dashboard"></i>
                    <span>{{ strtoupper(__('Company List')) }}</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span class="badge badge-success float-right">4</span>
                    <span> {{ strtoupper( __('Realization')) }} </span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{ route('clients.index') }}" id="link_resources">{{ strtoupper(__('Resources'))}}</a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" id="link_trainings">{{ strtoupper( __('SESSIONS')) }}</a>
                        <ul class="side-nav-third-level" aria-expanded="false">
                            <li>
                                <a href="{{ route('trainings.forme') }}" id="link_trainings_for_me"> {{ __('Sessions for me') }}</a>
                            </li>
                            <li>
                                <a href="{{route('trainings.mine')}}" id="link_my_trainings"> {{ __('My Sessions') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" id="link_other">{{ strtoupper( __('Other Services'))}}</a>
                    </li>
                </ul>
            </li>
        @endif
    @else
        <li class="side-nav-item">
            <a href="{{route('home')}}" class="side-nav-link">
                <i class="uil-dashboard"></i>
                <span>{{ strtoupper( __('PROFILE PREVIEW')) }}</span>
            </a>
        </li>
    @endif

@endsection
