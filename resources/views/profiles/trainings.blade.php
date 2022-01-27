@extends('layouts.hyper-vertical-profile')

@section('profile-content')
    @php
        $profileId = $model->getId();
    @endphp
    <event-explorer source="{{ route('profiles.programAttendances', ['profile' => $profileId]) }}" :can_create="false" :is_client="true"></event-explorer>
@endsection
@section ('scripts')

@endsection
