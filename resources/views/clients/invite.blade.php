@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 style="text-align: center;margin-bottom: 50px;margin-top:30px">Pozivanje klijenta '{{ $client->getData()['name'] }}' na sastanak</h1>
            </div>
        </div>
        <form method="POST" enctype="multipart/form-data" action="{{ route('clients.invited', $client->getId()) }}">
            @csrf
            <div class="form-group row">
                <label for="meeting_date" class="col-sm-2 col-form-label">Datum sastanka</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="meeting_date" name="meeting_date">
                </div>
            </div>
            <div class="form-group row">
                <label for="meeting_place" class="col-sm-2 col-form-label">Mesto sastanka</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="meeting_place" name="meeting_place">
                </div>
            </div>
            <div class="form-group row">
                <label for="meeting_participants" class="col-sm-2 col-form-label">Prisutni na sastanku</label>
                <div class="col-sm-10" style="margin-top:10px">
                    <textarea rows="4" id="meeting_participants" name="meeting_participants" class="form-control"></textarea>
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

