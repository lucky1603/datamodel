@extends('layouts.email')

@section('content')
<div class="container" style="font-family: 'Roboto'; font-size: 12px; font-weight: normal">
    <p>Poštovani/a,</p>
    <p>
        Ovaj automatski mail rezultat je Vašeg nedavnog zahteva za promenu lozinke.
        Ukoliko ste vi uputili ovaj zahtev kliknite na <a id="passLink" href="{{ route('user.changePasswordFromEmail', ['token' => $token]) }}"> ovaj link.</a>
    </p>
    <p>
        Ukoliko Vi niste inicijalizovali ovu akciju, zanemarite ovu poruku.
    </p>
    <p>Puno pozdrava od NTP Beograd tima</p>
</div>
@endsection
