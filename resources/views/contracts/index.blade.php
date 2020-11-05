@extends('layouts.user')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div style="height: 50px;">
                    <h1 style="float: left">Lista ugovora</h1>
                </div>

                @if($contracts->count() === 0)
                    <hr/>
                    <p>Lista je prazna!</p>
                @else
                    <table class="table">
                        <tr>
                            <th>Redni broj</th>
                            <th>Ime</th>
                            <th>Ugovarač I</th>
                            <th>Ugovarač II</th>
                            <th>Suma</th>
                        </tr>
                        @foreach($contracts as $contract)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="{{ route('contracts.show', $contract->getId()) }}">{{ $contract->getData()['name'] }}</a></td>
                                <td>NTP Beograd</td>
                                <?php
                                    $clientId = $contract->instance->parent_id;
                                    $client = App\Business\Client::find($clientId);
                                ?>
                                <td>{{ $client->getData()['name'] }} </td>
                                <td>{{ $contract->getData()['amount'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif

            </div>
        </div>

    </div>
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
