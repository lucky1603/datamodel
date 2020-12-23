@extends('layouts.app')

@section('content')
<h1>{{__('Edit User Data')}}</h1>
<form method="POST" enctype="multipart/form-data" action="{{ route('user.update', $user->id) }}">
    @csrf
    @include('forms.edituser')
</form>
@endsection

