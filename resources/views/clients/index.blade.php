@extends('layouts.user')

@section('content')
<div class="container-fluid">

    @foreach($clients as $client)
        @if($loop->iteration % 3 == 1)
            <div class="row">
        @endif

        <div class="col-md-3">
            <a href="{{ route('clients.show', $client['id']) }}">
                <div class="card shadow-sm" data-id="{{ $loop->iteration }}">

                    <div class="card-body" style="padding: 0" >
                        <div id="img-container" style="position: relative">
                            <img src="images/backdefault.jpg" style="width: 100%"/>
                            <img class="shadow-sm" src="images/avatar-default.png" style="width:30%; position:absolute; top:50%; left: 35%"/>
                        </div>

                        <h4 style="text-align: center; margin-top: 50px; margin-bottom: 20px"><strong>{{ $client['name'] }}</strong></h4>

                        <address style="text-align: center">{{ !isset($client['address']) || strlen($client['address']) == 0 ? 'nedostaje adresa' : $client['address'] }}</address>


                    </div>
                </div>
            </a>
        </div>

        @if($loop->iteration % 3 == 0 || $loop->iteration == count($clients))
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

