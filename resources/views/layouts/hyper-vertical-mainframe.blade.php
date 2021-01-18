@extends('layouts.hyper-vertical')

@section('sidemenu')
    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
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
            @if(App\Business\Client::getApplicantsNumber() > 0 )
                <span class="badge badge-warning float-right">
                    {{ App\Business\Client::getApplicantsNumber() }}
                </span>
            @endif
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
    @else
        <li class="side-nav-item" id="link_profile">
            <a href="{{route('clients.profile', \Illuminate\Support\Facades\Auth::user()->client()->getId())}}" class="side-nav-link">
                <i class="uil-dashboard"></i>
                <span>{{ strtoupper( __('Profile')) }}</span>
            </a>
        </li>

        @if(isset($model) && $model->getData()['status'] > 2)
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
    @endif

@endsection
