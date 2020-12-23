@extends('layouts.app')

@section('content')
    <h1>{{__('Add New User')}} {{ __('for client') }} - {{ $client->getData()['name'] }}</h1>
    <form method="POST" enctype="multipart/form-data" action="{{ route('user.addedforclient', $client->getId()) }}">
        @csrf
        @include('forms.adduser')
    </form>
@endsection

