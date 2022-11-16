@extends('layouts.email')

@section('content')
    @php
        $user = $profile->getUsers()->first();
        $token = $user->getAttribute('remember_token');
    @endphp
    <div class="container" style="font-family: 'Roboto'; font-size: 12px; font-weight: normal">
        <p>Poštovani/a {{ $recipient }},</p>
        <p>Uspešno ste registrovali profil za popunjavanje prijave za <span style="color: #0088ff"><u>Raising Starts</u></span>.</p>
        <p>Kliknite na link ispod ili ga kopirajte u adresu browsera, kako biste potvrdili e-mail adresu i kreirali vašu jedinstvenu šifru.</p>
        <p><a href="{{ route('user.verify', ['token' => $token]) }}" target="_blank">{{ route('user.verify', ['token' => $token]) }}</a></p>
        <p>Ukoliko ste već potvrdili vašu e-mail adresu, možete se prijaviti sa vašim korisničkim imenom i lozinkom na adresi
            <a href="https://platforma.ntpark.rs/login" target="_blank">https://platforma.ntpark.rs/login</a>
        </p>
        <p>Prijavu možete popunjavati iz više puta i čuvati na svom profile pre finalnog podnošenja. Detaljnije uputstvo i korake
            kroz prijavu možete pogledati u <a href="#">VIDEU</a>.</p>
        <p>Srdačan pozdrav,</p>
        <p>Raising Starts tim</p>
    </div>

@endsection
