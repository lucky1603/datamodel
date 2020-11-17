@extends('layouts.user')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="card shadow-sm" style="width: 100%">
            <div class="card-body">
                <span style="float: left; margin-right: 20px">{{ __("SEARCH FILTER:") }}</span>
                <span style="float: left; margin-right: 10px;margin-left: 10px">{{ __("By Status:") }}</span>
                <select name="filter" class="shadow-sm" style="float: left;margin-top:1px;">
                    <option value="1">{{ __("All") }}</option>
                    <option value="2">{{ __("Interested") }}</option>
                    <option value="3">{{ __("Registered") }}</option>
                </select>
                <span style="float: left; margin-right: 10px;margin-left: 20px">{{ __("By Name:") }}</span>
                <input type="text" class="shadow-sm" style="float: left" placeholder="{{ __('gui.EnterName') }}">
                <a href="{{ route("clients.create") }}" title="Dodaj novog klijenta" class="shadow" style="float: right"><img id="addUser" src="/images/adduser.png" class="shadow-sm" style="height: 25px"/></a>
            </div>
        </div>
    </div>

    @foreach($clients as $client)
        @if($loop->iteration % 4 == 1)
            <div class="row">
        @endif

        <div class="col-md-3">
            <a href="{{ route('clients.show', $client->getId()) }}">
                <div class="card shadow-sm" data-id="{{ $loop->iteration }}" style="margin-top:10px; margin-bottom: 10px">

                    <div class="card-body" style="padding: 0" >
                        <div id="img-container" style="position: relative">
                            <img src="@if( $client->getAttribute('profile_background') != null && strlen($client->getAttribute('profile_background')->getValue()['filelink']) > 0 ) {{ $client->getAttribute('profile_background')->getValue()['filelink'] }} @else '/images/backdefault.jpg' @endif" style="width: 100%"/>
                            <img class="shadow" src="{{ $client->getAttribute('logo') != null && strlen($client->getAttribute('logo')->getValue()['filelink']) > 0 ? $client->getAttribute('logo')->getValue()['filelink'] : 'images/avatar-default.png' }}" style="width:30%; position:absolute; top:40%; left: 35%;"/>
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

