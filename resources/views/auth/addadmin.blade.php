@extends('layouts.app')

@section('content')
    <h1>{{__('Add New Admin')}}</h1>
    <form method="POST" enctype="multipart/form-data" action="{{ route('user.adminadded') }}">
        @csrf
        @include('forms.adduser')
    </form>
@endsection
