@extends('layouts.backbone')

@section('body-content')
    <div class="row bg-dark" style="height: 100px">
        <div class="col-6 col-lg-2 h-100">
            <img src="/images/custom/white-logo-transparent-full.png" class="ml-3 mt-2 h-75" />
        </div>
        <div class="col-lg-8 text-center" style="display: flex; align-items: center; horiz-align: center">
            <span class="font-24 text-light w-100" style="font-family: 'Roboto Light'">
                {{strtoupper(__('Create Your Profile')) }}</span>
        </div>
        <div class="col-6 col-lg-2 h-100">
            <div class="row h-100">
                <div class="col-4 h-100" style="align-items: center; display: flex">
                    <img src="/images/custom/whiterocket.png" class="h-75 mt-auto mb-auto" />
                </div>
                <div class="col-8 h-100" style="align-items: center; display: flex">
                    <span class="text-light font-24" style="font-family: 'Roboto Light'">ACCELERATOR</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="height: 600px; margin: auto">
        <div class="col-6 offset-3 h-100" style="display: flex; flex-direction: column; justify-content: center">
            <div class="font-18" style="font-family: 'Roboto Light'; display: flex; flex-direction: column; align-items: center; justify-content: center" >
                <p>Poštovani,</p>
                <p>
                    Na osnovu vaših podataka kreiran je profil za vas. Na Vašu email adresu je poslat email sa verifikacionim linkom.
                    Kada se prijavite na svoj profil, bićete u mogućnosti da nastavite sa popunjavanjem podataka iz prijave.
                </p>
            </div>
            <div class="text-center mt-5">
                <a type="button" role="button" class="btn btn-primary rounded-pill" href="https://ntpark.rs" >NA GLAVNU STRANU</a>
            </div>
        </div>

    </div>
@endsection


