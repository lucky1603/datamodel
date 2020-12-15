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
    @foreach($companies as $company)
        <p>{{ $company->getData()['name'] }}</p>
    @endforeach
@endsection
