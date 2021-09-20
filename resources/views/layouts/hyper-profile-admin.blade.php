@extends('layouts.hyper-vertical-profile-shortdata')

@section('profile-content')
    <div class="row" style="height: 95%">
        <div class="col-sm-9 h-100">
            @yield('application-data')
        </div>
        <div class="col-sm-3 h-100 overflow-hidden">
            @yield('activities')
        </div>
    </div>
@endsection
