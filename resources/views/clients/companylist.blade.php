@extends('layouts.hyper-vertical')

@section('sidemenu')
    <li class="side-nav-item" id="link_profile">
        <a href="{{route('clients.profile', Auth::user()->client()->getId())}}" class="side-nav-link">
            <i class="uil-dashboard"></i>
            <span>{{ __('PROFILE') }}</span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="{{route('clients.companylist')}}" class="side-nav-link" id="link_company_list">
            <i class="uil-dashboard"></i>
            <span>{{ __('COMPANY LIST') }}</span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="javascript: void(0);" class="side-nav-link">
            <i class="uil-home-alt"></i>
            <span class="badge badge-success float-right">4</span>
            <span> {{ __('REALIZATION') }} </span>
        </a>
        <ul class="side-nav-second-level" aria-expanded="false">
            <li>
                <a href="{{ route('clients.index') }}" id="link_resources">{{__('RESOURCES')}}</a>
            </li>
            <li>
                <a href="{{ route('contracts.index') }}" id="link_trainings">{{ __('TRAININGS') }}</a>
            </li>
            <li>
                <a href="#" id="link_other">{{ __('OTHER SERVICES') }}</a>
            </li>
        </ul>
    </li>
@endsection

@section('content')
    @foreach($companies as $client)
        @if($loop->iteration % 4 == 1)
            <div class="row">
                @endif

                <div class="col-md-3">
                    <div class="card shadow-sm ribbon-box" data-id="{{ $loop->iteration }}" style="margin-top:10px; margin-bottom: 10px">

                            <div class="card-body" style="padding: 0" >
                                @if($client->getData()['status'] <= 10)
                                    <div class="ribbon-two ribbon-two-warning">
                                        <span>{{ strtoupper( __('Candidate')) }}</span>
                                    </div>
                                @else
                                    <div class="ribbon-two ribbon-two-success">
                                        <span>{{ strtoupper(__('Member')) }}</span>
                                    </div>
                                @endif
                                <div id="img-container" class="image-container">
                                    <img src="@if( $client->getAttribute('profile_background') != null && strlen($client->getAttribute('profile_background')->getValue()['filelink']) > 0 ) {{ $client->getAttribute('profile_background')->getValue()['filelink'] }} @else /images/custom/backdefault.jpg @endif" class="image-container-profile"/>
                                    <img class="shadow image-container-logo" src="{{ $client->getAttribute('logo') != null && strlen($client->getAttribute('logo')->getValue()['filelink']) > 0 ? $client->getAttribute('logo')->getValue()['filelink'] : '/images/custom/avatar-default.png' }}" />
                                </div>

                                <h4 class="text-center mt-5 mb-2 text-secondary">{{ $client->getData()['name'] }}</h4>
                                @if(isset($client->getData()['website']) && strlen($client->getData()['website']) > 0)
                                    <a href="{{ $client->getData()['website']  }}" target="_blank">
                                @endif
                                <address class="text-center text-primary">{{ !isset($client->getData()['website']) || strlen($client->getData()['website']) == 0 ? __('Website missing') : $client->getData()['website'] }}</address>
                                @if(isset($client->getData()['website']) && strlen($client->getData()['website']) > 0)
                                    </a>
                                @endif
                            </div>
                        </div>
                </div>

                @if($loop->iteration % 4 == 0 || $loop->iteration == $companies->count())
            </div>
        @endif

    @endforeach
@endsection

@section('search')
    <div class="app-search dropdown d-none d-lg-block">
        <form>
            <div class="input-group">
                <input type="text" class="form-control dropdown-toggle" placeholder="Search..." id="top-search">
                <span class="mdi mdi-magnify search-icon"></span>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>

        </form>

{{--        <div class="dropdown-menu dropdown-menu-animated dropdown-lg" id="search-dropdown">--}}
{{--            <!-- item-->--}}
{{--            <div class="dropdown-header noti-title">--}}
{{--                <h5 class="text-overflow mb-2">Found <span class="text-danger">17</span> results</h5>--}}
{{--            </div>--}}

{{--            <!-- item-->--}}
{{--            <a href="javascript:void(0);" class="dropdown-item notify-item">--}}
{{--                <i class="uil-notes font-16 mr-1"></i>--}}
{{--                <span>Analytics Report</span>--}}
{{--            </a>--}}

{{--            <!-- item-->--}}
{{--            <a href="javascript:void(0);" class="dropdown-item notify-item">--}}
{{--                <i class="uil-life-ring font-16 mr-1"></i>--}}
{{--                <span>How can I help you?</span>--}}
{{--            </a>--}}

{{--            <!-- item-->--}}
{{--            <a href="javascript:void(0);" class="dropdown-item notify-item">--}}
{{--                <i class="uil-cog font-16 mr-1"></i>--}}
{{--                <span>User profile settings</span>--}}
{{--            </a>--}}

{{--            <!-- item-->--}}
{{--            <div class="dropdown-header noti-title">--}}
{{--                <h6 class="text-overflow mb-2 text-uppercase">Users</h6>--}}
{{--            </div>--}}


{{--        </div>--}}
    </div>
@endsection
