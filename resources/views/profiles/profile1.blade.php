@extends('layouts.hyper-profile-client')

{{--@section('page-title')--}}
{{--    {{ $model->getValue('name') }}--}}
{{--@endsection--}}

@section('page-header')
    <div class="w-50 d-inline-block" style="height: 7vh">
        <div><span class="h4" style="position: relative; top:2vh; left: 1vh">{{ $model->getValue('name') }}</span></div>
        <div><span class="text-primary font-12" style="position: relative; top: 2vh; left: 1vh">{{ mb_strtoupper($model->getText('profile_state')) }}</span></div>
    </div>
@endsection

@section('application-data')
    <div class="card-header bg-dark text-light">
        {{ mb_strtoupper( __("Application Data"))}}
    </div>
    <div class="card-body overflow-auto p-0" style="height: 80%">
        @include('profiles.partials._show_profile_data')
    </div>
@endsection

@section('status')
    <div class="card overflow-auto p-0" >
        <div class="card-body p-0 mb-auto">
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
                @include($program->getWorkflow()->getPhase($programStatus)->getClientDisplayForm())
            @elseif($status == 4)
                <div class="card border" style="height: 70%">
                    <div class="card-header bg-dark text-light">
                        {{ mb_strtoupper( __("In Program"))}}
                    </div>
                    <div class="card-body overflow-auto p-2" style="height: 80%">
                        @php
                            $contract = $model->getActiveProgram()->getWorkflow()->getPhases()->last();
                            $attributesData = $contract->getAttributesData();
                            $appform = $contract->getDisplayForm()
                        @endphp

                        @include($appform, $attributesData)
                    </div>
                </div>
            @elseif($status == 5)
                <div class="card h-100 w-100 m-0">
                    <div class="card-body">
                        <h3 class="font-weight-light">{{ mb_strtoupper(__('Application Rejected')) }}</h3>
                        <hr>
                        <p>
                            Vaša je prijava na program
                            <span class="attribute-label font-weight-bold">{{ strtoupper($model->getActiveProgram()->getAttribute('program_name')->getValue()) }}</span>
                            je nažalost odbijena.
                        </p>
                        <p>Za sva eventualna pitanja možete nas kontaktirati na <a href="mailto://info@ntpark.rs" target="_blank">info@ntpark.rs</a>.</p>
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


