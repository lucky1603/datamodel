@extends('layouts.email')

@section('content')
    <div class="container" style="font-family: 'Roboto'; font-size: 12px; font-weight: normal">
        <p>Poštovani,</p>
        <p>
            Uspešno ste se prijavili za '{{ $program->getValue('program_name') }}' program.
            Nakon završetka procesa selekcije bićete obavešteni o rezultatima izbora druge
            generacije Raising Starts pred-akceleratorskog programa.
        </p>
        <p>Puno pozdrava od NTP Beograd tima</p>
    </div>
@endsection
