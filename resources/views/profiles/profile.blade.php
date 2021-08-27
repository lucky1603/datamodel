@extends('layouts.hyper-vertical-profile-pre')

@section('profile-content')
    <div class="card" style="position: absolute; top: 0px; bottom: 0px; right: 0px; left: 0px">
        <div class="card-body">
            @if( in_array($model->getAttribute('profile_status')->getValue(), [1,2]))
                <h1 class="text-center">Programi</h1>
                <p class="text-center font-16 font-italic mb-4">Da biste nastavili neophodno je da izaberite jedan od programa.
                    Ako niste sigurni slobodno nas <a href="mailto://info@ntppark.gov.rs" target="_blank">kontaktirajte</a> za više opcija.
                    Popunjeni formular se čuva sve dok ga ne pošaljete izborom opcije "Pošalji". Podaci se čuvaju izborom opcije - "Sačuvaj".
                    Formular je nemoguće poslati sve dok se ispravno ne popuni.
                </p>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-4">
                                    <img src="/images/custom/noimage.png" class="card-img" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Inkubacija BITF</h5>
                                        <p class="card-text">Nešto o programu. Nešto o programu. Nešto o programu. Nešto o programu.
                                            Nešto o programu. Nešto o programu. Nešto o programu.</p>
                                        <a href="{{ route('profiles.apply', ['program' => 5, 'profile' => $model->getId()]) }}" class="btn btn-primary">Prijavi se</a>
                                    </div> <!-- end card-body-->
                                </div> <!-- end col -->
                            </div> <!-- end row-->
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-4">
                                    <img src="/images/custom/noimage.png" class="card-img" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">RASTUĆE KOMPANIJE</h5>
                                        <p class="card-text">Nešto o programu. Nešto o programu. Nešto o programu. Nešto o programu.
                                            Nešto o programu. Nešto o programu. Nešto o programu.</p>
                                        <a href="#" class="btn btn-primary">Prijavi se</a>
                                    </div> <!-- end card-body-->
                                </div> <!-- end col -->
                            </div> <!-- end row-->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="row no-gutters align-items-center">
                                <div class="col-md-4">
                                    <img src="/images/custom/noimage.png" class="card-img" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">RAISING STARTS</h5>
                                        <p class="card-text">Nešto o programu. Nešto o programu. Nešto o programu. Nešto o programu.
                                            Nešto o programu. Nešto o programu. Nešto o programu.</p>
                                        <a href="#" class="btn btn-primary">Prijavi se</a>
                                    </div> <!-- end card-body-->
                                </div> <!-- end col -->
                            </div> <!-- end row-->
                        </div>
                    </div>
                </div>

            @elseif($model->getAttribute('profile_status')->getValue() >= 4 && $model->getAttribute('profile_status')->getValue() < 8)
                <div class="card" style="position: absolute; top: 0px; bottom:0px; left: 0px; right: 0px;">
                    <div class="card-header bg-dark text-light text-center">{{ mb_strtoupper('Uspešna prijava na program') }}</div>
                    <div class="card-body">
                        <p class="font-weight-light font-14 ">Prijava na program <span class="attribute-label font-weight-bold">{{ $model->getActiveProgram()->getAttribute('program_name')->getValue() }}</span>
                            je uspešno izvršena. Podaci koje ste poslali će biti analizirani i naša komisija će odlučiti da li vaša kandidatura odgovara
                            vašim realnim mogućnostima. Takođe, moguće je da ćete biti pozvani na sastanak, ukoliko će biti neophodno da detaljnije objasnite neke
                            od podataka koje ste naveli u prijavi.</p>
                        <p class="font-weight-light font-14">
                            U slučaju pozitivnog odgovora komisije, u zavisnosti od programa koji ste izabrali, može da se desi da budete pozvani na potpis ugovora.
                            Ukoliko nije neophodan potpis ugovora, po pozitivnoj odluci komisije, bićete odmah u mogućnosti da koristite mogućnosti predviđene programom
                            koji ste odabrali.
                        </p>
                        <p class="font-weight-light font-14">U međuvremenu možete pogledati video koji smo pripremili u kojem su u kratkim crtama opisane aktivnosti
                            koje se sprovode u okviru naših programa.
                        </p>
                        <div class="row">
                            <div class="offset-sm-2 col-sm-8">
                                <div class="embed-responsive embed-responsive-4by3">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/PrUxWZiQfy4?ecver=1"></iframe>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @elseif($model->getAttribute('profile_status')->getValue() == 8)
                <div class="card" style="position: absolute; top: 0px; bottom:0px; left: 0px; right: 0px;">
                    <div class="card-header bg-dark text-light text-center">{{ mb_strtoupper(__('Application Rejected')) }}</div>
                    <div class="card-body">
                        <p>
                            Vaša je prijava na program
                                <span class="attribute-label font-weight-bold">{{ strtoupper($model->getActiveProgram()->getAttribute('program_name')->getValue()) }}</span>
                            je nažalost odbijena.

                            Komisija je zasedala <span class="attribute-label font-weight-bold">{{ $model->getActiveProgram()->getPreselection()->getAttribute('date_of_session')->getText() }}</span> i
                            zbog nedostataka u procesu prijave donela odluku da ne ispunjavate uslove za učestvovanje u programu.
                        </p>
                        <h4 class="text-center attribute-label">{{ mb_strtoupper(__('Preselection'))}} - {{ mb_strtoupper( __('Report'))}}</h4>
                        @php
                            $preselection = $model->getActiveProgram()->getPreselection();
                        @endphp
                        <table class="table table-bordered">
                            @foreach($preselection->getAttributes() as $attribute)
                                <tr>
                                    <td class="attribute-label font-weight-bold">{{ $attribute->label }}</td>
                                    <td>{{ $attribute->getText() }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="text-center">
                            <button>Ok</button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection


