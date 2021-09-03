@extends('layouts.hyper-vertical-profile-shortdata')

@section('profile-content')
    <div class="row" style="height: 100%">
        <div class="col-sm-9">
            @yield('application-data')
        </div>
        <div class="col-sm-3" style="height: 100%; overflow: hidden">
            @yield('activities')
        </div>
    </div>
@endsection
