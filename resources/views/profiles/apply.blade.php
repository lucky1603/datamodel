@extends('layouts.hyper-vertical-profile-shortdata')

@section('profile-content')
    <div class="card" style="height: 95%">
        <div class="card-header bg-dark text-light">
            <h2 class="text-center">Prijava na <span class="attribute-label">{{ $programName }}</span></h2>
        </div>
        <div class="card-body">
            <form class="h-100" id="myForm" method="post" enctype="multipart/form-data" action="{{ route('profiles.saveapplicationdata') }}">
                @csrf
                <input type="hidden" id="programType" name="programType" value="{{ $programType }}">
                <input type="hidden" id="profile_id" name="profile_id" value="{{ $model->getId() }}">

                <div class="row overflow-auto" style="height: 85%">
                    <div class="col-lg-12">
                        @if(isset($instance_id))
                            <input type="hidden" id="instance_id" name="instance_id" value="{{ $instance_id }}">
                        @endif
                        @switch($programType)
                            @case(\App\Business\Program::$INKUBACIJA_BITF)
                                @include('profiles.partials._ibitf')
                                @break
                            @case(\App\Business\Program::$RASTUCE_KOMPANIJE)
                                @break
                            @case(\App\Business\Program::$RAISING_STARTS)
                                @include('profiles.partials._rstarts')
                                @break
                        @endswitch
                    </div>
                </div>
                <div class="row" style="height: 15%">
                    <div class="col-lg-12">
                        <div class="text-center mt-4">
                            <button type="submit" id="save" class="btn btn-primary m-1" >
                                {{ __('Save') }}
                            </button>
                            <button type="button" id="send" class="btn btn-success m-1">
                                <span id="button_spinner" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                                <span id="button_text">{{ __('Send') }}</span>
                            </button>
                            <button id="cancel" type="button" class="btn btn-light m-1">{{ __('Cancel') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            const appType = $('#app_type').val();
            if(appType == 1) {
                $('#rstart_id_number_group').hide();
                $('#rstarts_basic_registered_activity_group').hide();
            } else {
                $('#rstart_id_number_group').show();
                $('#rstarts_basic_registered_activity_group').show();
            }

            $('#app_type').change(function() {
                const appType = $('#app_type').val();
                if(appType == 1) {
                    $('#rstart_id_number_group').hide();
                    $('#rstarts_basic_registered_activity_group').hide();
                } else {
                    $('#rstart_id_number_group').show();
                    $('#rstarts_basic_registered_activity_group').show();
                }
            });

            let dev_phase_business = $('#rstarts_dev_phase_bussines').val();
            console.log(dev_phase_business);
            if(dev_phase_business < 7) {
                $('#income-6').hide();
            } else {
                $('#income-6').show();
            }

            $('#rstarts_dev_phase_bussines').on('change', function() {
                console.log('changed');
                if($(this).val() < 7) {
                    $('#income-6').hide();
                } else {
                    $('#income-6').show();
                }
            });

            $('#btnAddMember').click(function() {
                let cloned = $('tbody#membersBody tr:first-child').clone();
                cloned.find('textarea').val('');
                cloned.appendTo('tbody#membersBody');
            });

            $('#btnAddFounder').click(function() {
                let cloned = $('tbody#foundersBody tr:first-child').clone();
                cloned.find('input').val('');
                cloned.appendTo('tbody#foundersBody');
            });

            $('#send').on('click', function() {
                $('#button_spinner').attr('hidden', false);
                var profileId = <?php echo $model->getId(); ?>;

                var result = 0;
                $.get('/profiles/check/' + profileId, function(data) {
                    var result = JSON.parse(data);
                    console.log(result);
                    $('#button_spinner').attr('hidden', true);

                    if(result.code == 0) {
                        $.toast(result.message);

                    } else {
                        $.toast({
                            text : result.message,
                            afterHidden : function() {
                                location.reload();
                            }
                        });
                    }

                });

            });

            $('input[type="file"]').change(function(evt) {
                let hasBig = false;
                for(let f of $(this)[0].files) {
                    if(f.size > 1024 * 1024) {
                        alert("Velicina datoteke ne moze biti veca od 1MB");
                        hasBig = true;
                        break;
                    }
                }

                if(hasBig) {
                    $(this).wrap("<form>").closest("form").get(0).reset();
                    $(this).unwrap();
                }
            })

        })

    </script>
@endsection
