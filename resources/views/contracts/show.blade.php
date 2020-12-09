@extends('layouts.hyper-contract')

@section('head')
    <div style="text-align: center">između</div>
    <h3 style="text-align: center">NTP Beograd</h3>
    <div style="text-align: center">i</div>
    <h3 style="text-align: center"><a href="{{ route('clients.show', $client->getId()) }}">{{ $client->getData()['name'] }}</a></h3>
    <div style="height: 30px"></div>
@endsection

@section('returns')
    <a href="{{ request()->session()->get('backroute') }}" class="btn btn-lg btn-link btn-outline-info">Back</a>
@endsection

@section('client-name')
    {{ $client->getData()['name'] }}
@endsection

@section('profile-short-data')
    <div id="img-container" class="image-container">
        <img src="@if( $client->getAttribute('profile_background') != null && strlen($client->getAttribute('profile_background')->getValue()['filelink']) > 0 ) {{ $client->getAttribute('profile_background')->getValue()['filelink'] }} @else '/images/backdefault.jpg' @endif" class="image-container-profile"/>
        <img class="shadow image-container-logo" src="{{ $client->getAttribute('logo') != null && strlen($client->getAttribute('logo')->getValue()['filelink']) > 0 ? $client->getAttribute('logo')->getValue()['filelink'] : 'images/avatar-default.png' }}" />
    </div>

    <h4 class="mb-2 mt-5">{{ $client->getData()['name']}}</h4>
    <button type="button" class="btn btn-primary" style="width: 100%">{{ $client->getAttribute('program')->getText() }}</button>
@endsection

@section('next-status')
    @if($model->getData()['contract_status'] == 1)
        <a id="nextStatus" href="{{ route('contracts.payfirstinstallment', $model->getId())}}" class="dropdown-item" data-toggle="modal" data-target="#dialogHost">{{ __('First Installment Payment')}}</a>
    @endif
@endsection

@section('contract-details')
    <h5 class="text-uppercase"><i class="mdi mdi-face-profile mr-1"></i>{{ __('Contract Details') }}</h5>

    <div class="display-pair font-14 mt-3">
        <span class="attribute-label"><strong>{{ $model->getAttribute('name')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('name')->getValue() }}</span>
    </div>

    <div class="display-pair font-14 mt-2">
        <span class="attribute-label" style="display:block"><strong>{{ $model->getAttribute('contract_subject')->label }}:</strong></span>
        <div style="display: block; width: 100%; background-color: #fafbfe; min-height: 18px">{{ $model->getAttribute('contract_subject')->getValue() }}</div>
    </div>

    <div class="display-pair font-14 mt-3">
        <span class="attribute-label"><strong>{{ $model->getAttribute('amount')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $model->getAttribute('amount')->getText() }} {{ $model->getAttribute('currency')->getValue() }}</span>
    </div>

    <div class="display-pair font-14 mt-3">
        <span class="attribute-label"><strong>{{ $model->getAttribute('signed_at')->label }}:</strong></span>
        <span class="text-muted ml-2"><?php $date = date_create($model->getAttribute('signed_at')->getValue()); echo date_format($date, 'd.m.Y.'); ?></span>
    </div>

    <div class="display-pair font-14 mt-3">
        <span class="attribute-label"><strong>{{ $model->getAttribute('valid_through')->label }}:</strong></span>
        <span class="text-muted ml-2"><?php $date = date_create($model->getAttribute('valid_through')->getValue()); echo date_format($date, 'd.m.Y.'); ?></span>
    </div>

    <div class="display-pair font-14 mt-3">
        <span class="attribute-label"><strong>{{ __('Program') }}:</strong></span>
        <span class="text-muted ml-2">{{ $client->getAttribute('program')->getText() }}</span>
    </div>

    <div class="display-pair font-14 mt-3">
        <span class="attribute-label"><strong>{{ $client->getAttribute('membership')->label }}:</strong></span>
        <span class="text-muted ml-2">{{ $client->getAttribute('membership')->getText() }}</span>
    </div>

    <div class="display-pair font-14 mt-3">
        <span class="attribute-label"><strong>{{ $model->getAttribute('contract_document')->label }}:</strong></span>
        <a href="{{ $model->getAttribute('contract_document')->getValue()['filelink'] }}"><span class="ml-2">{{ $model->getAttribute('contract_document')->getValue()['filename'] }}</span></a>
    </div>
@endsection

@section('timeline')
    <div class="timeline-show mb-3 text-center">
        <h5 class="m-0 time-show-name">{{ __('Contract Signing') }}</h5>
    </div>

    @foreach($model->getSituations() as $situation)
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
                                @if($situation->getDisplayAttributes()->sortBy('sort_order') != null)
                                    <table class="@if($situation->getDisplayAttributes()->count() > 1) table-striped @else table-borderless @endif" style="width: 100%">
                                        @foreach($situation->getDisplayAttributes() as $attribute)
                                            <tr>
                                                <td style=" width: @if($situation->getDisplayAttributes()->count() > 1) 50% @else auto @endif">
                                                    <span class="attribute-label font-12 mt-0 mb-0"><strong>{!! $attribute->label  !!} :</strong></span>
                                                </td>
                                                @if($attribute->type != 'file')
                                                    <td>
                                                        <span class="text-muted font-12">{!! $attribute->getText() !!} </span>
                                                    </td>
                                                @else
                                                    <td>
                                                        <a href="{{ $attribute->getValue()['filelink'] }}" class="btn-link font-12">{!! $attribute->getValue()['filename'] !!} </a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif

                                {{--                <a href="javascript: void(0);" class="btn btn-sm btn-light">👍 17</a>--}}
                                {{--                <a href="javascript: void(0);" class="btn btn-sm btn-light">❤️ 89</a>--}}
                            </div>
                        </div>
                    </div>
            @endforeach
@endsection

