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

@section('profile-short-data')
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
        <h4 class="font-13 text-uppercase attribute-label">{{ $model->getAttribute('ino_desc')->label }}</h4>
        <p class="text-muted font-13 mb-3">{{ $model->getAttribute('ino_desc')->getValue() }}
        </p>
        <p class="text-muted mb-2 font-13 attribute-label"><strong>{{ $model->getAttribute('contact_person')->label }}</strong>
            <span class="ml-2">{{ $model->getAttribute('contact_person')->getValue() }}</span></p>

        <p class="text-muted mb-2 font-13 attribute-label"><strong>{{ $model->getAttribute('telephone')->label }}</strong>
            <span class="ml-2">{{ $model->getAttribute('telephone')->getValue() }}</span></p>

        <p class="text-muted mb-2 font-13 attribute-label"><strong>{{ $model->getAttribute('email')->label }}</strong>
            <span class="ml-2">{{ $model->getAttribute('email')->getValue() }}</span></p>

        <p class="text-muted mb-2 font-13 attribute-label"><strong>{{ $model->getAttribute('university')->label }}</strong>
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

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('Home')}}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">{{__('Clients')}}</a></li>
    <li class="breadcrumb-item active"></li>
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

@section('next-status')
    @if(auth()->user()->isAdmin())
        @switch($model->getData()['status'])
            @case('1')
                <a href="{{ route('clients.register', $model->getId()) }}" class="dropdown-item">{{ __('Registration') }}</a>
            @break
            @case('2')
                <a href="{{ route('clients.preselect', $model->getId()) }}" class="dropdown-item">{{ __('Pre- Selection') }}</a>
            @break
            @case('3')
                <a href="{{ route('clients.invite', $model->getId()) }}" class="dropdown-item">{{ __('Call to the meeting') }}</a>
                @break
            @case('4')
                <a href="{{ route('clients.confirm', $model->getId()) }}" class="dropdown-item">{{ __('Meeting Date Confirmation') }}</a>
                @break
            @case('5')
                <a href="{{ route('clients.select', $model->getId()) }}" class="dropdown-item">{{ __('Final Selection') }}</a>
                @break
            @case('6')
                <a href="{{ route('clients.assigne', $model->getId()) }}" class="dropdown-item">{{ __('Assignment') }}</a>
                @break
            @case('8')
                <a href="{{ route('clients.assignContractDate', $model->getId()) }}" class="dropdown-item">{{ __('Call to Signing of the Contract') }}</a>
                @break
            @case('9')
                <a href="{{ route('clients.confirmContractDate', $model->getId()) }}" class="dropdown-item">{{ __('Confirm the Contract Signing Date') }}</a>
                @break
            @case('10')
                <a href="{{ route('clients.create', $model->getId()) }}" class="dropdown-item">{{ __('Sign Contract') }}</a>
                @break
        @endswitch
    @endif
@endsection

@section('profile-data')
    <!-- Opsti podaci -->

    <h5 class="text-uppercase"><i class="mdi mdi-face-profile mr-1"></i>{{ __('General Data') }}</h5>

    <div class="display-pair font-14 mt-3">
        <span class="attribute-label"><strong>{{ $model->getAttribute('maticni_broj')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('maticni_broj')->getValue() }}</span>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label"><strong>{{ $model->getAttribute('address')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('address')->getValue() }}</span>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label"><strong>{{ $model->getAttribute('website')->label }}:</strong></span>
        <a class="text-muted ml-2" href="{{ $model->getAttribute('website')->getValue() }}">{{ $model->getAttribute('website')->getValue() }}</a>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label"><strong>{{ $model->getAttribute('broj_zaposlenih')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('broj_zaposlenih')->getValue() }}</span>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label"><strong>{{ $model->getAttribute('interests')->label }}:</strong></span>
        @if($model->getAttribute('interests')->getText() === 'Остало')
            <span class="text-muted ml-2">{{ $model->getAttribute('ostalo_opis')->getValue() }}</span>
        @else
            <span class="text-muted ml-2">{{ $model->getAttribute('interests')->getText() }}</span>
        @endif
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label"><strong>{{ $model->getAttribute('date_interested')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('date_interested')->getValue() }}</span>
    </div>

    @if($model->getAttribute('osnivac_1_imeprezime')->getValue() != null && strlen($model->getAttribute('osnivac_1_imeprezime')->getValue()) > 0)
        <div class="display-pair font-14 mt-2">
            <span class="attribute-label"><strong>{{ __('Founders') }}</strong></span>
            <table class="table table-striped table-centered mb-0">
                <thead>
                <tr>
                    <th>{{ __('First Name and Last Name') }}</th>
                    <th>{{ __('University') }}</th>
                    <th>{{ __('Share [%]') }}</th>
                </tr>
                </thead>
                <tbody>
                @for($i = 1; $i <= 6; $i++)
                    @if($model->getAttribute('osnivac_'.$i.'_imeprezime')->getValue() != null)
                        <tr>
                            <td>{{ $model->getAttribute('osnivac_'.$i.'_imeprezime')->getValue() }}</td>
                            <td>{{ $model->getAttribute('osnivac_'.$i.'_fakultet')->getValue() }}</td>
                            <td>{{ $model->getAttribute('osnivac_'.$i.'_udeo')->getValue() }}</td>
                        </tr>
                    @endif
                @endfor
                </tbody>
            </table>
        </div>
    @endif

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label"><strong>{{ $model->getAttribute('reason_contact')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('reason_contact')->getText() }}</span>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label" style="display:block"><strong>{{ $model->getAttribute('notes')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('notes')->getValue() }}</div>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label"><strong>{{ $model->getAttribute('is_registered')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('is_registered')->getText() }}</span>
    </div>

    @if($model->getAttribute('is_registered')->getValue())
        <div class="display-pair font-14 mt-2">
            <span class="attribute-label"><strong>{{ $model->getAttribute('date_registered')->label }}:</strong></span>
            <span class="text-muted ml-2">{{ $model->getAttribute('date_registered')->getValue() }}</span>
        </div>
    @endif

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label" style="display:block"><strong>{{ $model->getAttribute('remark')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('remark')->getValue() }}</div>
    </div>

    <!-- Problem i ciljna grupa -->

    <h5 class="text-uppercase mt-4"><i class="mdi mdi-face-profile mr-1"></i>{{ __('Problem and Target Group') }}</h5>

    <div class="display-pair font-14 mt-3">
        <span class="attribute-label"><strong>{{ $model->getAttribute('development_phase')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('development_phase')->getText() }}</span>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label" style="display:block"><strong>{{ $model->getAttribute('poblems')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('poblems')->getValue() }}</div>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label" style="display:block"><strong>{{ $model->getAttribute('target_group_solution_and_competition')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('target_group_solution_and_competition')->getValue() }}</div>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label" style="display:block"><strong>{{ $model->getAttribute('target_groups')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('target_groups')->getValue() }}</div>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label" style="display:block"><strong>{{ $model->getAttribute('target_markets')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('target_markets')->getValue() }}</div>
    </div>


    <!-- Inovativnost -->

    <h5 class="text-uppercase mt-4"><i class="mdi mdi-face-profile mr-1"></i>{{ __('Innovation') }}</h5>

    <div class="display-pair font-14 mt-3">
        <span class="attribute-label" style="display:block"><strong>{{ $model->getAttribute('product_description')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('product_description')->getValue() }}</div>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label"><strong>{{ $model->getAttribute('inovation_type')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('inovation_type')->getText() }}</span>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label" style="display:block"><strong>{{ $model->getAttribute('inovativity')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('inovativity')->getValue() }}</div>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label" style="display:block"><strong>{{ $model->getAttribute('intelectual_property_protection')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('intelectual_property_protection')->getValue() }}</div>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label" style="display:block"><strong>{{ $model->getAttribute('mvp_testing')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('mvp_testing')->getValue() }}</div>
    </div>

    <!-- Tim -->

    <h5 class="text-uppercase mt-4"><i class="mdi mdi-face-profile mr-1"></i>{{ __('Team') }}</h5>

    <div class="display-pair font-14 mt-3">
        <span class="attribute-label" style="display:block"><strong>{{ $model->getAttribute('team_members')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('team_members')->getValue() }}</div>
    </div>

    @if(strlen($model->getData()['team_members_file']['filelink']) > 0)
        <div class="display-pair font-14 mt-2">
            <span class="attribute-label"><strong>{{ $model->getAttribute('team_members_file')->label }}:</strong></span>
            <a class="text-muted ml-2" href="{{ $model->getData()['team_members_file']['filelink'] }}">{{ $model->getData()['team_members_file']['filename'] }}</a>
        </div>
    @endif

    @for($i = 1; $i <= 6; $i ++)
        @if( $model->getAttribute('linkedin_link_'.$i)->getValue() != null)
            <div class="display-pair font-14 mt-2">
                <span class="attribute-label"><strong>{{ $model->getAttribute('linkedin_link_'.$i)->label }}:</strong></span>
                <a class="text-muted ml-2" href="{{ $model->getAttribute('linkedin_link_'.$i)->getValue() }}">{{ $model->getAttribute('linkedin_link_'.$i)->getValue() }}</a>
            </div>
        @endif
    @endfor

    <!-- Finansiranje i nagrade -->

    <h5 class="text-uppercase mt-4"><i class="mdi mdi-face-profile mr-1"></i>{{ __('Financing and Prizes') }}</h5>

    <div class="display-pair font-14 mt-3">
        <span class="attribute-label" style="display:block"><strong>{{ $model->getAttribute('prizes')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('prizes')->getValue() }}</div>
    </div>

    <div class="display-pair font-14 mt-3">
        <span class="attribute-label" style="display:block"><strong>{{ $model->getAttribute('financing_type')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('financing_type')->getValue() }}</div>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label"><strong>{{ $model->getAttribute('looking_for_financing')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('looking_for_financing')->getText() }}</span>
    </div>

    <!-- Biznis model -->

    <h5 class="text-uppercase mt-4"><i class="mdi mdi-face-profile mr-1"></i>{{ __('Business Model') }}</h5>

    <div class="display-pair font-14 mt-3">
        <span class="attribute-label" style="display:block"><strong>{{ $model->getAttribute('business_model')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('business_model')->getValue() }}</div>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label"><strong>{{ __('Table of Expenses') }}:</strong></span>
        <table class="table table-striped table-centered">
            <thead>
                <tr>
                    <th>{{ __('Cost Specification') }}</th>
                    <th>{{ __("Year") }} 1</th>
                    <th>{{ __("Year") }} 2</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $model->getAttribute('zarade_zaposlenih_1')->label }}</td>
                    <td>{{ $model->getAttribute('zarade_zaposlenih_1')->getText() }}</td>
                    <td>{{ $model->getAttribute('zarade_zaposlenih_2')->getText() }}</td>
                </tr>
                <tr>
                    <td>{{ $model->getAttribute('fiksni_troskovi_1')->label }}</td>
                    <td>{{ $model->getAttribute('fiksni_troskovi_1')->getText() }}</td>
                    <td>{{ $model->getAttribute('fiksni_troskovi_2')->getText() }}</td>
                </tr>
                <tr>
                    <td>{{ $model->getAttribute('naknada_angazovanih_1')->label }}</td>
                    <td>{{ $model->getAttribute('naknada_angazovanih_1')->getText() }}</td>
                    <td>{{ $model->getAttribute('naknada_angazovanih_2')->getText() }}</td>
                </tr>
                <tr>
                    <td>{{ $model->getAttribute('knjigovodstvo_1')->label }}</td>
                    <td>{{ $model->getAttribute('knjigovodstvo_1')->getText() }}</td>
                    <td>{{ $model->getAttribute('knjigovodstvo_2')->getText() }}</td>
                </tr>
                <tr>
                    <td>{{ $model->getAttribute('advokat_1')->label }}</td>
                    <td>{{ $model->getAttribute('advokat_1')->getText() }}</td>
                    <td>{{ $model->getAttribute('advokat_2')->getText() }}</td>
                </tr>
                <tr>
                    <td>{{ $model->getAttribute('zakup_kancelarije_1')->label }}</td>
                    <td>{{ $model->getAttribute('zakup_kancelarije_1')->getText() }}</td>
                    <td>{{ $model->getAttribute('zakup_kancelarije_2')->getText() }}</td>
                </tr>
                <tr>
                    <td>{{ $model->getAttribute('rezijski_troskovi_1')->label }}</td>
                    <td>{{ $model->getAttribute('rezijski_troskovi_1')->getText() }}</td>
                    <td>{{ $model->getAttribute('rezijski_troskovi_2')->getText() }}</td>
                </tr>
                <tr>
                    <td>{{ $model->getAttribute('ostali_fini_troskovi_1')->label }}</td>
                    <td>{{ $model->getAttribute('ostali_fini_troskovi_1')->getText() }}</td>
                    <td>{{ $model->getAttribute('ostali_fini_troskovi_2')->getText() }}</td>
                </tr>
                <tr>
                    <td>{{ $model->getAttribute('ukupni_varijabilni_troskovi_1')->label }}</td>
                    <td>{{ $model->getAttribute('ukupni_varijabilni_troskovi_1')->getText() }}</td>
                    <td>{{ $model->getAttribute('ukupni_varijabilni_troskovi_2')->getText() }}</td>
                </tr>
                <tr>
                    <td>{{ $model->getAttribute('troskovi_materijala_1')->label }}</td>
                    <td>{{ $model->getAttribute('troskovi_materijala_1')->getText() }}</td>
                    <td>{{ $model->getAttribute('troskovi_materijala_2')->getText() }}</td>
                </tr>
                <tr>
                    <td>{{ $model->getAttribute('troskovi_alata_1')->label }}</td>
                    <td>{{ $model->getAttribute('troskovi_alata_1')->getText() }}</td>
                    <td>{{ $model->getAttribute('troskovi_alata_2')->getText() }}</td>
                </tr>
                <tr>
                    <td>{{ $model->getAttribute('ostali_varijabilni_troskovi_1')->label }}</td>
                    <td>{{ $model->getAttribute('ostali_varijabilni_troskovi_1')->getText() }}</td>
                    <td>{{ $model->getAttribute('ostali_varijabilni_troskovi_2')->getText() }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Preduzetnicka spremnost -->

    <h5 class="text-uppercase mt-4"><i class="mdi mdi-face-profile mr-1"></i>{{ __('Enterpreneur Readyness') }}</h5>

    <div class="display-pair font-14 mt-3">
        <span class="attribute-label" style="display:block"><strong>{{ $model->getAttribute('have_skills')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('have_skills')->getValue() }}</div>
    </div>

    <div class="display-pair font-14 mt-3">
        <span class="attribute-label" style="display:block"><strong>{{ $model->getAttribute('improve_skills')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('improve_skills')->getValue() }}</div>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label"><strong>{{ $model->getAttribute('regular_menthor_sessions')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('regular_menthor_sessions')->getText() }}</span>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label"><strong>{{ $model->getAttribute('regular_workshops')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('regular_workshops')->getText() }}</span>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label"><strong>{{ $model->getAttribute('will_evaluate_work')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('will_evaluate_work')->getText() }}</span>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label"><strong>{{ $model->getAttribute('establish_company')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('establish_company')->getText() }}</span>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label"><strong>{{ $model->getAttribute('fulfill_contract_obligations')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('fulfill_contract_obligations')->getText() }}</span>
    </div>

    <div class="display-pair font-14 mt-3">
        <span class="attribute-label" style="display:block"><strong>{{ $model->getAttribute('motiv')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('motiv')->getValue() }}</div>
    </div>

    <!-- Potrebna podrška i dodatne napomene -->

    <h5 class="text-uppercase mt-4"><i class="mdi mdi-face-profile mr-1"></i>{{ __('Needed Support and Additional Remarks') }}</h5>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label"><strong>{!! $model->getAttribute('kvadratura')->label !!}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('kvadratura')->getText() }}</span>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label"><strong>{{ $model->getAttribute('zajednicke_prostorije')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('zajednicke_prostorije')->getText() }}</span>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label"><strong>{{ $model->getAttribute('inovaciona_laboratorija')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('inovaciona_laboratorija')->getText() }}</span>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label"><strong>{{ $model->getAttribute('konsalting_usluge')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('konsalting_usluge')->getText() }}</span>
    </div>
@endsection

@section('activities')
    @foreach($model->getSituations()->sortDesc() as $situation)
        <div class="timeline-item">
            @if($loop->first)
                <i class="mdi mdi-circle bg-primary-lighten text-primary timeline-icon"></i>
            @else
                <i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
            @endif
            <div class="timeline-item-info">
                <h5 class="mt-0 mb-1">{{ $situation->getData()['name'] }}</h5>
                <p class="font-12 attribute-label font-weight-bold">{{ $situation->getData()['occurred_at'] }}</p>
                <p class="text-muted mt-2 mb-0 pb-3">
                    {{ $situation->getData()['description'] }}
                </p>
                @foreach($situation->getAttributes() as $attribute)
                    @if($attribute->name == 'description')
                        @continue
                    @endif
                    <p><span class="text-primary">{{ $attribute->name }}:</span><span class="ml-2 text-muted">{{ $attribute->getText() }}</span></p>
                @endforeach
            </div>
        </div>
    @endforeach
@endsection

@section('timeline')

    <div class="timeline-show mb-3 text-center">
        <h5 class="m-0 time-show-name">{{ __('Interest') }}</h5>
    </div>

    @foreach($model->getSituations() as $situation)
        @if($loop->iteration == 2)
            <div class="timeline-show mb-3 text-center">
                <h5 class="m-0 time-show-name">{{__('Registration')}}</h5>
            </div>
        @endif


        @if($loop->iteration % 2 != 0)
        <div class="timeline-lg-item timeline-item-left">
        @else
        <div class="timeline-lg-item">
        @endif

        <div class="timeline-desk">
            <div class="timeline-box">
                @if($loop->iteration % 2 != 0)
                <span class="arrow-alt"></span>
                @else
                <span class="arrow"></span>
                @endif
                <span class="timeline-icon"><i class="mdi mdi-adjust"></i></span>
                <h4 class="mt-0 mb-1 font-16">{{$situation->getData()['name']}}</h4>
                <p class="text-muted"><small>{{ $situation->getData()['occurred_at'] }}</small></p>
                <p>{{ $situation->getData()['description'] }} </p>
                @if($situation->getDisplayAttributes() != null)
                        <p>
                    @foreach($situation->getDisplayAttributes() as $attribute)
                            <span class="attribute-label mt-0 mb-0"><strong>{{ $attribute->label }}:</strong></span><span class="ml-2 text-muted font-12">{{ $attribute->getText() }}</span><br>
                    @endforeach
                        </p>
                @endif

{{--                <a href="javascript: void(0);" class="btn btn-sm btn-light">👍 17</a>--}}
{{--                <a href="javascript: void(0);" class="btn btn-sm btn-light">❤️ 89</a>--}}
            </div>
        </div>
        </div>
    @endforeach
@endsection

