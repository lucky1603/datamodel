@extends('layouts.hyper-vertical')

@section('content')
    <div style="width: 100%" class="shadow-sm">
        <div class="pt-1 pb-1 pl-2 pr-2 bg-white mb-0 attribute-label" style="display: table; width: 100%">
            <h4 style="display: table-column; float: left">
                @switch($training->getData()['training_type'])
                    @case(1)
                    {{ strtoupper(__('1 on 1 session'))}}
                    @break
                    @case(2)
                    {{ strtoupper(__('Workshop'))}}
                    @break
                    @case(1)
                    {{  strtoupper( __('Event'))}}
                    @break
                @endswitch
            </h4>
            <a href="{{ route('trainings.mine') }}" class="btn btn-sm btn-dark" style="display: table-column; float: right">< {{ __('Go Back') }}</a>
        </div>
    </div>

    <div style="background-color: white; position: absolute; left: 270px; right: 10px; top: 150px; bottom: 70px; overflow-y: auto" class="shadow-sm">
        <div class="container-fluid pt-1">
            <div class="container">
                @include('trainings.partials.training-info')
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @yield('training-scripts')
    @yield('table-scripts')
@endsection

@section('sidemenu')
    <li class="side-nav-item">
        <a href="{{ route('trainings.mine') }}" class="side-nav-link">
            <i class="uil-laptop-cloud"></i>
            <span>{{ strtoupper(__('Back to Sessions')) }}</span>
        </a>
    </li>
@endsection

