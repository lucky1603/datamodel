@extends('layouts.backbone')

@section('title')
    Raising Starts - Potvrda kreiranja profila
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
    <div class="row" style="height: 600px; margin: auto">
        <div class="col-6 offset-3 h-100" style="display: flex; flex-direction: column; justify-content: center">
            <div class="font-18" style="font-family: 'Roboto Light'; display: flex; flex-direction: column; align-items: center; justify-content: center" >
                <p>Poštovani,</p>
                <p>
                    Na osnovu vaših podataka kreiran je profil za vas. Na Vašu email adresu je poslat email sa verifikacionim linkom.
                    Kada se prijavite na svoj profil, bićete u mogućnosti da nastavite sa popunjavanjem podataka iz prijave.
                </p>

                <p class="font-12 mt-4 text-dark">
                    <strong>Ukoliko ne možete da pronadjete e-mail pogledajte spam folder ili nas kontaktirajte na <a href="mailto://event@ntpark.rs">event@ntpark.rs</a></strong>
                </p>
            </div>
            <div class="text-center mt-5">
                <a type="button" role="button" class="btn btn-primary rounded-pill" href="https://ntpark.rs" >NA GLAVNU STRANU</a>
            </div>


        </div>

    </div>
@endsection


