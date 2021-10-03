@extends('layouts.hyper-vertical-profile-shortdata')

@section('profile-content')
    <div class="card h-100 overflow-auto p-0" style="position: absolute; top: 0px; bottom: 0px; right: 0px; left: 0px">
        <div class="card-body p-0">
            @php
                $status = $model->getAttribute('profile_status')->getValue();
                $program = $model->getActiveProgram();
                $programType = $program->getValue('program_type');
            @endphp
            @if( in_array($status, [1,2]))
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
                                        <a href="{{ route('profiles.apply', ['program' => \App\Business\Program::$RAISING_STARTS, 'profile' => $model->getId()]) }}" class="btn btn-primary">Prijavi se</a>
                                    </div> <!-- end card-body-->
                                </div> <!-- end col -->
                            </div> <!-- end row-->
                        </div>
                    </div>
                </div>

            @elseif( $programType != \App\Business\Program::$RAISING_STARTS && (  $status >= 4 && $status < 7) ||
                     $programType == \App\Business\Program::$RAISING_STARTS && ( $status == 4 || $status == 6))
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
            @elseif($programType == \App\Business\Program::$RAISING_STARTS && $status == 5)
                <div class="card row w-100 shadow" style="height:96%">
                    <div class="card-header bg-primary text-light">
                        <span class="h4 text-center">Demo Day</span>
                    </div>
                    <div class="card-body">
                        @php
                            $program = $model->getActiveProgram();
                            $demoday = $program->getDemoDay();
                        @endphp
                        <p class="font-weight-light font-14 ">Uspešno ste prošli proces predselekcije.</p>
                        <p class="font-weight-light font-14 ">Sada je neophodno da nam do {{ $demoday->getText('demoday_date') }} prosledite sledeće datoteke:
                            1.) Opis datoteke 1; 2.) Opis datoteke 2.</p>
                        <h4 class="text-center mt-5">Priložite datoteke</h4>
                        <form id="myFilesForm" method="POST" enctype="multipart/form-data" action="{{route('demoday.sendfiles')}}">
                            @csrf
                            <input type="hidden" id="demodayId" name="demodayId" value="{{ $demoday->getId() }}">
                            <input type="hidden" id="profileId" name="profileId" value="{{ $program->getProfile()->getId() }}">
                            <div class="form-group">
                                <label for="demoday_files" class="col-form-label col-form-label-sm">Priložite datoteke</label>
                                <input type="file" id="demoday_files" name="demoday_files[]" multiple class="form-control">
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-sm btn-primary" id="buttonSendFiles">
                                    <span id="button_spinner_send" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                                    <span id="button_text">Posalji fajlove</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="buttonReset">Odustani</button>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif($status == 7)
                <div class="card position-absolute" style="left: 0px; top: 0px; right: 0px; bottom: 0px" >
                    <div class="card-header bg-dark text-light text-center">
                        {{ mb_strtoupper(__('Contract Signing')) }}
                    </div>
                    <div class="card-body">
                        @php
                            $preselection = $program->getPreselection();
                        @endphp
                        <p>Zadovoljstvo nam je da Vas obavestimo da ste prošli postupak @if($preselection != null) preselekcije i @endif selekcije.</p>
                        <p>Program koji ste izabrali - '{{ $program->getValue('program_name') }}' podrazumeva potpis ugovora.</p>
                        @if($program->getContract()->getValue('signed_at') == null)
                            <p>Bićete obavešteni putem e-mail-a o mestu i vremenu potpisa ugovora.</p>
                        @else
                            <p>Potpis ugovora će se održati u prostorijama NTP {{ $program->getContract()->getText('signed_at') }}.</p>
                        @endif

                    </div>
                </div>
            @elseif($status == 9)
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
            @else
                <div class="card border" style="height: 95%">
                    <div class="card-header bg-dark text-light">
                        {{ mb_strtoupper( __("Application Form"))}}
                    </div>
                    <div class="card-body overflow-auto p-0" style="height: 80%">
                        @include('profiles.partials._show_profile_data')
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#buttonSendFiles').click(function() {
                $('#button_spinner_send').attr('hidden', false);
                var data = new FormData($('form#myFilesForm')[0]);
                var token = $('form#myFilesForm input[name="_token"]').val();
                $.ajax({
                    url: '/demoday/sendfiles',
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: data,
                    headers: {
                        'X-CSRF-Token' : token
                    },
                    success: function (data) {
                        // The file was uploaded successfully...
                        console.log(data);
                        $('#button_spinner_send').attr('hidden', true);
                    },
                    error: function (data) {
                        // there was an error.
                        console.log(data);
                        $('#button_spinner_send').attr('hidden', true);
                    }
                });
            });
            $('#buttonReset').click(function() {
                location.reload();
            })
        })
    </script>
@endsection


