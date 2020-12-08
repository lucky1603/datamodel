@extends('layouts.hyper-vertical')

@section('content')
    <div class="page-title-box-sm" xmlns="http://www.w3.org/1999/html">
        <ul class="nav page-title" >
            <li class="nav-item"><label style="margin-top: 8px"><strong>{{ __('CONTRACT FILTER') }}:</strong></label></li>
            <li class="nav-item" style="margin-left: 20px">
                <div class="input-group input-group-sm" style="margin-top: 2px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ __('By Name') }}</span>
                    </div>
                    <input type="text" id="clientSearch" name="clientSearch" class="form-control" placeholder="{{ __('Search...') }}" >
                    <div class="input-group-append">
                        <span class="mdi mdi-search-web input-group-text"></span>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <hr/>
    @foreach($contracts as $contract)
        @if($loop->iteration % 4 == 1)
            <div class="row">
                @endif

                <div class="col-md-3">
                    <a href="{{ route('contracts.show', $contract->getId()) }}">
                        @php
                            $client = $contract->getClient();
                        @endphp
                        <div class="card shadow-sm" data-id="{{ $loop->iteration }}" style="margin-top:10px; margin-bottom: 10px">

                            <div class="card-body" style="padding: 0" >
                                <div id="img-container" class="image-container">
                                    <img src="@if( $client->getAttribute('profile_background') != null && strlen($client->getAttribute('profile_background')->getValue()['filelink']) > 0 ) {{ $client->getAttribute('profile_background')->getValue()['filelink'] }} @else '/images/backdefault.jpg' @endif" class="image-container-profile"/>
                                    <img class="shadow image-container-logo" src="{{ $client->getAttribute('logo') != null && strlen($client->getAttribute('logo')->getValue()['filelink']) > 0 ? $client->getAttribute('logo')->getValue()['filelink'] : 'images/avatar-default.png' }}" />
                                </div>

                                <h4 class="text-center text-secondary mt-5">{{ strtoupper($client->getData()['name']) }}</h4>
                                <hr/>

                                <h6 class="text-center text-muted">{{ __('AMOUNT') }}</h6>
                                <h4 class="text-center text-secondary" style="font-stretch: ultra-condensed">
                                    {{ $contract->getData()['currency'] }} {{ $contract->getData()['amount'] }}
                                </h4>
                                <hr/>
                                <div class="row">
                                    <div class="col-4 text-center border-right mb-1">
                                        <h6 class="text-muted">{{ __('STARTS') }}</h6>
                                        <h4 class="text-secondary">{{ (new DateTime($contract->getData()['signed_at']))->format('d.m.Y') }}</h4>
                                    </div>
                                    <div class="col-4 text-center border-right mb-1">
                                        <h6 class="text-muted">{{ __('ENDS') }}</h6>
                                        <h4 class="text-secondary">{{ (new DateTime($contract->getData()['valid_through']))->format('d.m.Y') }}</h4>
                                    </div>
                                    <div class="col-4 text-center mb-1">
                                        <h6 class="text-muted">{{ __('REALIZED') }}</h6>
                                        <h4 class="text-success">30%</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                @if($loop->iteration % 4 == 0 || $loop->iteration == $contracts->count())
            </div>
        @endif

    @endforeach
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            if($('#link_home').hasClass('active')) {
                $('#link_home').removeClass('active');
            }

            if($('#link_clients').hasClass('active')) {
                $('#link_clients').removeClass('active');
            }

            if(!$('#link_contracts').hasClass('active')) {
                $('#link_contracts').addClass('active');
            }
        })
    </script>
@endsection
