@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 style="text-align: center;margin-bottom: 50px;margin-top:30px">Predselekcija klijenta - {{ $client->getData()['name'] }}</h1>
            </div>
        </div>
        <form method="POST" enctype="multipart/form-data" action="{{ route('clients.preselected', $client->getId()) }}">
            @csrf
            <div class="form-group row">
                <label for="eval_date" class="col-sm-2 col-form-label">Datum</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="eval_date" name="eval_date">
                </div>
            </div>
            <div class="form-group row">
                <label for="mark" class="col-sm-2 col-form-label">Procečna ocena</label>
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
            <div class="form-group row">
                <label for="remark" class="col-sm-2 col-form-label">Dodatne napomene</label>
                <div class="col-sm-10" style="margin-top:10px">
                    <textarea rows="4" id="remark" name="remark" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="assertion_file" class="col-sm-2 col-form-label">Priloži evaluacioni fajl</label>
                <div class="col-sm-10" style="margin-top:10px">
                    <input type="file" id="assertion_file" name="assertion_file"/>
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
