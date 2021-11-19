@extends('layouts.email')

@section('content')
    <div class="container" style="font-family: 'Roboto'; font-size: 12px; font-weight: normal">
        <p>Poštovani,</p>
        <p>Vaša prijava na program '{{ $program->getValue('program_name') }}' je uspešno poslata.</p>
        <p>
            Komisija će pregledati vašu prijavu i odlučiti da li vaša kompanija zadovoljava uslove za
            učestvovanjeu programu. Po donošenju odluke bićete obavešteni o ishodu evaluacije.
        </p>
        <p>Srdačan pozdrav,<br />
        Vaš NTP</p>
    </div>
@endsection
