@extends('layouts.email')

@section('content')
    @php
        $user = $profile->getUsers()->first();
        $token = $user->getAttribute('remember_token');
    @endphp
    <div class="container" style="font-family: 'Roboto Light'">
        <p>Hi {{ $recipient }},</p>
        <p>NTP Beograd je kreirao profil za Vas.</p>
        <p>Idite na ovaj link kako biste potvrdili vašu e-mail adresu. </p>
        <p>{{ route('profiles.verify', ['token' => $token]) }}</p>
        <p>Srdačan pozdrav,</p>
        <p>Vaš NTP</p>
    </div>

@endsection
