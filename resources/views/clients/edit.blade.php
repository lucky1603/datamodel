@extends('layouts.edit')

@section('title')
    <h1 class="page-title">Promenite podatke za - {{ $model->getData()['name'] }}</h1>
@endsection

@section('back')
    <a href="{{route('clients.show', $model->getId())}}" class="btn btn-secondary">Nazad</a>
@endsection
