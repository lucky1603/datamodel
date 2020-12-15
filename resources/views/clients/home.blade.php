@extends('layouts.hyper-vertical')

@section('content')
    <div class="container">
        <div class="row justify-content-center" style="margin-bottom: 30px">
            <h1>{{ $client->getData()['name'] }}</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-dark text-light">{{ __('Profile View') }}</div>

                    <div class="card-body">
                        <a href="{{ route('clients.show', Auth::user()->client()->getId()) }}"><img src="/images/custom/clients.png"/></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-dark text-light">{{ __('Situations') }}</div>
                    <a href="{{ route('contracts.index') }}"><img src="/images/custom/contract.png"/></a>
                    <div class="card-body">

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-dark text-light">{{ __('Contract Realization') }}</div>
                    <img src="/images/custom/events.png"/>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            if(!$('#link_profile').hasClass('mm-active')) {
                $('#link_profile').addClass('mm-active');
                $('#link_profile').find('a').first().addClass('active');
            }
        });
    </script>
@endsection

@section('sidemenu')
    <li class="side-nav-item" id="link_profile">
        <a href="{{route('clients.show', Auth::user()->client()->getId())}}" class="side-nav-link">
            <i class="uil-dashboard"></i>
            <span>{{ __('PROFILE') }}</span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="{{route('clients.index')}}" class="side-nav-link" id="link_company_list">
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
