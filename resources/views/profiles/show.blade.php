@extends('layouts.hyper-profile-admin')

@section('application-data')
    <div class="card shadow " style="height: 100%;overflow: auto">

        @if(in_array($model->getAttribute('profile_status')->getValue(), [1,2]))
            <div class="row h-100" style="display: flex; flex-direction: column; justify-content: center">
                <img class="ml-auto mr-auto" src="/images/custom/waitingicon.png" width="200px"/>
                <h4 class="text-center">{{ __('Waiting for the client to choose the program') }}</h4>
            </div>

        @elseif($model->getAttribute('profile_status')->getValue() == 3)
            <div class="row h-100" style="display: flex; flex-direction: column; justify-content: center">
                <img class="ml-auto mr-auto" src="/images/custom/waitingicon.png" width="200px"/>
                <h4 class="text-center">{{ __('Waiting for the client to complete the form') }}</h4>
            </div>
        @elseif($model->getAttribute('profile_status')->getValue() == 4)
            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                @if($model->getActiveProgram()->getPreselection() != null)
                <li class="nav-item">
                    <a href="#preselection" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                        <i class="mdi mdi-face-agent d-md-none d-block"></i>
                        <span class="d-none d-md-block">{{ strtoupper(__('Preselection')) }}</span>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="#appform" data-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                        <i class="mdi mdi-face-agent d-md-none d-block"></i>
                        <span class="d-none d-md-block">{{ strtoupper( __('Application Form')) }}</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content overflow-auto " style="height: 90%!important;">
                @if($model->getActiveProgram()->getPreselection() != null)
                <div class="tab-pane show active h-100 overflow-auto"  id="preselection">
                    @include('profiles.forms._preselection-form',
                                [
                                    'attributes' => $model->getActiveProgram()->getPreselection()->getAttributes(),
                                    'id' => $model->getActiveProgram()->getPreselection()->getId(),
                                    'status' => $model->getAttribute('profile_status')->getValue()
                                ])
                </div>
                @endif
                <div class="tab-pane overflow-auto h-100"  id="appform">
                    @include('profiles.partials._show_profile_data')
                </div>
            </div>
        @elseif($model->getAttribute('profile_status')->getValue() == 5)
            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                <li class="nav-item">
                    <a href="#selection" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                        <i class="mdi mdi-face-agent d-md-none d-block"></i>
                        <span class="d-none d-md-block">{{ strtoupper(__('Selection')) }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#preselection" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                        <i class="mdi mdi-face-agent d-md-none d-block"></i>
                        <span class="d-none d-md-block">{{ strtoupper(__('Preselection')) }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#appform" data-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                        <i class="mdi mdi-face-agent d-md-none d-block"></i>
                        <span class="d-none d-md-block">{{ strtoupper( __('Application Form')) }}</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content overflow-auto" style="height: 90%!important;">
                <div class="tab-pane show active h-100 overflow-auto" id="selection">
                    @include('profiles.forms._selection-form', [
                        'attributes' => $model->getActiveProgram()->getSelection()->getAttributes(),
                        'id' => $model->getActiveProgram()->getSelection()->getId(),
                        'status' => $model->getAttribute('profile_status')->getValue()
                    ])
                </div>
                <div class="tab-pane h-100 overflow-auto"  id="preselection">
                    @include('profiles.forms._preselection-form',
                                [
                                    'attributes' => $model->getActiveProgram()->getPreselection()->getAttributes(),
                                    'id' => $model->getActiveProgram()->getPreselection()->getId(),
                                    'status' => $model->getAttribute('profile_status')->getValue()
                                ])
                </div>
                <div class="tab-pane overflow-auto h-100"  id="appform">
                    @include('profiles.partials._show_profile_data')
                </div>
            </div>
        @elseif(in_array($model->getValue('profile_status'), [6,7]))
            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                <li class="nav-item">
                    <a href="#contract" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                        <i class="mdi mdi-face-agent d-md-none d-block"></i>
                        <span class="d-none d-md-block">{{ strtoupper(__('Contract')) }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#selection" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                        <i class="mdi mdi-face-agent d-md-none d-block"></i>
                        <span class="d-none d-md-block">{{ strtoupper(__('Selection')) }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#preselection" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                        <i class="mdi mdi-face-agent d-md-none d-block"></i>
                        <span class="d-none d-md-block">{{ strtoupper(__('Preselection')) }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#appform" data-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                        <i class="mdi mdi-face-agent d-md-none d-block"></i>
                        <span class="d-none d-md-block">{{ strtoupper( __('Application Form')) }}</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content overflow-auto" style="height: 90%!important;">
                <div class="tab-pane h-100 overflow-auto show active" id="contract">
                    @include('profiles.forms._contract-form', [
                        'attributes' => $model->getActiveProgram()->getContract()->getAttributes(),
                        'id' => $model->getActiveProgram()->getContract()->getId(),
                        'status' => $model->getAttribute('profile_status')->getValue()
                    ])
                </div>
                <div class="tab-pane h-100 overflow-auto" id="selection">
                    @include('profiles.forms._selection-form', [
                        'attributes' => $model->getActiveProgram()->getSelection()->getAttributes(),
                        'id' => $model->getActiveProgram()->getSelection()->getId(),
                        'status' => $model->getAttribute('profile_status')->getValue()
                    ])
                </div>
                <div class="tab-pane h-100 overflow-auto"  id="preselection">
                    @include('profiles.forms._preselection-form',
                                [
                                    'attributes' => $model->getActiveProgram()->getPreselection()->getAttributes(),
                                    'id' => $model->getActiveProgram()->getPreselection()->getId(),
                                    'status' => $model->getAttribute('profile_status')->getValue()
                                ])
                </div>
                <div class="tab-pane overflow-auto h-100"  id="appform">
                    @include('profiles.partials._show_profile_data')
                </div>
            </div>
        @elseif($model->getAttribute('profile_status')->getValue() == 8)
            @php
                $selection = $model->getActiveProgram()->getSelection();
                $preselection = $model->getActiveProgram()->getPreselection();
            @endphp
            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                @if($selection != null)
                    <li class="nav-item">
                        <a href="#selection" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                            <i class="mdi mdi-face-agent d-md-none d-block"></i>
                            <span class="d-none d-md-block">{{ strtoupper(__('Selection')) }}</span>
                        </a>
                    </li>
                @endif
                @if($preselection != null)
                    <li class="nav-item">
                        <a href="#preselection" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 @if($selection == null) active @endif">
                            <i class="mdi mdi-face-agent d-md-none d-block"></i>
                            <span class="d-none d-md-block">{{ strtoupper(__('Preselection')) }}</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="#appform" data-toggle="tab" aria-expanded="true" class="nav-link rounded-0 @if($selection == null && $preselection == null) active @endif">
                        <i class="mdi mdi-face-agent d-md-none d-block"></i>
                        <span class="d-none d-md-block">{{ strtoupper( __('Application Form')) }}</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content overflow-auto" style="height: 90%!important;">
                @if($selection != null)
                    <div class="tab-pane show active" id="selection">
                        @include('profiles.forms._selection-form', [
                            'attributes' => $model->getActiveProgram()->getSelection()->getAttributes(),
                            'id' => $model->getActiveProgram()->getSelection()->getId(),
                            'status' => $model->getAttribute('profile_status')->getValue()
                        ])
                    </div>
                @endif
                @if($preselection != null)
                    <div class="tab-pane @if($selection == null) show active @endif"  id="preselection">
                        @include('profiles.forms._preselection-form',
                                    [
                                        'attributes' => $preselection->getAttributes(),
                                        'id' => $preselection->getId(),
                                        'status' => $model->getAttribute('profile_status')->getValue()
                                    ])
                    </div>
                @endif
                <div class="tab-pane overflow-auto h-100 pl-3 pr-3"  id="appform">
                    @include('profiles.partials._show_profile_data')
                </div>
            </div>
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


            $('#btnSendMail').on('click', function(evt) {
                var profileId = <?php echo $model->getId();?>;

                $.get('/profiles/testMail/' + profileId, function(data) {
                    alert('Mail je poslat!');
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

            $('#btnPreselectionPassed').click(function(evt) {
                $('#button_spinner_ok').attr('hidden', false);
                var id = <?php echo $model->getId() ?>;
                var obj = {
                    profile : id,
                    passed : true,
                };

                var token = $('form#myForm input[name="_token"]').val();


                $.ajax({
                    url : '/profiles/evalPreselection',
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
                    url : '/profiles/evalSelection',
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

            $('#btnContractSigned').click(function(evt) {
                $('#button_spinner_contract_ok').attr('hidden', false);
                var id = <?php echo $model->getId() ?>;
                var obj = {
                    profile : id,
                    passed : true,
                };

                var token = $('form#myFormContract input[name="_token"]').val();

                $.ajax({
                    url : '/profiles/evalContract',
                    data: obj,
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token' : token
                    },
                    success: function(data) {
                        $('#button_spinner_contract_ok').attr('hidden', true);
                        console.log(data);
                        var result = JSON.parse(data);

                        console.log(result);
                        if(result.code != 0) {
                            console.log(result.message);
                            $.toast(result.message);
                        } else {
                            $.toast({
                                text: result.message,
                                afterHidden: function() {
                                    location.reload();
                                }
                            });
                        }
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
                    url : '/profiles/evalPreselection',
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
                    url : '/profiles/evalSelection',
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

