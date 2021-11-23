@extends('layouts.backbone')

@section('title')
    Raising Starts - Potvrda slanja forme
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
                <p>
                    Formular sa vašim podacima je uspešno poslat. O rezultatima evaluacije vaših podataka ćete biti obavešteni putem elektronske pošte.
                </p>

            </div>
            <div class="text-center mt-5">
                <a type="button" role="button" class="btn btn-primary rounded-pill" href="https://ntpark.rs" >NA GLAVNU STRANU</a>
            </div>

        </div>

    </div>
@endsection


