@extends('layouts.show')

@section('returns')
    <a href="{{ request()->session()->get('backroute') }}" class="btn btn-lg btn-link btn-outline-info">Back</a>
    <a href="{{ route('clients.edit', $model->getId() ) }}" class="btn btn-lg btn-secondary">Edit</a>
@endsection
