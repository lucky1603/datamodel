@extends('layouts.hyper-vertical')

@section('page-header')
    <div class="w-50 d-inline-block" style="height: 7vh">
        <div><span class="h4" style="position: relative; top:2vh; left: 1vh">{{ $profile->getValue('name') }}</span></div>
        <div><span class="text-primary font-12" style="position: relative; top: 2vh; left: 1vh">PRIJAVA NA PROGRAM</span></div>
    </div>
@endsection

@section('content')
    <h1 class="text-center bg-primary text-light p-2">Programi</h1>
    <p class="text-center font-16 font-italic mb-4">Da biste nastavili neophodno je da izaberete jedan od programa.
        Ako niste sigurni slobodno nas <a href="mailto://info@ntppark.gov.rs" target="_blank">kontaktirajte</a> za više opcija.
        Popunjeni formular se čuva sve dok ga ne pošaljete izborom opcije "Pošalji". Podaci se čuvaju izborom opcije - "Sačuvaj".
        Formular je nemoguće poslati sve dok se ispravno ne popuni.
    </p>
    <hr>
    <div class="row">
        <div class="col-sm-6">
            <div class="card m-2 shadow-lg">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-4 bg-light">
                        <img src="/images/custom/inkubacija.png" class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Inkubacija BITF</h5>
                            <p class="card-text">Nešto o programu. Nešto o programu. Nešto o programu. Nešto o programu.
                                Nešto o programu. Nešto o programu. Nešto o programu.</p>
                            @if($profile->hasProgram(\App\Business\Program::$INKUBACIJA_BITF))
                                <p class="h4 text-primary text-center mt-4">{{ mb_strtoupper(__('You are already on that program')) }}</p>
                            @else
                            <a
                                href="{{ route('programs.apply', ['program' => \App\Business\Program::$INKUBACIJA_BITF, 'profile' => $profile->getId()]) }}"
                                class="btn btn-primary"
                                >{{ __('gui.Apply-Yourself') }}</a>
                            @endif
                        </div> <!-- end card-body-->
                    </div> <!-- end col -->
                </div> <!-- end row-->
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card m-2 shadow-lg">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-4 bg-light">
                        <img src="/images/custom/rastuce.png" class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">RASTUĆE KOMPANIJE</h5>
                            <p class="card-text">Nešto o programu. Nešto o programu. Nešto o programu. Nešto o programu.
                                Nešto o programu. Nešto o programu. Nešto o programu.</p>
                            <a href="#" class="btn btn-primary">{{ __('gui.Apply-Yourself') }}</a>
                        </div> <!-- end card-body-->
                    </div> <!-- end col -->
                </div> <!-- end row-->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 h-100">
            <div class="card m-2 shadow-lg h-100">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-4 bg-primary text-light p-3 overflow-hidden h-100">
                        <img src="/images/custom/raisingstarts.png" class="h-100" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">RAISING STARTS</h5>
                            <p class="card-text">Nešto o programu. Nešto o programu. Nešto o programu. Nešto o programu.
                                Nešto o programu. Nešto o programu. Nešto o programu.</p>
                            @if($profile->hasProgram(\App\Business\Program::$RAISING_STARTS))
                                <p class="h4 text-primary text-center mt-4">{{ mb_strtoupper(__('You are already on that program')) }}</p>
                            @else
                            <a href="{{ route('programs.apply', ['program' => \App\Business\Program::$RAISING_STARTS, 'profile' => $profile->getId()]) }}"
                               class="btn btn-primary"
                               >{{ __('gui.Apply-Yourself') }}</a>
                            @endif
                        </div> <!-- end card-body-->
                    </div> <!-- end col -->
                </div> <!-- end row-->
            </div>
        </div>
    </div>
@endsection

@section('sidemenu')
    <li class="side-nav-item">
        <a href="{{route('profiles.show', ['profile' => $profile->getId()])}}" class="side-nav-link">
            <i class="uil-dashboard"></i>
            <span>{{ mb_strtoupper( __('Back')) }}</span>
        </a>
    </li>
@endsection

