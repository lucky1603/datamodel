@extends('layouts.hyper-vertical')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-dark text-light">{{ __('CLIENTS') }}</div>
                <div class="card-body">
                    <a href="{{ route('clients.index') }}"><img src="images/custom/clients.png" width="100%"/></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-dark text-light">{{ __('CONTRACTS') }}</div>
                <div class="card-body">
                    <a href="{{ route('contracts.index') }}"><img src="images/custom/contract.png" width="100%"/></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-dark text-light">{{ __('EVENTS') }}</div>
                <div class="card-body">
                    <img src="images/custom/events.png" width="100%"/>
                </div>
            </div>
        </div>
    </div>
{{--    <example-component style="margin-top: 20px">Anything else.</example-component>--}}

@endsection

@section('sidemenu')
    <li class="side-nav-item">
        <a href="{{route('home')}}" class="side-nav-link">
            <i class="uil-dashboard"></i>
            <span>{{ __('DASHBOARD') }}</span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="{{ route('clients.index') }}" class="side-nav-link">
            <i class="uil-snapchat-square"></i>
            <span>{{ __('CLIENTS') }}</span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="{{ route('contracts.index') }}" class="side-nav-link">
            <i class="uil-bill"></i>
            <span>{{ __('CONTRACTS') }}</span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="{{ route('users') }}" class="side-nav-link">
            <i class="uil-chat-bubble-user"></i>
            <span>{{ __('USERS') }}</span>
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


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            if(!$('#link_home').hasClass('active')) {
                $('#link_home').addClass('active');
            }

            if($('#link_clients').hasClass('active')) {
                $('#link_clients').removeClass('active');
            }

            if($('#link_contracts').hasClass('active')) {
                $('#link_contracts').removeClass('active');
            }
        });
    </script>
@endsection



