@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1>Lista klijenata</h1>
            @if(count($clients) === 0)
                <p>No clients yet!</p>
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
                            <td><a href="/clients/{{ $client['id'] }}">{{ $client['name'] }}</a></td>
                            <td>{{ $client['contact_person'] }}</td>
                            <td>{{ $client['email'] }}</td>
                            <td>{{ $client['telephone'] }}</td>
                            <td>{{ $client['status'] }}</td>
                        </tr>
                    @endforeach
                </table>
            @endif

        </div>
    </div>

</div>
@endsection
