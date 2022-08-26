@extends('layouts.hyper-vertical-profile')

@section('page-header')
    <div class="w-50 d-inline-block" style="height: 7vh">
        <div><span class="h4" style="position: relative; top:2vh; left: 1vh">{{ $model->getValue('name') }}</span></div>
        <div><span class="text-primary font-12" style="position: relative; top: 2vh; left: 1vh">{{ mb_strtoupper($model->getText('profile_status')) }}</span></div>
    </div>
@endsection

@section('profile-content')
    @php
        $data = $model->getData();
        $programs = $model->getPrograms();
        $token = csrf_token();
        $role = auth()->user()->roles->first()->name;
    @endphp

    <profile-view :profile_id="{{ $model->getId() }}" token="{{ $token }}" :active_user_id="{{ auth()->user()->id }}" user_type="{{ $role }}" ></profile-view>

@endsection
