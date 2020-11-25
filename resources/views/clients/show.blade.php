@extends('layouts.hyper-profile')

@section('title')
    <div>
        <h3>{{ __('CLIENT PROFILE') }}</h3>
    </div>
@endsection

@section('profile_image')
    {{ $model->getAttribute('profile_background')->getValue()['filelink'] }}
@endsection

@section('logo_image')
    {{ $model->getAttribute('logo')->getValue()['filelink'] }}
@endsection

@section('client_short_data')
    <div style="margin-top: 50px;text-align: center">
        <h4 style="margin-bottom: 20px">{{ $model->getData()['name'] }}</h4>
        <p>{{__('APPLYING FOR:')}}<br>
        <button type="button" class="btn btn-primary" style="width: 100%">{{ $model->getAttribute('program')->getText() }}</button>
    </div>

@endsection

@section('commands')
    <a class="float-right card-link-icon-container" href="{{ route('clients.edit', $model->getId()) }}"><img class="shadow card-link-icon" src="/images/custom/edit-validated-icon.png" title="{{__('Edit')}}"/></a>
    <a class="float-right card-link-icon-container" href="{{  request()->session()->get('backroute')}}"><img class="shadow card-link-icon" src="/images/custom/go-back-icon.png" title="{{ __('Back') }}"/></a>
@endsection

@section('users')
    @foreach($model->instance->users as $user)
        <div class="row" style="display: flex;align-items: center">
            <div class="col-4" style="text-align: center">
                <img src="{{ $user->photo }}" height="75px" />
            </div>
            <div class="col" style="text-align: center">
                <p><strong>{{ $user->name }}</strong><br>{{ $user->position }}
            </div>
        </div>
    @endforeach
@endsection

@section('extras')
    <div class="row justify-content-center">
        <p class="column-title">Ugovori</p>
    </div>
    @if($model->getContracts()->count() > 0)
        <?php $contract = $model->getContracts()->first();?>
        <a href="{{ route('clients.showContract', $model->getId()) }}">{{ $contract->getData()['name'] }}</a>
    @endif
@endsection

@section('returns')

    @if(auth()->user()->isAdmin())
        @switch($model->getData()['status'])
            @case('1')
                <a class="float-right card-link-icon-container" href="{{ route('clients.register', $model->getId()) }}"><img class="shadow card-link-icon" src="/images/custom/Status-mail-task-icon.png" title="{{ __('Registracija') }}"/></a></a>
            @break
            @case('2')
                <a class="float-right card-link-icon-container" href="{{ route('clients.preselect', $model->getId()) }}" ><img class="shadow card-link-icon" src="/images/custom/Status-mail-task-icon.png" title="{{ __('Predselekcija') }}"/></a>
                @break
            @case('3')
                <a class="float-right card-link-icon-container" href="{{ route('clients.invite', $model->getId()) }}" ><img class="shadow card-link-icon" src="/images/custom/Status-mail-task-icon.png" title="{{ __('Poziv na sastanak') }}"/></a>
                @break
            @case('4')
                <a class="float-right card-link-icon-container" href="{{ route('clients.confirm', $model->getId()) }}" ><img class="shadow card-link-icon" src="/images/custom/Status-mail-task-icon.png" title="{{ __('Potvrda datuma') }}"/></a>
                @break
            @case('5')
                <a class="float-right card-link-icon-container" href="{{ route('clients.select', $model->getId()) }}" ><img class="shadow card-link-icon" src="/images/custom/Status-mail-task-icon.png" title="{{ __('Finalna selekcija') }}"/></a>
                @break
            @case('6')
                <a class="float-right card-link-icon-container" href="{{ route('clients.assign', $model->getId()) }}" > <img class="shadow card-link-icon" src="/images/custom/Status-mail-task-icon.png" title="{{ __('Dodela') }}"/></a>
                @break
            @case('8')
                <a class="float-right card-link-icon-container" href="{{ route('clients.assignContractDate', $model->getId()) }}" ><img class="shadow card-link-icon" src="/images/custom/Status-mail-task-icon.png" title="{{ __('Poziv na potpis ugovora') }}"/></a>
                @break
            @case('9')
                <a class="float-right card-link-icon-container" href="{{ route('clients.confirmContractDate', $model->getId()) }}" ><img class="shadow card-link-icon" src="/images/custom/Status-mail-task-icon.png" title="{{ __('Potvrda datuma potpisa ugovora') }}"/></a>
                @break
            @case('10')
                <a class="float-right card-link-icon-container" href="{{ route('contracts.create', $model->getId()) }}" ><img class="shadow card-link-icon" src="/images/custom/Status-mail-task-icon.png" title="{{ __('Potpis ugovora') }}"/></a>
                @break
        @endswitch
    @endif

    <a class="float-right card-link-icon-container" href="{{ route('clients.edit', $model->getId()) }}"><img class="shadow card-link-icon" src="/images/custom/edit-validated-icon.png" title="{{__('Edit')}}"/></a>
    <a class="float-right card-link-icon-container" href="{{  request()->session()->get('backroute')}}"><img class="shadow card-link-icon" src="/images/custom/go-back-icon.png" title="{{ __('Back') }}"/></a>


@endsection
