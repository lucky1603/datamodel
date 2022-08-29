@extends('layouts.hyper-vertical-program')

@section('page-header')
    <div class="w-50 d-inline-block" style="height: 7vh">
        <div><span class="h4" style="position: relative; top:2vh; left: 1vh">{{ $profile->getValue('name') }}</span></div>
        <div><span class="text-primary font-12" style="position: relative; top: 2vh; left: 1vh">MENTORSKE SESIJE</span></div>
    </div>
@endsection

@section('profile-content')
    @php
        $userType = Auth::user()->roles->first()->name;
    @endphp
    <program-sessions
        :programid="{{ $program->getId() }}"
        usertype="{{ $userType }}" token={{ csrf_token() }}></program-sessions>
@endsection
