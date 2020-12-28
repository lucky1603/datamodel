@extends('layouts.app')

@section('content')
<h1>{{__('Edit User Data')}}</h1>
<form method="POST" enctype="multipart/form-data" action="{{ route('user.update', $user->id) }}">
    @csrf
    @if(isset($backroute))
        <input type="hidden" id="backroute" name="backroute" value="{{ $backroute }}">
    @endif
    @include('forms.edituser')
</form>
@endsection

