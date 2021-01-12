@extends('layouts.hyper-vertical-mainframe')

@section('content')

        <div class="page-title-box-sm" xmlns="http://www.w3.org/1999/html">
            <ul class="nav float-right page-title-right" >
                <li class="nav-item">
                    <a
                        class="nav-link text-muted"
                        id="newClient"
                        href="{{ route('clients.create') }}"
                        role="button" data-toggle="modal" data-target="#dialogHost">
                        <i class="dripicons-document-new font-20"></i><span class="ml-0 mt-2 font-weight-bold"> {{strtoupper(__('New Client'))}}</span>
                    </a>
                </li>
            </ul>
            <ul class="nav page-title" >
                <li class="nav-item"><label style="margin-top: 8px"><strong>{{ __('CLIENT FILTER') }}:</strong></label></li>
                <li class="nav-item" style="margin-left: 40px">
                    <div class="input-group input-group-sm" style="margin-top: 2px">
                        <div class="input-group-prepend">
                            <span class="input-group-text small">{{ __('By Status') }}</span>
                        </div>
                        <select name="clientStatus" id="clientStatus" class="form-control form-control-sm">
                            <option value="1">{{ __('All') }}</option>
                            <option value="2">{{ __('Candidates') }}</option>
                            <option value="3">{{ __('Members') }}</option>
                        </select>
                    </div>
                </li>
                <li class="nav-item" style="margin-left: 20px">
                    <div class="input-group input-group-sm" style="margin-top: 2px;">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{ __('By Name') }}</span>
                        </div>
                        <input type="text" id="clientSearch" name="clientSearch" class="form-control" placeholder="{{ __('Search...') }}" >
                        {{--                        <span class="mdi mdi-search-web" style="font-size: 22px;position: absolute; left:90px; top:0px; color: lightgray; z-index: 9"></span>--}}
                        <div class="input-group-append">
                            <span class="mdi mdi-search-web input-group-text"></span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <hr/>
    @foreach($clients as $client)
        @if($loop->iteration % 4 == 1)
            <div class="row">
        @endif

        <div class="col-md-3">
            <a href="{{ route('clients.show', $client->getId()) }}">
                <div class="card shadow-sm ribbon-box" data-id="{{ $loop->iteration }}" style="margin-top:10px; margin-bottom: 10px">

                    <div class="card-body" style="padding: 0" >
                        @if($client->getData()['status'] == 1)
                            <div class="ribbon-two ribbon-two-secondary">
                                <span>{{ strtoupper( __('Interest')) }}</span>
                            </div>
                        @elseif($client->getData()['status'] == 2 )
                            <div class="ribbon-two ribbon-two-warning">
                                <span>{{ strtoupper( __('Application')) }}</span>
                            </div>
                        @elseif($client->getData()['status'] <= 10 && $client->getData()['status'] > 2)
                            <div class="ribbon-two ribbon-two-success">
                                <span>{{ strtoupper( __('Candidate')) }}</span>
                            </div>
                        @else
                            <div class="ribbon-two ribbon-two-primary">
                                <span>{{ strtoupper(__('Member')) }}</span>
                            </div>
                        @endif
                        <div id="img-container" class="image-container">
                            <img src="@if( $client->getAttribute('profile_background') != null && strlen($client->getAttribute('profile_background')->getValue()['filelink']) > 0 ) {{ $client->getAttribute('profile_background')->getValue()['filelink'] }} @else /images/custom/backdefault.jpg @endif" class="image-container-profile"/>
                            <img class="shadow image-container-logo" src="{{ $client->getAttribute('logo') != null && strlen($client->getAttribute('logo')->getValue()['filelink']) > 0 ? $client->getAttribute('logo')->getValue()['filelink'] : '/images/custom/avatar-default.png' }}" />
                        </div>

                        <h4 class="text-center mt-5 mb-2 text-secondary">{{ $client->getData()['name'] }}</h4>

                        <address class="text-center text-secondary" style="text-align: center">{{ !isset($client->getData()['address']) || strlen($client->getData()['address']) == 0 ? 'nedostaje adresa' : $client->getData()['address'] }}</address>

                    </div>
                </div>
            </a>
        </div>

        @if($loop->iteration % 4 == 0 || $loop->iteration == $clients->count())
            </div>
        @endif

    @endforeach

@endsection


