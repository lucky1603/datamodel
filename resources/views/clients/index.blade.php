@extends('layouts.hyper-vertical')

@section('content')

            <ul class="nav shadow frame-padding" style="background-color: white; padding: 10px;">
                <li class="nav-item"><label style="margin-top: 8px"><strong>{{ __('CLIENT FILTER') }}:</strong></label></li>
                <li class="nav-item" style="margin-left: 40px">
                    <div class="input-group input-group-sm" style="margin-top: 2px">
                        <div class="input-group-prepend">
                            <span class="input-group-text small">{{ __('By Status') }}</span>
                        </div>
                        <select name="clientStatus" id="clientStatus" class="form-control form-control-sm">
                            <option value="1">{{ __('All') }}</option>
                            <option value="2">{{ __('Interested') }}</option>
                            <option value="3">{{ __('Registered') }}</option>
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

    @foreach($clients as $client)
        @if($loop->iteration % 4 == 1)
            <div class="row">
        @endif

        <div class="col-md-3">
            <a href="{{ route('clients.show', $client->getId()) }}">
                <div class="card shadow-sm" data-id="{{ $loop->iteration }}" style="margin-top:10px; margin-bottom: 10px">

                    <div class="card-body" style="padding: 0" >
                        <div id="img-container" class="image-container">
                            <img src="@if( $client->getAttribute('profile_background') != null && strlen($client->getAttribute('profile_background')->getValue()['filelink']) > 0 ) {{ $client->getAttribute('profile_background')->getValue()['filelink'] }} @else '/images/backdefault.jpg' @endif" class="image-container-profile"/>
                            <img class="shadow image-container-logo" src="{{ $client->getAttribute('logo') != null && strlen($client->getAttribute('logo')->getValue()['filelink']) > 0 ? $client->getAttribute('logo')->getValue()['filelink'] : 'images/avatar-default.png' }}" />
                        </div>

                        <h4 style="text-align: center; margin-top: 50px; margin-bottom: 20px"><strong>{{ $client->getData()['name'] }}</strong></h4>

                        <address style="text-align: center">{{ !isset($client->getData()['address']) || strlen($client->getData()['address']) == 0 ? 'nedostaje adresa' : $client->getData()['address'] }}</address>

                    </div>
                </div>
            </a>
        </div>

        @if($loop->iteration % 4 == 0 || $loop->iteration == $clients->count())
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

            if(!$('#link_clients').hasClass('active')) {
                $('#link_clients').addClass('active');
            }

            if($('#link_contracts').hasClass('active')) {
                $('#link_contracts').removeClass('active');
            }

        })
    </script>
@endsection

