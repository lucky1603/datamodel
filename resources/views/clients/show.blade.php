@extends('layouts.show')

@section('returns')
    <a href="{{ request()->session()->get('backroute') }}" class="btn btn-lg btn-link btn-outline-info">Back</a>
    <a href="{{ route('clients.edit', $model->getId() ) }}" class="btn btn-lg btn-secondary">Edit</a>
    @if(auth()->user()->isAdmin())
        @switch($model->getData()['status'])
            @case('1')
            <a href="{{ route('clients.register', $model->getId()) }}" class="btn btn-lg btn-primary">Registracija</a>
            @break
            @case('2')
                <a href="{{ route('clients.preselect', $model->getId()) }}" class="btn btn-lg btn-primary">Predselekcija</a>
                @break
            @case('3')
                <a href="#" class="btn btn-lg btn-primary">Poziv na sastanak</a>
                @break
        @endswitch
    @endif
@endsection
