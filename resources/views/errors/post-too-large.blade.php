@extends('layouts.backbone')

@section('body-content')
    <div class="row bg-dark" style="height: 200px">
        <div class="col-6 col-lg-2 h-100">
            <img src="/images/custom/ntplogo.png" class="ml-3 mt-2 h-75" />
        </div>
        <div class="col-lg-8 text-center" style="display: flex; align-items: center; horiz-align: center">
            <span class="text-light w-100" style="font-family: 'Roboto Light'; font-size: 38px">
                PRIJAVNI FORMULAR</span>
        </div>
        <div class="col-6 col-lg-2 h-100">
            <div class="row h-100">
                <div class="col-4 h-100" style="align-items: center; display: flex">
                    <img src="/images/custom/rstartslogo.png" class="h-75 mt-auto mb-auto" />
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="height: 600px; margin: auto">
        <div class="col-6 offset-3 h-100" style="display: flex; flex-direction: column; justify-content: center">
            <div class="font-18" style="font-family: 'Roboto Light'" >
                Poštovani, <br />
                Post koji ste poslali prevazilazi dozvoljenu granicu u podacima. Molimo vas da vodite računa o veličini i broju fajlova.
                <ul>
                    <li>Maksimalna veličina fajla može biti ____ (MB/KB)</li>
                    <li>Maksimalan broj fajlova po prijavi - _____ </li>
                    <li>Molimo, vodite računa o smernicama za maksimalan broj karaktera koji je naznačen u naslovu polja</li>
                </ul>

            </div>
            <div class="text-center mt-5">
                <a type="button" role="button" class="btn btn-primary rounded-pill" href="{{ route('createRaisingStarts') }}" >NAZAD NA FORMULAR</a>
            </div>
        </div>

    </div>
@endsection


