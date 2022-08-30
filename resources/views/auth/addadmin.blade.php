@extends('layouts.app')

@section('content')
    <h1>{{__('Add New Admin')}}</h1>
    <form method="POST" id="addUserForm" enctype="multipart/form-data" action="{{ route('user.adminadded') }}">
        @csrf
        @php
            $akcija = '/edituser/adminadded';
        @endphp
        @include('forms.adduser')
    </form>
@endsection
