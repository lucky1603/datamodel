@extends('layouts.hyper-vertical-program')

@section('page-header')
    <div class="w-50 d-inline-block" style="height: 7vh">
        <div><span class="h4" style="position: relative; top:2vh; left: 1vh">{{ $profile->getValue('name') }}</span></div>
        <div><span class="text-primary font-12" style="position: relative; top: 2vh; left: 1vh">MENTORSKE SESIJE</span></div>
    </div>
@endsection

@section('profile-content')
    <program-sessions
        :programid="{{ $program->getId() }}"
        usertype="{{ $profile->getUsers()->first()->roles->first()->name }}"></program-sessions>
@endsection
