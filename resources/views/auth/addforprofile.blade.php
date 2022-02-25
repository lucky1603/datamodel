@extends('layouts.app')

@section('content')
    <h1>{{__('Add New User')}} {{ __('for profile') }} - {{ $profile->getData()['name'] }}</h1>
    <form method="POST" enctype="multipart/form-data" action="{{ route('user.addedforprofile', $profile->getId()) }}" id="addUserForm">
        @csrf
        @if(isset($backroute))
            <input type="hidden" name="backroute" id="backroute" value="{{ $backroute }}">
        @endif
        @include('forms.adduser', ['akcija' => route('user.addedforprofile', $profile->getId())])
    </form>
@endsection

