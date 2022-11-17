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
                <p class="mb-4">Sjajno!</p>
                @if (isset($message))
                    {{ $message}}
                @else
                    <p>
                        Na osnovu podataka koje ste naveli kreiran je vaš profil, <strong>a na e-mail adresu koju ste uneli poslat je
                        verifikacioni link. Klikom na njega aktivirate profil.</strong> Prijavom na svoj profil bićete u mogućnosti da
                        započnete popunjavanje prijave za program Raising Starts. Ukoliko ne možete da pronađete e-mail proverite
                        i spam folder ili nas kontaktirajte na <a href="mailto://event@ntpark.rs">event@ntpark.rs</a>.
                    </p>
                @endif
            </div>



        </div>

    </div>
@endsection


