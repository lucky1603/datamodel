@extends('layouts.show')

@section('extras')
    <div class="row justify-content-center">
        <p class="column-title">Ugovori</p>
    </div>
    @if($model->getContracts()->count() > 0)
        <?php $contract = $model->getContracts()->first();?>
        <a href="{{ route('contracts.show', $contract->instance->id) }}">{{ $contract->getData()['name'] }}</a>
    @endif
@endsection

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
                <a href="{{ route('clients.invite', $model->getId()) }}" class="btn btn-lg btn-primary">Poziv na sastanak</a>
                @break
            @case('4')
                <a href="{{ route('clients.confirm', $model->getId()) }}" class="btn btn-lg btn-primary">Potvrda datuma</a>
                @break
            @case('5')
                <a href="{{ route('clients.select', $model->getId()) }}" class="btn btn-lg btn-primary">Finalna selekcija</a>
                @break
            @case('6')
                <a href="{{ route('clients.assign', $model->getId()) }}" class="btn btn-lg btn-primary">Dodela prostora</a>
                @break
            @case('8')
                <a href="{{ route('clients.assignContractDate', $model->getId()) }}" class="btn btn-lg btn-primary">Poziv na potpis ugovora</a>
                @break
            @case('9')
                <a href="{{ route('clients.confirmContractDate', $model->getId()) }}" class="btn btn-lg btn-primary">Potvrda datuma potpisa ugovora</a>
                @break
            @case('10')
                <a href="{{ route('contracts.create', $model->getId()) }}" class="btn btn-lg btn-primary">Potpis ugovora</a>
                @break
        @endswitch
    @endif
@endsection
