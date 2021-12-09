@extends('layouts.email')

@section('content')
    @php
        $user = $profile->getUsers()->first();
        $token = $user->getAttribute('remember_token');
    @endphp
    <div class="container" style="font-family: 'Roboto'; font-size: 12px; font-weight: normal">
        <p>Poštovani/a {{ $recipient }},</p>
        <p>NTP Beograd je kreirao korisnički nalog za Vas.</p>
        <p>Kliknite na ovaj link ili ga kopirajte u adresu Vašeg browsera, kako biste potvrdili vašu e-mail adresu.</p>
        <p><a href="{{ route('user.verify', ['token' => $token]) }}" target="_blank">{{ route('user.verify', ['token' => $token]) }}</a></p>
        <p>Ukoliko ste već potvrdili vašu e-mail adresu, možete se prijaviti sa vašim korisničkim imenom i lozinkom na adresi
            <a href="https://platforma.ntpark.rs/login" target="_blank">https://platforma.ntpark.rs/login</a>
        </p>
        <p>Srdačan pozdrav,</p>
        <p>Vaš NTP</p>
    </div>

@endsection
