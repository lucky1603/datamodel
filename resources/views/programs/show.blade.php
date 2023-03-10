@extends('layouts.hyper-profile-admin')

@php
    $profile = $program->getProfile();
@endphp

@section('page-header')
    <div class="w-50 d-inline-block" style="height: 7vh">
        <div><span class="h4" style="position: relative; top:2vh; left: 1vh">{{ $profile->getValue('name') }}</span></div>
        <div><span class="text-primary font-12" style="position: relative; top: 2vh; left: 1vh">{{ mb_strtoupper($program->getStatusText()) }}</span></div>
    </div>
@endsection

@section('application-data')
    <div class="card shadow " style="height: 100%;overflow: auto">
        @php
            $status = $program->getStatus();
            $workflow = $program->getWorkflow();
        @endphp

        @if($status > 0)
            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                @for($i = 1; $i <= $status; $i++)

                    @php
                        $phase = $workflow->getPhase($i);
                    @endphp

                    @if($i < $status && !$phase->isVisibleInHistory())
                        @continue
                    @endif

                    <li class="nav-item">
                        <a href="{{ $phase->getDisplayId() }}" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 @if($i == 1 /* $status */) active @endif">
                            <i class="mdi mdi-face-agent d-md-none d-block"></i>
                            <span class="d-none d-md-block">{{ $phase->getDisplayName() }}</span>
                        </a>
                    </li>
                @endfor
            </ul>

            <div class="tab-content overflow-auto h-100">
                @for($i = 1; $i <= $status; $i++)
                    @php
                        $phase = $workflow->getPhase($i);
                        $attributesData = $phase->getAttributesData();
                        $attributesData['status'] = $status;
                        $attributesData['validStatus'] = $i;
                    @endphp

                    @if($i < $status && !$phase->isVisibleInHistory())
                        @continue
                    @endif

                    <div class="tab-pane @if($i == 1 /* $status */) show active @endif h-100 overflow-auto "  id="{{ ltrim($phase->getDisplayId(), '#') }}">
                        @include($phase->getDisplayForm(), $attributesData)
                    </div>
                @endfor
            </div>
        @elseif($status == -1 || $status == -4)
            @php
                $phaseCount = $workflow->getPhases()->count();
            @endphp
            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                @for($i = 1; $i <= $phaseCount; $i++)

                    @php
                        $phase = $workflow->getPhase($i);
                    @endphp

                    @if(!$phase->isVisibleInHistory())
                        @continue
                    @endif

                    <li class="nav-item">
                        <a href="{{ $phase->getDisplayId() }}" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 @if($i == 1 /* $status */) active @endif">
                            <i class="mdi mdi-face-agent d-md-none d-block"></i>
                            <span class="d-none d-md-block">{{ $phase->getDisplayName() }}</span>
                        </a>
                    </li>
                @endfor
            </ul>
            <div class="tab-content overflow-auto h-100">
                @for($i = 1; $i <= $phaseCount; $i++)
                    @php
                        $phase = $workflow->getPhase($i);
                        $attributesData = $phase->getAttributesData();
                        $attributesData['status'] = $status;
                        $attributesData['validStatus'] = $i;
                    @endphp

                    @if(!$phase->isVisibleInHistory())
                        @continue
                    @endif

                    <div class="tab-pane @if($i == 1 /* $status */) show active @endif h-100 overflow-auto "  id="{{ ltrim($phase->getDisplayId(), '#') }}">
                        @include($phase->getDisplayForm(), $attributesData)
                    </div>
                @endfor
            </div>
        @elseif(in_array($status, [-2,-3,-5]))
            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                @php
                    $phase = $workflow->getPhase(1);
                @endphp
                <li class="nav-item">
                    <a href="{{ $phase->getDisplayId() }}" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                        <i class="mdi mdi-face-agent d-md-none d-block"></i>
                        <span class="d-none d-md-block">{{ $phase->getDisplayName() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#myStatus" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                        <i class="mdi mdi-face-agent d-md-none d-block"></i>
                        <span class="d-none d-md-block">STATUS</span>
                    </a>
                </li>

            </ul>
            <div class="tab-content overflow-auto h-100">
                @php
                    $phase = $workflow->getPhase(1);
                    $attributesData = $phase->getAttributesData();
                    $attributesData['status'] = $status;
                    $attributesData['validStatus'] = 1;
                @endphp

                <div class="tab-pane show active h-100 overflow-auto"  id="{{ ltrim($phase->getDisplayId(), '#') }}">
                    @include($phase->getDisplayForm(), $attributesData)
                </div>

                <div class="tab-pane h-100 overflow-auto" id="myStatus">
                    @switch($status)
                        @case(-2)
                            <h4 class="display-4 text-center">PRIJAVA ODBIJENA</h4>
                            <p class="mt-4 p-2">Na osnovu podataka popunjenih u prijavi za program, komisija je zaključila da kriterijum za nastavak prijave na program nije ispunjen.</p>
                            @break
                        @case(-5)
                            <h4 class="display-4 text-center">PRIJAVA NIJE POSLATA</h4>
                            <p class="mt-4 p-2">Aplikant nije poslao prijavu u predviđenom vremenskom roku.</p>
                            @break
                        @default
                            <h4 class="display-4">PREKID PROGRAMA</h4>
                            <p class="mt-4 p-2">Dalje izvršavanje programa je suspendovano.</p>
                    @endswitch
                </div>

            </div>
        @endif
    </div>

    @if ($program->getStatus() == 2)
        <div class="d-flex align-items-center justify-content-center">
            <button type="button" class="btn btn-small btn-success" id="buttonBackToForm" style="width: 150px">
                <span id="button_backstatus_spinner" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_backstatus_text">{{ __('Vrati status') }}</span>
            </button>
        </div>
    @endif

@endsection

@section('activities')
    <div class="card shadow" style="height: 98%;">
        <div class="card-header bg-primary text-light font-weight-bold" style="height: 40px">
            {{ mb_strtoupper( __('Activities'))}}
        </div>
        <div class="card-body" style="height: 90%; overflow: auto">
            <div class="timeline-alt pb-0" >
                @foreach($program->getSituations()->sortDesc() as $situation)
                    <div class="timeline-item">
                        @if($loop->first)
                            <i class="mdi mdi-circle bg-primary-lighten text-primary timeline-icon"></i>
                        @else
                            <i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
                        @endif
                        <div class="timeline-item-info pb-3">
                            <h5 class="mt-0 mb-1">{{ $situation->getData()['name'] }}</h5>
                            <p class="font-12 attribute-label font-weight-bold">{{ $situation->getAttribute('occurred_at')->getText() }}</p>
                            <p class="text-muted mt-2 mb-0 pb-3">
                                {{ $situation->getData()['description'] }}
                            </p>
                            @foreach($situation->getDisplayAttributes() as $attribute)
                                @if($attribute->name == 'description')
                                    @continue
                                @endif
                                <p class="font-11 mt-0 @if($loop->last) mb-2 @else mb-0 @endif">
                                    <span class="attribute-label font-weight-semibold">{!! $attribute->label !!}:</span>
                                    @if($attribute->type == 'text')<br/>@endif
                                    @if($attribute->type != 'file')
                                        <span class="@if($attribute->type != 'text') ml-2 @endif text-muted">{!! $attribute->getText() !!}</span>
                                    @else
                                        <a href="{{ $attribute->getValue()['filelink'] }}" class="btn-link ml-2 font-weight-semibold">{!! $attribute->getValue()['filename'] !!} </a>
                                    @endif
                                </p>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            // Back status to form
            $('#buttonBackToForm').click(function() {
                $('#button_backstatus_spinner').attr('hidden', false);
                let data = new FormData();
                data.append('_token', "<?= csrf_token() ?>");
                data.append('program_id', "<?= $program->getId() ?>");
                axios.post('/programs/backToForm', data)
                .then(response => {
                    $('#button_backstatus_spinner').attr('hidden', true);
                    console.log(response.data);
                    location.reload();
                });
            });

            // A P P   E V A L U A T I O N
            $('#btnSaveDecision').click(function() {
                let id = $('#id').val();
                let data = $('form#myAppEvalForm').serialize();
                $.post('/appeval/update/' + id, data, function(data, status, xhr) {
                    console.log(data);
                    location.reload();
                });
            });

            $('#btnEvalDecision').click(function() {
                $('#button_spinner_ok').attr('hidden', false);
                let formData = new FormData($('form#myAppEvalForm')[0]);
                formData.append('passed', 'on');

                axios.post('/programs/evalPhase', formData)
                    .then(response => {
                        console.log(response.data);
                        $('#button_spinner_ok').attr('hidden', true);
                        location.reload();
                    })
                    .catch(error => {
                        console.log(error);
                        $('#button_spinner_ok').attr('hidden', true);
                    });

            });

            $('#btnRejectDecision').click(function() {
                $('#button_spinner_reject').attr('hidden', false);
                let formData = new FormData($('form#myAppEvalForm')[0]);
                formData.append('passed', 'rejected');
                axios.post('/programs/evalPhase', formData)
                    .then(response => {
                        console.log(response.data);
                        $('#button_spinner_reject').attr('hidden', true);
                        location.reload();
                    });
            });

            // P R E S E L E C T I O N
            $('#btnSavePreselection').on('click', function(evt) {
                $('#button_spinner_save_preselection').attr('hidden', false);
                var id = $('#id').val();
                var data = $('form#myForm').serialize();
                $.post('/preselection/update/' + id, data, function(data, status, xhr) {
                    $('#button_spinner_save_preselection').attr('hidden', true);
                    location.reload();
                });
            });

            $('#btnPreselectionPassed').click(function(evt) {
                $('#button_spinner_ok').attr('hidden', false);
                let formData = new FormData($('form#myForm')[0]);
                formData.append('passed', 'on');

                axios.post('/programs/evalPhase', formData)
                    .then(response => {
                        console.log(response.data);
                        $('#button_spinner_ok').attr('hidden', true);
                        location.reload();
                    })
                    .catch(error => {
                        console.log(error);
                        $('#button_spinner_ok').attr('hidden', true);
                    });
            });

            $('#btnPreselectionFailed').click(function(evt) {
                $('#button_spinner_cancel').attr('hidden', false);
                let formData = new FormData($('form#myForm')[0]);
                formData.append('passed', 'off');

                axios.post('/programs/evalPhase', formData)
                    .then(response => {
                        console.log(response.data);
                        $('#button_spinner_cancel').attr('hidden', true);
                        location.reload();
                    })
                    .catch(error => {
                        console.log(error);
                        $('#button_spinner_cancel').attr('hidden', true);
                    });
            });

            // S E L E C T I O N
            $('#btnSaveSelection').click(function(evt) {
                $('#button_spinner_save_selection').attr('hidden', false);
                var id = $('#selectionId').val();
                var data = $('form#myFormSelection').serialize();
                $.post('/selection/update/' + id, data, function(data, status, xhr) {
                    $('#button_spinner_save_selection').attr('hidden', true);
                    location.reload();
                });
            });

            $('#btnSelectionPassed').click(function(evt) {
                $('#button_spinner_ok').attr('hidden', false);
                let formData = new FormData($('form#myFormSelection')[0]);
                formData.append('passed', 'on');

                axios.post('/programs/evalPhase', formData)
                    .then(response => {
                        $('#button_spinner_ok').attr('hidden', true);
                        console.log('Odgovor na validaciju selekcije ...');
                        console.log(response.data);
                        if(response.data.code != 0) {
                            alert(response.data["message"]);
                        } else {
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.log(error);
                        $('#button_spinner_ok').attr('hidden', true);
                    });
            });

            $('#btnSelectionFailed').click(function(evt) {
                $('#button_spinner_sel_failed').attr('hidden', false);
                let formData = new FormData($('form#myFormSelection')[0]);
                formData.append('passed', 'off');

                axios.post('/programs/evalPhase', formData)
                    .then(response => {
                        console.log(response.data);
                        $('#button_spinner_sel_failed').attr('hidden', true);
                        location.reload();
                    })
                    .catch(error => {
                        console.log(error);
                        $('#button_spinner_sel_failed').attr('hidden', true);
                    });
            });

            // F A Z A   1
            $('#btnSaveFaza1').click(function() {
                let formData = new FormData($('form#myFaza1Form')[0]);
                const token = $('form#myFaza1Form input[name="_token"]').val();
                formData.append('passed', 'on');

                axios.post('/faza1/update', formData)
                .then(response => {
                    console.log(response.data);
                    location.reload();
                })
                .catch(error => {
                    cnsole.log(error);
                })
            });

            $('#btnFaza1Passed').click(function() {
                $('#button_spinner_ok').attr('hidden', false);
                let formData = new FormData($('form#myFaza1Form')[0]);
                formData.append('passed', 'on');

                axios.post('/programs/evalPhase', formData)
                    .then(response => {
                        console.log(response.data);
                        $('#button_spinner_ok').attr('hidden', true);
                        location.reload();
                    });
            });

            $('#btnFaza1Rejected').click(function() {
                $('#button_spinner_reject').attr('hidden', false);
                let formData = new FormData($('form#myFaza1Form')[0]);
                formData.append('passed', 'off');

                axios.post('/programs/evalPhase', formData)
                    .then(response => {
                        console.log(response.data);
                        $('#button_spinner_reject').attr('hidden', true);
                        location.reload();
                    });
            });

            $('#btnFaza1Rollback').click(function() {
                $('#button_spinner_rollback').attr('hidden', false);
                // setTimeout(() => {
                //     $('#button_spinner_rollback').attr('hidden', true);
                // }, 2000);
                let formData = new FormData($('form#myFaza1Form')[0]);
                axios.post('/faza1/rollback', formData)
                    .then(response => {
                        console.log(response.data);
                        $('#button_spinner_rollback').attr('hidden', true);
                        location.reload();
                    });
            });


            // D E M O   D A Y
            $('#btnDemoDayPassed').click(function() {
                $('#button_spinner_demoday_ok').attr('hidden', false);
                let formData = new FormData($('form#myDemoDayForm')[0]);
                formData.append('passed' ,'on');
                // const token = $('form#myDemoDayForm input[name="_token"]').val();
                axios.post('/programs/evalPhase', formData)
                    .then(response => {
                        console.log(response.data);
                        $('#button_spinner_demoday_ok').attr('hidden', true);
                        location.reload();
                    });
            });

            $('#btnDemoDayRejected').click(function() {
                $('#button_spinner_demoday_reject').attr('hidden', false);
                let formData = new FormData($('form#myDemoDayForm')[0]);
                formData.append('passed' ,'off');
                // const token = $('form#myDemoDayForm input[name="_token"]').val();
                axios.post('/programs/evalPhase', formData)
                    .then(response => {
                        console.log(response.data);
                        $('#button_spinner_demoday_reject').attr('hidden', true);
                        location.reload();
                    });
            });

            // C O N T R A C T

            $('#btnSaveContract').click(function(evt) {
                const id = $('#contractId').val();
                let formData = new FormData($('form#myFormContract')[0]);

                axios.post('/contracts/update/' + id, formData)
                    .then(response => {
                        console.log(response.data);
                        // $('form#myFormContract').load(location.href + ' #myFormContract');
                        location.reload();
                    }).catch(error => {
                        console.log(error);
                    })

            });

            $('#btnCS').click(function(evt) {
                $('#button_spinner_contract_ok').attr('hidden', false);
                let formData = new FormData($('form#myFormContract')[0]);
                // var token = $('form#myFormContract input[name="_token"]').val();
                formData.append('passed', 'on');
                axios.post('/programs/evalPhase', formData)
                    .then(response => {
                        $('#button_spinner_contract_ok').attr('hidden', true);
                        console.log(response.data);
                        if(response.data.code === 0) location.reload();
                        else alert(response.data.message);
                    });

            });

            $('#btnCSReject').click(function(evt) {
                $('#button_spinner_contract_reject').attr('hidden', false);
                let formData = new FormData($('form#myFormContract')[0]);
                // var token = $('form#myFormContract input[name="_token"]').val();

                formData.append('passed', 'off');
                axios.post('/programs/evalPhase', formData)
                    .then(response => {
                        $('#button_spinner_contract_reject').attr('hidden', true);
                        console.log(response.data);
                        location.reload();
                    });

            });

            $('#iconDeleteContract').click(function() {
                const cid = $('#contractId').val();
                const token = $('form#myFormContract input[name="_token"]').val();
                if(confirm('Upravo ćete obrisati priloženi dokument. Da li ste sigurni?')) {
                    let data = new FormData();
                    data.append('contractId', cid);
                    data.append('_token', token);

                    axios.post('/contracts/deleteDocument', data)
                        .then(response => {
                            console.log(response.data);
                            location.reload();
                            // $('form#myFormContract').load(location.href + ' #myFormContract');

                        }).catch(error => {
                        console.log(error);
                    });
                }

            });

        });
    </script>
@endsection


