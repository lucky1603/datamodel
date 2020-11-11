@extends('layouts.user')

@section('content')
<div class="container-fluid">
    <div class="row" style="padding: 20px; margin-top: 0px;">
        <div class="col-12" style="text-align: center">
            <a href="{{ route("clients.create") }}" title="Dodaj novog klijenta"><img id="addUser" src="/images/adduser.png" class="shadow-lg" style="height: 45px"/></a>
            <hr/>
        </div>
    </div>
    @foreach($clients as $client)
        @if($loop->iteration % 4 == 1)
            <div class="row">
        @endif

        <div class="col-md-3">
            <a href="{{ route('clients.show', $client->getId()) }}">
                <div class="card shadow-sm" data-id="{{ $loop->iteration }}">

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

