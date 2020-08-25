@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 style="text-align: center;margin-bottom: 50px;margin-top:30px">Potvrda datuma za sastanak sa klijentom '{{ $client->getData()['name'] }}'</h1>
            </div>
        </div>
        <form method="POST" enctype="multipart/form-data" action="{{ route('clients.confirmed', $client->getId()) }}">
            @csrf
            <div class="form-group row">
                <label for="meeting_date" class="col-sm-2 col-form-label">Datum sastanka</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="meeting_date" name="meeting_date" value="{{ $date }}">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary" style="float: right">Prihvati</button>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('clients.show', $client->getId()) }}" class="btn btn-dark" style="float: left">Nazad</a>
                </div>
            </div>
        </form>
    </div>
@endsection


