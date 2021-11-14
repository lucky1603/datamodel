@extends('layouts.hyper-vertical-profile')

@section('content')
    <div class="card overflow-auto p-0" style="height: 90vh">
        <div class="card-body p-0 h-100 mb-auto">
            @php
                $status = $model->getValue('profile_status');
                $program = $model->getActiveProgram();
                if($program != null) {
                    $programType = $program->getValue('program_type');
                    $programStatus = $program->getValue('program_status');
                    }
            @endphp

            @if( in_array($status, [1,2]))
                <h1 class="text-center bg-primary text-light p-2">Programi</h1>
                <p class="text-center font-16 font-italic mb-4">Da biste nastavili neophodno je da izaberite jedan od programa.
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
                                        <a href="{{ route('profiles.apply', ['program' => 5, 'profile' => $model->getId()]) }}" class="btn btn-primary">Prijavi se</a>
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
                                        <a href="#" class="btn btn-primary">Prijavi se</a>
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
                                        <a href="{{ route('profiles.apply', ['program' => \App\Business\Program::$RAISING_STARTS, 'profile' => $model->getId()]) }}" class="btn btn-primary">Prijavi se</a>
                                    </div> <!-- end card-body-->
                                </div> <!-- end col -->
                            </div> <!-- end row-->
                        </div>
                    </div>
                </div>

            @elseif( $status == 3 && $programStatus == 1)
                <span class="text-light">{{ $status }} -- {{ $programStatus }}</span>
                <div class="card border" style="height: 95%">
                    <div class="card-header bg-dark text-light">
                        {{ mb_strtoupper( __("Application Form"))}}
                    </div>
                    <div class="card-body overflow-auto p-0" style="height: 80%">
                        @include('profiles.partials._show_profile_data')
                    </div>
                </div>
            @elseif( $status == 3 && $programStatus > 1)
                @if($program instanceof \App\Business\RaisingStartsProgram)
                    @if($programStatus == 2)
                        <div class="card w-100" style="height:100%">
                            <div class="card-header bg-primary text-light">
                                <span class="h4 text-center">Evaluacija prijave</span>
                            </div>
                            <div class="card-body h-100">
                                <p>Vasa prijava se trenutno ocenjunje.</p>
                                <p>Uskoro cete biti obavesteni o rezultatima ocenjivanja.</p>
                            </div>
                        </div>
                    @elseif($programStatus == 3)
                        <div class="card row w-100 shadow" style="height:96%">
                            <div class="card-header bg-primary text-light">
                                <span class="h4 text-center">Faza 1</span>
                            </div>
                            @php
                                $faza = $program->getWorkflow()->phases->get(3);
                                $filesSent = $faza->getValue('files_sent');
                                $date = $faza->getValue('due_date');
                                $formattedDate = $faza->getText('due_date');
                            @endphp
                            <div class="card-body text-dark">
                                <p>Vaša prijava je prihvaćena.</p>
                                @if($date != null)
                                    @if($filesSent != true)
                                        <p>Do {{ $formattedDate }} je neophodno da upload-ujete sledece fajlove:</p>
                                        <ul>
                                            <li>1. Fajl 1</li>
                                            <li>2. Fajl 2</li>
                                            <li>3. Fajl 3</li>
                                        </ul>
                                        <p>Takođe, neophodno je da prisustvujete sledećim događajima:</p>
                                        <ul>
                                            <li>1. Trening I</li>
                                            <li>2. Trening II</li>
                                            <li>3. Trening III</li>
                                            <li>4. Trening IV</li>
                                            <li>5. Trening V</li>
                                        </ul>
                                        <p>Kao i eventualnim dodatnim događajima koje specificira NTP.</p>
                                        <form
                                            id="myFilesForm"
                                            method="POST"
                                            enctype="multipart/form-data"
                                            action="#">
                                            @csrf
                                            <input type="hidden" id="id" name="id" value="{{ $faza->getId() }}">
                                            <input type="hidden" id="profile" name="profile" value="{{ $model->getId() }}">
                                            <div class="form-group">
                                                <label for="requested_files" class="col-form-label col-form-label-sm attribute-label">Datoteke za slanje</label>
                                                <input type="file" multiple id="requested_files" name="requested_files[]" class="form-control form-control-file">
                                            </div>
                                            <div class="text-center">
                                                <button type="button" id="btnSend" class="btn btn-sm btn-primary">Pošalji</button>
                                            </div>
                                        </form>
                                    @else
                                        <p>Datoteke su uspešno poslate.</p>
                                        <p>Uskoro ćete biti obavešteni o odluci komisije.</p>
                                    @endif
                                @else
                                    <p>Uskoro cete dobiti instrukcije o datotekama koje je potrebno da posaljete, kao i vremenski rok do kojeg je neophodno da to ucinite.</p>
                                @endif
                            </div>
                        </div>
                    @elseif($programStatus == 4)
                        <!-- Demo Day -->
                        <div class="card w-100 h-100 shadow text-dark">
                            <div class="card-header bg-primary text-light">
                                DEMO DAY
                            </div>
                            <div class="card-body">
                                <p>Prošli ste fazu 1.</p>
                                <p>Nadalje, da biste bili prihvaceni na program, morate odslusati sledece treninge:</p>
                                <ul>
                                    <li>1. Trening I</li>
                                    <li>2. Trening II</li>
                                    <li>3. Trening III</li>
                                    <li>4. Trening IV</li>
                                    <li>5. Trening V</li>
                                </ul>
                                <p>Spisak treninnga za vas, nalazi se u delu vašeg profila, na koji ćete doći izborom opcije <b>"DOGAĐAJI"</b> iz menija sa leve strane ekrana.</p>
                                <p>Prijavite se za sve događaje na listi i učestvujte na njima. Po uspešnom učešću na tim događajima ispunićete uslove za korišćenje programa.</p>
                            </div>

                        </div>
                    @else
                        <!-- Contract -->
                        <div class="card row w-100 shadow" style="height:96%">
                            <div class="card-header bg-primary text-light">
                                <span class="h4 text-center">Fajlovi uspesno poslati</span>
                            </div>
                            <div class="card-body">

                            </div>
                        </div>
                    @endif
                @else
                    <div class="card w-100 h-100">
                        <div class="card-header bg-primary text-light">
                            USPEŠNA PRIJAVA
                        </div>
                        <div class="card-body text-dark font-14">
                            <p>Uspešno ste se prijavili na program "{{ $program->getValue('program_name') }}".</p>
                            <p>Uskoro će se obaviti postupak predselekcije i bićete pozvani na sastanak u prostorijama
                                NTP Beograd. O terminu sastanka ćete biti obavešteni putem elektronske pošte, na adresu
                                koju ste naveli u prijavi.</p>
                            <p>Posle postupka predselekcije, ukoliko je prođete, sledi postupak selekcije, a zatim u slučaju
                               pozitivnog ishoda selekcij i potpis ugovora. O ishodima ovih postupaka ćete biti blagovremeno
                               obaveštavani putem elektronske pošte. U međuvremenu možete pogledati video koji ilustruje aktivnosti
                               u okviru NTP parka.</p>
                            <!-- 21:9 aspect ratio -->
                            <div class="embed-responsive embed-responsive-21by9 mt-4">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/PrUxWZiQfy4?autohide=0&showinfo=0&controls=0"></iframe>
                            </div>

                        </div>
                    </div>
                @endif


            @elseif($status == 4)
                <div class="card border" style="height: 95%">
                    <div class="card-header bg-dark text-light">
                        {{ mb_strtoupper( __("Application Form"))}}
                    </div>
                    <div class="card-body overflow-auto p-0" style="height: 80%">
                        @include('profiles.partials._show_profile_data')
                    </div>
                </div>
            @elseif($status == 5)
                <div class="card" style="position: absolute; top: 0px; bottom:0px; left: 0px; right: 0px;">
                    <div class="card-header bg-dark text-light text-center">{{ mb_strtoupper(__('Application Rejected')) }}</div>
                    <div class="card-body">
                        <p>
                            Vaša je prijava na program
                                <span class="attribute-label font-weight-bold">{{ strtoupper($model->getActiveProgram()->getAttribute('program_name')->getValue()) }}</span>
                            je nažalost odbijena.


                        </p>

                        <div class="text-center">
                            <button type="button" class="btn btn-sm btn-primary rounded-pill">Ok</button>
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
            $('#btnSend').click(function() {
                $('#button_spinner_send').attr('hidden', false);
                var data = new FormData($('form#myFilesForm')[0]);
                var token = $('form#myFilesForm input[name="_token"]').val();
                $.ajax({
                    url: '/faza1/sendfiles',
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
                        location.reload();
                    },
                    error: function (data) {
                        // there was an error.
                        console.log(data);
                        $('#button_spinner_send').attr('hidden', true);
                        location.reload();
                    }
                });
            });
            $('#buttonReset').click(function() {
                location.reload();
            });
        })
    </script>
@endsection


