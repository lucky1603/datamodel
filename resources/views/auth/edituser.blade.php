@extends('layouts.app')

@section('page-header')
    <span class="h4" style="position: relative; top:3vh; left: 2vh">{{ mb_strtoupper(__('Users')) }}</span>
@endsection

@section('content')
    @php
        foreach (['name', 'profile_state', 'is_company', 'ntp'] as $key) {
            \Illuminate\Support\Facades\Session::forget($key);
        }
    @endphp

<h1>{{__('Edit User Data')}}</h1>
<form method="POST" enctype="multipart/form-data" action="{{ route('user.update', $user->id) }}">
    @csrf
    @if(isset($backroute))
        <input type="hidden" id="backroute" name="backroute" value="{{ $backroute }}">
    @endif
    @include('forms.edituser')
</form>
@endsection
