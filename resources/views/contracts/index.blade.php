@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div style="height: 50px;">
                    <h1 style="float: left">Lista ugovora</h1>
                    <a href="{{ route('contracts.create') }}" class="btn btn-primary" style="float: right;margin-top: 5px">Novi ugovor</a>
                </div>

                @if(count($contracts) === 0)
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
                                <td><a href="{{ route('contracts.show', $contract['id']) }}">{{ $contract['name'] }}</a></td>
                                <td>{{ $contract['contractor1'] }}</td>
                                <td>{{ $contract['contractor2'] }}</td>
                                <td>{{ $contract['amount'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif

            </div>
        </div>

    </div>
@endsection
