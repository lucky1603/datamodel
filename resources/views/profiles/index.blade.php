@extends('layouts.hyper-vertical-mainframe')

@section('content')

    <div >
        <ul class="nav float-right page-title-right" >
            <li class="nav-item">
                <a
                    class="nav-link text-muted"
                    id="newClient"
                    href="{{ route('profiles.create') }}"
                    role="button" data-toggle="modal" data-target="#dialogHost">
                    <i class="dripicons-document-new font-20"></i><span class="ml-0 mt-2 font-weight-bold"> {{strtoupper(__('New Profile'))}}</span>
                </a>
            </li>
        </ul>
        <ul class="nav page-title" >
            <li class="nav-item"><label style="margin-top: 8px"><strong>{{ __('PROFILE FILTER') }}:</strong></label></li>
            <li class="nav-item" style="margin-left: 40px">
                <div class="input-group input-group-sm" style="margin-top: 2px">
                    <div class="input-group-prepend">
                        <span class="input-group-text small">{{ __('By Status') }}</span>
                    </div>
                    <select name="clientStatus" id="clientStatus" class="form-control form-control-sm">
                        <option value="1">{{ __('Mapped') }}</option>
                        <option value="2">{{ __('Interested') }}</option>
                        <option value="3">{{ __('Applied') }}</option>
                    </select>
                </div>
            </li>
            <li class="nav-item" style="margin-left: 20px">
                <div class="input-group input-group-sm" style="margin-top: 2px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ __('By Name') }}</span>
                    </div>
                    <input type="text" id="profileSearch" name="profileSearch" class="form-control" placeholder="{{ __('Search...') }}" >
                    {{--                        <span class="mdi mdi-search-web" style="font-size: 22px;position: absolute; left:90px; top:0px; color: lightgray; z-index: 9"></span>--}}
                    <div class="input-group-append">
                        <span class="mdi mdi-search-web input-group-text"></span>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <hr/>
    @foreach($profiles as $profile)
        @if($loop->iteration % 4 == 1)
            <div class="row">
                @endif

                @php
                    $data = $profile->getData();
                    $status = $profile->getAttribute('profile_status')->getValue();
                    $status_text = $profile->getAttribute('profile_status')->getText();
                @endphp

                <div class="col-md-3 mt-1 mb-1">
                    <a href="{{ route('profiles.show', $profile->getId()) }}">
                        <div class="card h-100 shadow-sm ribbon-box" data-id="{{ $loop->iteration }}" style="margin-top:10px; margin-bottom: 10px">

                            <div class="card-body" style="padding: 0" >
                                <div class="ribbon-two
                                        @switch($status)
                                            @case(1)
                                            @case(2)
                                                ribbon-two-primary
                                                @break
                                            @case(3)
                                                ribbon-two-info
                                                @break
                                            @case(4)
                                                ribbon-two-success
                                                @break
                                            @case(5)
                                                ribbon-two-danger
                                                @break
                                            @default
                                                ribbon-two-success
                                                @break
                                        @endswitch"><span>{{ $status_text }}</span></div>
                                <div id="img-container" class="image-container">
                                    <img src="@if( $profile->getAttribute('profile_background') != null && strlen($profile->getAttribute('profile_background')->getValue()['filelink']) > 0 ) {{ $profile->getAttribute('profile_background')->getValue()['filelink'] }} @else /images/custom/backdefault.jpg @endif" class="image-container-profile" style="height: 150px"/>
                                    <img class="shadow image-container-logo" src="{{ $profile->getAttribute('profile_logo') != null && $profile->getValue('profile_logo') != null && strlen($profile->getAttribute('profile_logo')->getValue()['filelink']) > 0 ? $profile->getAttribute('profile_logo')->getValue()['filelink'] : '/images/custom/avatar-default.png' }}" />
                                </div>
                                <div class="row h-50">
                                    @if($profile->getActiveProgram() != null)
                                    <div class="col-sm-3 p-2" style="display: flex; align-items: center; justify-content: center">
                                        @switch($profile->getActiveProgram()->getValue('program_type'))
                                            @case(5)
                                                <img src="/images/custom/inkubacija.png"  style="width: 100%">
                                                @break
                                            @case(2)
                                                <img src="/images/custom/raisingstarts.png" class="bg-primary rounded-circle" style="width: 100%">
                                                @break
                                            @default
                                                <img src="/images/custom/rastuce.png" class="h-100 m-4">
                                                @break
                                        @endswitch
                                    </div>
                                    @endif
                                    <div @if($profile->getActiveProgram() != null) class="col-sm-9" @else class="col-sm-12" @endif style="display: flex; align-items: center; justify-content: center; font-family: 'Roboto Light'; font-size: 30px; font-weight: normal; flex-direction: column" >
                                        <span class="text-center">{{ $data['name'] }}</span>
                                        <address class="text-center font-14" style="text-align: center">{{ !isset($data['address']) || strlen($data['address']) == 0 ? 'nedostaje adresa' : $data['address'] }}</address>
                                    </div>
                                </div>




                            </div>
                        </div>
                    </a>
                </div>

                @if($loop->iteration % 4 == 0 || $loop->iteration == $profiles->count())
            </div>
        @endif

    @endforeach
@endsection


