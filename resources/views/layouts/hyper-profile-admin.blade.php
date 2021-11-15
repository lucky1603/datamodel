@extends('layouts.hyper-vertical-profile-shortdata')

@section('profile-content')
    <div class="row">
        <div class="col-md-9" style="min-height: 800px">
            @yield('application-data')
        </div>
        <div class="col-md-3 overflow-hidden" style="min-height: 800px">
            @yield('activities')
        </div>
    </div>
@endsection
