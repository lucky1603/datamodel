@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div style="margin: auto 0; height: 50px">
                <h1 style="float: left">Lista klijenata</h1>
                <a href="{{ route('clients.create') }}" class="btn btn-primary" style="float: right;margin-top: 5px">Novi klijent</a>
            </div>

            @if(count($clients) === 0)
                <hr/>
                <p>Još uvek nema klijenata!</p>
            @else
                <table class="table">
                    <tr>
                        <th>Redni broj</th>
                        <th>Ime</th>
                        <th>Kontakt osoba</th>
                        <th>E-Mail</th>
                        <th>Telefon</th>
                        <th>Status</th>
                    </tr>
                    @foreach($clients as $client)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="{{ route('clients.show', $client['id'])}}">{{ $client['name'] }}</a></td>
                            <td>{{ $client['contact_person'] }}</td>
                            <td>{{ $client['email'] }}</td>
                            <td>{{ $client['telephone'] }}</td>
                            <td class="@if($client['status'] === 'Odbijena prijava') bad-looking @else good-looking @endif">{{ $client['status'] }}</td>
                        </tr>
                    @endforeach
                </table>
            @endif

        </div>
    </div>

</div>
@endsection
