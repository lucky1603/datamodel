@extends('layouts.email')

@section('content')
    <div class="container" style="font-family: 'Roboto'; font-size: 12px; font-weight: normal">
        <p>Dragi/a {{ $recipient }},</p>
        <p>
            Vaša prijava za '{{ $program->getValue('program_name') }}' je uspešno poslata.
        </p>
        <p>Srećno,<br />Raising Starts tim</p>
    </div>
@endsection
