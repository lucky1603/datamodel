
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 style="text-align: center;margin-bottom: 50px;margin-top:30px">Finalna selekcija klijenta - {{ $client->getData()['name'] }}</h1>
            </div>
        </div>
        <form method="POST" enctype="multipart/form-data" action="{{ route('clients.selected', $client->getId()) }}">
            @csrf
            <div class="form-group row">
                <label for="meeting_notes" class="col-sm-2 col-form-label">Beleske sa sastanka</label>
                <div class="col-sm-10">
                    <textarea id="meeting_notes" name="meeting_notes" rows="4" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="mark" class="col-sm-2 col-form-label">Konačna ocena</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="mark" name="mark">
                </div>
            </div>
            <div class="form-group row">
                <label for="decision" class="col-sm-2 col-form-label">Odluka</label>
                <div class="col-sm-10" style="margin-top:10px">
                    <input type="radio" id="da" name="decision" value="yes" style="margin-right: 10px">
                    <label for="da">Prošao</label>
                    <input type="radio" id="ne" name="decision" value="no" style="margin-left: 20px; margin-right: 10px" checked>
                    <label for="ne">Nije prošao</label>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary" style="float: right">Prihvati</button>
                </div>
                <div class="col-sm-6">
                    <a href="#" class="btn btn-dark" style="float: left">Nazad</a>
                </div>
            </div>
        </form>
    </div>
@endsection
