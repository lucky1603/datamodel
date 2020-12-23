@extends('layouts.app')

@section('content')
    <h1>{{__('Add New User')}}</h1>
    <form method="POST" enctype="multipart/form-data" action="{{ route('user.added', $client->getId()) }}">
        @csrf
        @include('forms.adduser')
    </form>
@endsection
