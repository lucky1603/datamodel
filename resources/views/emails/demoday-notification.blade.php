@extends('layouts.email')

@section('content')
    @php
        $program = $profile->getActiveProgram();
        $demoDay = $program->getDemoDay();
    @endphp

    @if($passed)
        <div class="container" style="font-family: 'Roboto'; font-size: 12px; font-weight: normal">
            <p>Poštovani/a,</p>
            <p>&nbsp;</p>
            <p>Datoteke koje ste poslali su uspešno primljene i validiranje. Prošli ste u proces selekcije.</p>
            <p>Po završetku procesa selekcije ćete biti obavešteni o rezultatima.</p>
            <p> </p>
            <p>Srdačan pozdrav,</p>
            <p>Vaš NTP</p>
        </div>
    @else
        <div class="container" style="font-family: 'Roboto'; font-size: 12px; font-weight: normal">
            <p>Poštovani/a,</p>
            <p>&nbsp;</p>
            <p>Uspešno ste prošli proces predselekcije sa srednjom ocenom - {{ $program->getPreselection()->getValue('average_mark')}}.</p>
            <p>Dalje učešće u konkurisanju za program '{{ $program->getValue('program_name') }}' podrazumeva da najkasnije do datuma {{ $demoDay->getText('demoday_date') }} pošaljete
               u formi datoteka sledeće dokumente:</p>
            <ul>
                <li>1. Dokument 1</li>
                <li>2. Dokument 2</li>
                <li>3. itd. itd.</li>
            </ul>
            <p> </p>
            <p>Srdačan pozdrav,</p>
            <p>Vaš NTP</p>
        </div>
    @endif
@endsection
