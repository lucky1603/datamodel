@extends('layouts.hyper-vertical')

@section('sidemenu')
    <li class="side-nav-item">
        <a href="{{route('home')}}" class="side-nav-link">
            <i class="uil-dashboard"></i>
            <span>{{ strtoupper( __('DASHBOARD')) }}</span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="{{ route('clients.index') }}" class="side-nav-link">
            <i class="uil-snapchat-square"></i>
            <span>{{ strtoupper(__('CLIENTS')) }}</span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="{{ route('contracts.index') }}" class="side-nav-link">
            <i class="uil-bill"></i>
            <span>{{ strtoupper(__('CONTRACTS')) }}</span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="{{ route('users') }}" class="side-nav-link">
            <i class="uil-chat-bubble-user"></i>
            <span>{{ strtoupper(__('USERS')) }}</span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="{{ route('trainings') }}" class="side-nav-link">
            <i class="uil-laptop-cloud"></i>
            <span>{{ strtoupper(__('Sessions')) }}</span>
        </a>
    </li>
    {{--    <li class="side-nav-item">--}}
    {{--        <a href="javascript: void(0);" class="side-nav-link">--}}
    {{--            <i class="uil-home-alt"></i>--}}
    {{--            <span class="badge badge-success float-right">4</span>--}}
    {{--            <span> {{ __('LINKS') }} </span>--}}
    {{--        </a>--}}
    {{--        <ul class="side-nav-second-level" aria-expanded="false">--}}
    {{--            <li>--}}
    {{--                <a href="{{ route('clients.index') }}">{{__('CLIENTS')}}</a>--}}
    {{--            </li>--}}
    {{--            <li>--}}
    {{--                <a href="{{ route('contracts.index') }}">{{ __('CONTRACTS') }}</a>--}}
    {{--            </li>--}}
    {{--            <li>--}}
    {{--                <a href="#">{{ __('EVENTS') }}</a>--}}
    {{--            </li>--}}
    {{--        </ul>--}}
    {{--    </li>--}}
@endsection
