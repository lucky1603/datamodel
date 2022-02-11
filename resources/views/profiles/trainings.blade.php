@extends('layouts.hyper-vertical-profile')

{{--@section('page-title')--}}
{{--    {{ $model->getValue('name') }}--}}
{{--@endsection--}}

@section('page-header')
    <div class="w-50 d-inline-block" style="height: 7vh">
        <div><span class="h4" style="position: relative; top:2vh; left: 1vh">{{ $model->getValue('name') }}</span></div>
        <div><span class="text-primary font-12" style="position: relative; top: 2vh; left: 1vh">{{ mb_strtoupper($model->getText('profile_state')) }}</span></div>
    </div>
@endsection

@section('profile-content')
    @php
        $profileId = $model->getId();
    @endphp
    <event-explorer source="{{ route('profiles.programAttendances', ['profile' => $profileId]) }}" :can_create="false" :is_client="true" :profile_id="{{ $profileId }}" :item_height="250"></event-explorer>
@endsection
@section ('scripts')

@endsection
