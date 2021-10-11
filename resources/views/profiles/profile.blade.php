@extends('layouts.hyper-vertical-profile-shortdata')

@section('profile-content')
    <h4>{{ $model->getValue('name') }}</h4>
    <div class="card h-100 overflow-auto p-0" style="position: absolute; top: 0px; bottom: 0px; right: 0px; left: 0px">
        <div class="card-body p-0">
            @php
                $status = $model->getValue('profile_status');
                $program = $model->getActiveProgram();
                if($program != null) {
                    $programType = $program->getValue('program_type');
                    $programStatus = $program->getValue('program_status');
                    }
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
                        <div class="card row w-100 shadow" style="height:96%">
                            <div class="card-header bg-primary text-light">
                                <span class="h4 text-center">Evaluacija prijave</span>
                            </div>
                            <div class="card-body">
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
                            <div class="card-body">
                                <p>Vasa prijava je prihvaćena.</p>
                                @if($date != null)
                                    @if($filesSent != true)
                                        <p>Do {{ $formattedDate }} je neophodno da upload-ujete sledece fajlove:</p>
                                        <ul>
                                            <li>1. Fajl 1</li>
                                            <li>2. Fajl 2</li>
                                            <li>3. Fajl 3</li>
                                        </ul>
                                        <form
                                            id="myFilesForm"
                                            method="POST"
                                            enctype="multipart/form-data"
                                            action="/faza1/sendfiles">
                                            @csrf
                                            <input type="hidden" id="id" name="id" value="{{ $faza->getId() }}">
                                            <input type="hidden" id="profile" name="profile" value="{{ $model->getId() }}">
                                            <div class="form-group">
                                                <label for="requested_files" class="col-form-label col-form-label-sm attribute-label">Datoteke za slanje</label>
                                                <input type="file" multiple id="requested_files" name="requested_files[]" class="form-control form-control-sm form-control-file">
                                            </div>
                                            <div class="text-center">
                                                <button type="button" id="buttonSendFiles" class="btn btn-sm btn-primary">Pošalji</button>
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
            $('#buttonSendFiles').click(function() {
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
            })
        })
    </script>
@endsection


