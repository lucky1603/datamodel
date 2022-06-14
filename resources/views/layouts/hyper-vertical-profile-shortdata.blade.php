@extends('layouts.hyper-vertical-program')

@section('content')

    @php
        $profile = $program->getProfile();
    @endphp

    <div class="row" >
        <div class="d-none d-xl-block col-xl-3" style="min-height: 450px">
            <profile-data :profile_id="{{ $profile->getId() }}"></profile-data>
            <profile-users :profile_id="{{ $profile->getId() }}" token="{{ csrf_token() }}" :active_user_id="{{ auth()->user()->id }}" class="mt-4"></profile-users>
        </div> <!-- end col-->

        <div class="col-xl-9 col-12" >
            @yield('profile-content')
        </div> <!-- end col -->
    </div>
    <!-- end row-->
@endsection

