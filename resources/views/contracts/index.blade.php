@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1>Lista ugovora</h1>
                @if(count($contracts) === 0)
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
                                <td><a href="{{ route('contracts.show', $contract['id']) }}">{{ $contract['name'] }}</a></td>
                                <td>{{ $contract['first_party'] }}</td>
                                <td>{{ $contract['second_party'] }}</td>
                                <td>{{ $contract['amount'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif

            </div>
        </div>

    </div>
@endsection
