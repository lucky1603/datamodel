@extends('layouts.backbone')

@section('title')
    Raising Starts - Stranica u izradi
@endsection

@section('body-content')
    <div class="row bg-dark" >
        <div class="col-lg-4 h-100">
            <img src="/images/custom/ntplogo.png" class="ml-3 m-4" style="width: 90%"/>
        </div>

        <div class="col-lg-3 offset-lg-5 h-100" style="display: flex; align-items: center; justify-content: center">
            <img src="/images/custom/rstartslogo.png" class="m-4" style="height: 150px"/>
        </div>
    </div>
    <div class="row" style="margin-top: 50px">
        <div class="col-6 offset-3 h-100" style="display: flex; flex-direction: column; justify-content: center">
            <div style="display: flex;flex-direction: column; align-items: center; justify-content: center">
                <img src="{{ asset('images/custom/underconstruction.png') }}">
                <p style="font-size: 24px; margin-top: 30px">Stranica trenutno nije u funkciji. Molimo vas za malo strpljenja!</p>
            </div>
        </div>

    </div>
@endsection


