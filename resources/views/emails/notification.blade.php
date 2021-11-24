@extends('layouts.email')

@section('content')
    @php
        $user = $profile->getUsers()->first();
        $recipient = $profile->getAttribute('contact_person')->getText();
    @endphp
    @if($type == \App\Mail\MeetingNotification::$CONTRACT)
        <div class="container" style="font-family: 'Roboto'; font-size: 12px; font-weight: normal">
            <p>Poštovani/a,</p>
            <p>&nbsp;</p>
            <p>Kako ste već prethodno upoznati, komisija je odobrila vaš zahtev da učestvujete u programu {{ $profile->getActiveProgram()->getAttribute('program_name')->getText() }}.
                Pre nego što počnete da koristite članstvo u programu, neophodno je da se potpiše ugovor između predstavnika Vaše firme
                i predstavnika NTP Beograd.</p>
            <p>Predloženi datum za potpis ugovora je {{ $profile->getActiveProgram()->getContract()->getAttribute('signed_at')->getText() }}, a mesto potpisa su prostorije NTP Beograd.</p>
            <p>&nbsp;</p>
            <p>Srdačan pozdrav,</p>
            <p>Vaš NTP</p>
        </div>
    @endif

@endsection
