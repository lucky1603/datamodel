@extends('layouts.hyper-profile-admin')

@section('application-data')
    <div class="card shadow " style="height: 100%;overflow: auto">
        @if(in_array($model->getAttribute('profile_status')->getValue(), [1,2]))
            <div class="row h-100" style="display: flex; flex-direction: column; justify-content: center">
                <img class="ml-auto mr-auto" src="/images/custom/waitingicon.png" width="200px"/>
                <h4 class="text-center">{{ __('Waiting for the client to choose the program') }}</h4>
            </div>

        @elseif( in_array($model->getAttribute('profile_status')->getValue(), [3,4,5]))
            @php
                $status = $model->getActiveProgram()->getStatus();
            @endphp

            @if($status == 1)
                <div class="row h-100" style="display: flex; flex-direction: column; justify-content: center">
                    <img class="ml-auto mr-auto" src="/images/custom/waitingicon.png" width="200px"/>
                    <h4 class="text-center">{{ __('Waiting for the client to complete the form') }}</h4>
                </div>
            @else
                @php
                    $program = $model->getActiveProgram();
                    $workflow = $program->workflow;

                @endphp

                <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                    @for($i = 1; $i <= $status; $i++)

                        @php
                            $phase = $workflow->getPhase($i);
                        @endphp

                        @if($i < $status && !$phase->isVisibleInHistory())
                            @continue
                        @endif

                        <li class="nav-item">
                            <a href="{{ $phase->getDisplayId() }}" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 @if($i == $status) active @endif">
                                <i class="mdi mdi-face-agent d-md-none d-block"></i>
                                <span class="d-none d-md-block">{{ $phase->getDisplayName() }}</span>
                            </a>
                        </li>
                    @endfor
                </ul>

                <div class="tab-content overflow-auto " style="height: 90%!important;">
                    @for($i = 1; $i <= $status; $i++)
                        @php
                            $phase = $workflow->getPhase($i);
                            $attributesData = $phase->getAttributesData();
                            $attributesData['status'] = $status;
                            if($model->getValue('profile_status') > 3)
                                $attributesData['validStatus'] = 0;
                            else
                                $attributesData['validStatus'] = $i;
                        @endphp

                        @if($i < $status && !$phase->isVisibleInHistory())
                            @continue
                        @endif

                        <div class="tab-pane @if($i == $status) show active @endif h-100 overflow-auto"  id="{{ ltrim($phase->getDisplayId(), '#') }}">
                            @include($phase->getDisplayForm(), $attributesData)
                        </div>
                    @endfor
                </div>
            @endif
        @endif
    </div>
@endsection

@section('activities')
    <div class="card shadow" style="height: 98%;">
        <div class="card-header bg-primary text-light font-weight-bold" style="height: 40px">
            {{ mb_strtoupper( __('Activities'))}}
        </div>
        <div class="card-body" style="height: 90%; overflow: auto">
            <div class="timeline-alt pb-0" >
                @foreach($model->getSituations()->sortDesc() as $situation)
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
            $('.side-nav-item').each(function(index) {
                if($(this).attr('id') == 'navProfile' && !$(this).hasClass('mm_active')) {
                    $(this).addClass('mm_active');
                } else if($(this).attr('id') != 'navProfile' && $(this).hasClass('mm_active')) {
                    $(this).removeClass('mm_active');
                }
            });

            $('#btnNext').click(function() {
                const id = <?php echo $model->getId() ?>;
                $('#button_spinner_ok').attr('hidden', false);
                let some = $($('form#myForm')[0]).serialize();

                const token = $('form#myForm input[name="_token"]').val();

                $.ajax({
                    url: '/profiles/evalPhase',
                    data: some,
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token' : token
                    },
                    success: function(data) {
                        console.log(data);
                        // location.reload();
                    },
                    error: function(data) {
                        console.log(data);
                    }

                });
            });

            $('#btnEvalDecision').click(function() {
                $('#button_spinner_ok').attr('hidden', false);
                let some = $($('form#myAppEvalForm')[0]).serialize();
                const token = $('form#myAppEvalForm input[name="_token"]').val();

                $.ajax({
                    url: '/profiles/evalPhase',
                    data: some,
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token' : token
                    },
                    success: function(data) {
                        console.log(data);
                        $('#button_spinner_ok').attr('hidden', true);
                        location.reload();
                    },
                    error: function(data) {
                        console.log(data);
                        $('#button_spinner_ok').attr('hidden', true);
                    }

                });
            });

            $('#btnFaza1Passed').click(function() {
                $('#button_spinner_ok').attr('hidden', false);
                let formData = new FormData($('form#myFaza1Form')[0]);
                const token = $('form#myFaza1Form input[name="_token"]').val();
                $.ajax({
                    url: '/profiles/evalPhase',
                    data: formData,
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-Token' : token,
                    },
                    success: function(data) {
                        console.log(data);
                        $('#button_spinner_ok').attr('hidden', true);
                        location.reload();
                    },
                    error: function(data) {
                        console.log(data);
                        $('#button_spinner_ok').attr('hidden', true);
                    }
                });
            });

            $('#btnSendMail').on('click', function(evt) {
                var profileId = <?php echo $model->getId();?>;

                $.get('/profiles/testMail/' + profileId, function(data) {
                    alert('Mail je poslat!');
                });

            });

            $('#btnSaveDecision').click(function() {
                let id = $('#id').val();
                let data = $('form#myAppEvalForm').serialize();
                $.post('/appeval/update/' + id, data, function(data, status, xhr) {
                    console.log(data);
                    location.reload();
                });
            });

            $('#btnSavePreselection').on('click', function(evt) {
                var id = $('#id').val();
                var data = $('form#myForm').serialize();
                $.post('/preselection/update/' + id, data, function(data, status, xhr) {
                    location.reload();
                });
            });

            $('#btnSaveSelection').click(function(evt) {
                var id = $('#selectionId').val();
                var data = $('form#myFormSelection').serialize();
                $.post('/selection/update/' + id, data, function(data, status, xhr) {
                    location.reload();
                });
            });

            $('#btnSaveFaza1').click(function() {
                let formData = new FormData($('form#myFaza1Form')[0]);
                const token = $('form#myFaza1Form input[name="_token"]').val();

                $.ajax({
                    url: `/faza1/update`,
                    data: formData,
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-Token': token
                    },
                    success: function(data) {
                        console.log(data);
                        location.reload();
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });

            $('#btnSaveDemoDay').click(function(evt) {
                $('#save-demo-day-spinner').attr('hidden', false);
                let formData = new FormData($('form#myDemoDayForm')[0]);
                const token = $('form#myDemoDayForm input[name="_token"]').val();
                $.ajax({
                    url: '/demoday/update',
                    data: formData,
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-Token': token,
                    },
                    success: function(data) {
                        console.log(data);
                        $('#save-demo-day-spinner').attr('hidden', true);

                    },
                    error: function(data) {
                        console.log(data);
                        $('#save-demo-day-spinner').attr('hidden', true);
                    }
                });

            });

            $('#btnSaveContract').click(function(evt) {
                var id = $('#contractId').val();
                var formData = new FormData($('form#myFormContract')[0]);

                $.ajax({
                    type: "POST",
                    url: '/contracts/update/' + id,
                    async: true,
                    data: formData,
                    contentType: false, //this is required please see answers above
                    processData: false, //this is required please see answers above
                    cache: false, //not sure but works for me without this
                    error   : function (error) {
                        console.log(error);
                    },
                    success : function (data) {
                        console.log(data);
                        location.reload();
                    }
                });

            });

            $('#btnNotifyClientPreselection').click(function(evt) {
                alert('notify client');
            });

            $('#btnNotifyClientSelection').click(function(evt) {
                alert('notify client');
            });

            $('#btnNotifyClientContract').click(function() {
                var id = <?php echo $model->getId() ?>;
                var obj = {
                    profile : id,
                    passed : true,
                };

                var token = $('form#myFormContract input[name="_token"]').val();

                $.ajax({
                    url: '/profiles/notifyContract',
                    data: obj,
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token' : token
                    },
                    success: function(data) {
                        alert('email sent');
                        location.reload();
                    },
                    error: function(data) {
                        alert('email not sent');
                    }

                });
            });

            $('#btnDemoDayPassed').click(function() {
                $('#button_spinner_ok').attr('hidden', false);
                let formData = new FormData($('form#myDemoDayForm')[0]);
                const token = $('form#myDemoDayForm input[name="_token"]').val();

                $.ajax({
                    url: '/profiles/evalPhase',
                    data: formData,
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-Token' : token
                    },
                    success: function(data) {
                        console.log(data);
                        $('#button_spinner_ok').attr('hidden', true);
                        location.reload();
                    },
                    error: function(data) {
                        console.log(data);
                        $('#button_spinner_ok').attr('hidden', true);
                        location.reload();
                    }
                });
            });

            $('#btnPreselectionPassed').click(function(evt) {
                $('#button_spinner_ok').attr('hidden', false);
                var id = <?php echo $model->getId() ?>;
                var obj = {
                    profile : id,
                    passed : true,
                };

                var token = $('form#myForm input[name="_token"]').val();


                $.ajax({
                    url : '/profiles/evalPhase',
                    data: obj,
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token' : token
                    },
                    success: function(data) {
                        $('#button_spinner_ok').attr('hidden', true);
                        console.log(data);
                        location.reload();
                    },
                    error: function(data) {
                        $('#button_spinner_ok').attr('hidden', true);
                        console.log(data);
                    }
                });

            });

            $('#btnSelectionPassed').click(function(evt) {
                $('#button_spinner_sel_ok').attr('hidden', false);
                var id = <?php echo $model->getId() ?>;
                var obj = {
                    profile : id,
                    passed : true,
                };

                var token = $('form#myFormSelection input[name="_token"]').val();

                $.ajax({
                    url : '/profiles/evalPhase',
                    data: obj,
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token' : token
                    },
                    success: function(data) {
                        $('#button_spinner_sel_ok').attr('hidden', true);
                        console.log(data);
                        location.reload();
                    },
                    error: function(data) {
                        $('#button_spinner_sel_ok').attr('hidden', true);
                        console.log(data);
                    }
                });

            });

            $('#btnCS').click(function(evt) {
                $('#button_spinner_contract_ok').attr('hidden', false);
                let formData = new FormData($('form#myFormContract')[0]);
                var token = $('form#myFormContract input[name="_token"]').val();

                $.ajax({
                    url : '/profiles/evalPhase',
                    data: formData,
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token' : token
                    },
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $('#button_spinner_contract_ok').attr('hidden', true);
                        console.log(data);
                        location.reload();
                        // var result = JSON.parse(data);
                        //
                        // console.log(result);
                        // if(result.code != 0) {
                        //     console.log(result.message);
                        //     $.toast(result.message);
                        // } else {
                        //     $.toast({
                        //         text: result.message,
                        //         afterHidden: function() {
                        //             location.reload();
                        //         }
                        //     });
                        // }
                    },
                    error: function(data) {
                        $('#button_spinner_contract_ok').attr('hidden', true);
                        console.log(data);
                    }
                });

            });

            $('#btnPreselectionFailed').click(function(evt) {
                $('#button_spinner_cancel').attr('hidden', false);
                var id = <?php echo $model->getId() ?>;
                var obj = {
                    profile : id,
                    passed : false,
                };

                var token = $('form#myForm input[name="_token"]').val();

                $.ajax({
                    url : '/profiles/evalPhase',
                    data: obj,
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token' : token
                    },
                    success: function(data) {
                        $('#button_spinner_cancel').attr('hidden', true);
                        console.log(data);
                        location.reload();
                    },
                    error: function(data) {
                        $('#button_spinner_cancel').attr('hidden', true);
                        console.log(data);
                    }
                });
            });

            $('#btnSelectionFailed').click(function (evt) {
                $('#button_spinner_sel_cancel').attr('hidden', false);
                var id = <?php echo $model->getId() ?>;
                var obj = {
                    profile : id,
                    passed : false,
                };

                var token = $('form#myFormSelection input[name="_token"]').val();

                $.ajax({
                    url : '/profiles/evalPhase',
                    data: obj,
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token' : token
                    },
                    success: function(data) {
                        $('#button_spinner_sel_cancel').attr('hidden', true);
                        console.log(data);
                        location.reload();
                    },
                    error: function(data) {
                        $('#button_spinner_sel_cancel').attr('hidden', true);
                        console.log(data);
                    }
                });
            });

        });
    </script>
@endsection

