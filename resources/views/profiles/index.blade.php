@extends('layouts.hyper-vertical-mainframe')

@section('content')

    <div class="page-title-box-sm" xmlns="http://www.w3.org/1999/html">
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

                <div class="col-md-3">
                    <a href="{{ route('profiles.show', $profile->getId()) }}">
                        <div class="card shadow-sm ribbon-box" data-id="{{ $loop->iteration }}" style="margin-top:10px; margin-bottom: 10px">

                            <div class="card-body" style="padding: 0" >
                                <div class="ribbon-two
                                        @switch($status)
                                            @case(1)
                                            @case(2)
                                                ribbon-two-danger
                                                @break
                                            @case(3)
                                                ribbon-two-info
                                                @break
                                            @case(4)
                                            @case(5)
                                                ribbon-two-warning
                                                @break
                                            @case(8)
                                                ribbon-two-secondary
                                                @break
                                            @default
                                                ribbon-two-success
                                                @break
                                        @endswitch"><span>{{ $status_text }}</span></div>
                                <div id="img-container" class="image-container">
                                    <img src="@if( $profile->getAttribute('profile_background') != null && strlen($profile->getAttribute('profile_background')->getValue()['filelink']) > 0 ) {{ $profile->getAttribute('profile_background')->getValue()['filelink'] }} @else /images/custom/backdefault.jpg @endif" class="image-container-profile"/>
                                    <img class="shadow image-container-logo" src="{{ $profile->getAttribute('logo') != null && strlen($profile->getAttribute('logo')->getValue()['filelink']) > 0 ? $profile->getAttribute('logo')->getValue()['filelink'] : '/images/custom/avatar-default.png' }}" />
                                </div>

                                <h4 class="text-center mt-5 mb-2 text-secondary">{{ $data['name'] }}</h4>

                                <address class="text-center text-secondary" style="text-align: center">{{ !isset($data['address']) || strlen($data['address']) == 0 ? 'nedostaje adresa' : $data['address'] }}</address>

                            </div>
                        </div>
                    </a>
                </div>

                @if($loop->iteration % 4 == 0 || $loop->iteration == $profiles->count())
            </div>
        @endif

    @endforeach
@endsection


