@extends('layouts.email')

@section('content')
    @php
        $user = $mentor->getUsers()->first();
        $token = $user->getAttribute('remember_token');
    @endphp
    <div class="container" style="font-family: 'Roboto'; font-size: 12px; font-weight: normal">
        <p>Poštovani(a) {{ $recipient }},</p>
        <p>&nbsp;</p>
        <p>NTP Beograd je kreirao profil za Vas.</p>
        <p>Kliknite na ovaj link ili ga kopirajte u adresu Vašeg browsera, kako biste potvrdili vašu e-mail adresu.</p>
        <p><a href="{{ route('user.verify', ['token' => $token]) }}" target="_blank">{{ route('user.verify', ['token' => $token]) }}</a></p>
        <p>&nbsp;</p>
        <p>Srdačan pozdrav,</p>
        <p>Vaš NTP</p>
    </div>

@endsection

