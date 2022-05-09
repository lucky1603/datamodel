@extends('layouts.hyper-profile-client')

@php
    $profile = $program->getProfile();
    $status = $program->getStatus();
@endphp

@section('page-header')
    <div class="w-50 d-inline-block" style="height: 7vh">
        <div><span class="h4" style="position: relative; top:2vh; left: 1vh">{{ $profile->getValue('name') }}</span></div>
        <div><span class="text-primary font-12" style="position: relative; top: 2vh; left: 1vh">{{ mb_strtoupper($program->getStatusText()) }}</span></div>
    </div>
@endsection

@section('application-data')
    <div class="card-header bg-dark text-light">
        {{ mb_strtoupper( __("Application Data"))}}
    </div>
    <div class="card-body overflow-auto p-0" style="height: 80%">
        @if($program != null)
            @include('profiles.partials._show_profile_data')
        @endif
    </div>
@endsection

@section('status')
    @if($status > 1)
        @include($program->getWorkflow()->getPhase($status)->getClientDisplayForm())
    @elseif($status == -1)
        <div class="card border" style="height: 70%">
            <div class="card-header bg-dark text-light">
                {{ mb_strtoupper( __("In Program"))}}
            </div>
            <div class="card-body overflow-auto p-2" style="height: 80%">
                @php
                    $contract = $program->getWorkflow()->getPhases()->last();
                    $attributesData = $contract->getAttributesData();
                    $appform = $contract->getDisplayForm()
                @endphp

                @include($appform, $attributesData)
            </div>
        </div>
    @endif
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