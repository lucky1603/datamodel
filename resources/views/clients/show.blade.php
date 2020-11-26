@extends('layouts.hyper-profile')

@section('client-name')
    {{ $model->getData()['name'] }}
@endsection

@section('title')
    <div>
        <h3>{{ __('CLIENT PROFILE') }} </h3>
    </div>
@endsection

@section('profile_image')
    {{ $model->getAttribute('profile_background')->getValue()['filelink'] }}
@endsection

@section('logo_image')
    {{ $model->getAttribute('logo')->getValue()['filelink'] }}
@endsection

@section('profile-images')
    <div id="img-container" class="image-container">
        <img src="@if( $model->getAttribute('profile_background') != null && strlen($model->getAttribute('profile_background')->getValue()['filelink']) > 0 ) {{ $model->getAttribute('profile_background')->getValue()['filelink'] }} @else '/images/backdefault.jpg' @endif" class="image-container-profile"/>
        <img class="shadow image-container-logo" src="{{ $model->getAttribute('logo') != null && strlen($model->getAttribute('logo')->getValue()['filelink']) > 0 ? $model->getAttribute('logo')->getValue()['filelink'] : 'images/avatar-default.png' }}" />
    </div>

    <h4 class="mb-0 mt-5">{{ $model->getData()['name']}}</h4>
    <p class="text-muted font-14 mt-2">{{ __('Competes For') }}:</p>
{{--    <button type="button" class="btn btn-success btn-sm mb-2">Follow</button>--}}
{{--    <button type="button" class="btn btn-danger btn-sm mb-2">Message</button>--}}
    <button type="button" class="btn btn-primary" style="width: 100%">{{ $model->getAttribute('program')->getText() }}</button>

    <div class="text-left mt-3">
        <h4 class="font-13 text-uppercase">{{ $model->getAttribute('ino_desc')->label }}</h4>
        <p class="text-muted font-13 mb-3">{{ $model->getAttribute('ino_desc')->getValue() }}
        </p>
        <p class="text-muted mb-2 font-13"><strong>{{ $model->getAttribute('contact_person')->label }}</strong>
            <span class="ml-2">{{ $model->getAttribute('contact_person')->getValue() }}</span></p>

        <p class="text-muted mb-2 font-13"><strong>{{ $model->getAttribute('telephone')->label }}</strong>
            <span class="ml-2">{{ $model->getAttribute('telephone')->getValue() }}</span></p>

        <p class="text-muted mb-2 font-13"><strong>{{ $model->getAttribute('email')->label }}</strong>
            <span class="ml-2">{{ $model->getAttribute('email')->getValue() }}</span></p>

        <p class="text-muted mb-2 font-13"><strong>{{ $model->getAttribute('university')->label }}</strong>
            <span class="ml-2">{{ $model->getAttribute('university')->getValue() }}</span></p>

    </div>
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
    <div class="inbox-widget">
    @foreach($model->instance->users as $user)
        <div class="inbox-item">
            <div class="inbox-item-img"><img src="{{ $user->photo }}" class="rounded-circle" alt=""></div>
            <p class="inbox-item-author">{{ $user->name }}</p>
            <p class="inbox-item-text">{{ $user->position }}</p>
            <p class="inbox-item-date">
                <a href="#" class="btn btn-sm btn-link text-info font-13"> {{__('Edit')}} </a>
            </p>
        </div>
    @endforeach
    </div> <!-- end inbox-widget -->

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

@section('profile-data')
    <div class="display-pair font-14 mt-2">
        <span class="text-muted"><strong>{{ $model->getAttribute('interests')->label }}:</strong></span>
        @if($model->getAttribute('interests')->getText() === 'Остало')
            <span class="text-muted ml-2">{{ $model->getAttribute('ostalo_opis')->getValue() }}</span>
        @else
            <span class="text-muted ml-2">{{ $model->getAttribute('interests')->getText() }}</span>
        @endif
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="text-muted"><strong>{{ $model->getAttribute('date_interested')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('date_interested')->getValue() }}</span>
    </div>

    @if($model->getAttribute('osnivac_1_imeprezime')->getValue() != null && strlen($model->getAttribute('osnivac_1_imeprezime')->getValue()) > 0)
        <div class="display-pair font-14 mt-2">
            <span class="text-muted"><strong>{{ __('Founders') }}</strong></span>
            <table class="table table-bordered table-centered mb-0">
                <thead>
                <tr>
                    <th>{{ __('First Name and Last Name') }}</th>
                    <th>{{ __('University') }}</th>
                    <th>{{ __('Share [%]') }}</th>
                </tr>
                @for($i = 1; $i <= 6; $i++)
                    @if($model->getAttribute('osnivac_'.$i.'_imeprezime')->getValue() != null)
                        <tr>
                            <td>{{ $model->getAttribute('osnivac_'.$i.'_imeprezime')->getValue() }}</td>
                            <td>{{ $model->getAttribute('osnivac_'.$i.'_fakultet')->getValue() }}</td>
                            <td>{{ $model->getAttribute('osnivac_'.$i.'_udeo')->getValue() }}</td>
                        </tr>
                    @endif
                @endfor
                </thead>
            </table>
        </div>
    @endif

    <div class="display-pair font-14 mt-2">
        <span class="text-muted"><strong>{{ $model->getAttribute('reason_contact')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('reason_contact')->getText() }}</span>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="text-muted" style="display:block"><strong>{{ $model->getAttribute('notes')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('notes')->getValue() }}</div>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="text-muted"><strong>{{ $model->getAttribute('is_registered')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('is_registered')->getText() }}</span>
    </div>

    @if($model->getAttribute('is_registered')->getValue())
        <div class="display-pair font-14 mt-2">
            <span class="text-muted"><strong>{{ $model->getAttribute('date_registered')->label }}:</strong></span>
            <span class="text-muted ml-2">{{ $model->getAttribute('date_registered')->getValue() }}</span>
        </div>
    @endif

    <div class="display-pair font-14 mt-2">
        <span class="text-muted" style="display:block"><strong>{{ $model->getAttribute('remark')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('remark')->getValue() }}</div>
    </div>

@endsection
