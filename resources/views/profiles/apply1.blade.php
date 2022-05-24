@extends('layouts.hyper-vertical-profile-shortdata')

@section('profile-content')
    <div class="card" style="height: 98%">
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
                            <button type="button" id="save" class="btn btn-primary m-1" >
                                <span id="button_save_spinner" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                                <span id="button_save_text">{{ __('Save') }}</span>
                            </button>

                            <button type="button" id="send" class="btn btn-success m-1">
                                <span id="button_spinner" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                                <span id="button_text">{{ __('Send') }}</span>
                            </button>

                            <button id="cancel" type="button" class="btn btn-light m-1">{{ __('Cancel') }}</button>
                            <button id="help" type="button" class="btn btn-dark m-1">{{ __('Help') }}<i class="dripicons-question font-16 ml-1"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-light">
                        <h5 class="modal-title" id="exampleModalLabel">Informacije</h5>
                        <button type="button" id="crossClose" class="close bg-dark text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h3>GENERALNO</h3>
                        <p class="text-dark">
                            Molimo, pročitajte ove informacije kako biste što lakše poslali prijavu.
                        </p>
                        <h3>VALIDNOST PODATAKA</h3>
                        <p class="text-dark">
                            Popunite prazna polja pre slanja prijave. Polja označena zvezdicom u obavezna i bez njih
                            je prijava nevalidna, o čemu ćete svaki puta biti obavešteni prilikom pokušaja da pošaljete
                            nepotpune podatke.
                        </p>
                        <h3>ČUVANJE PODATAKA</h3>
                        <p class="text-dark">
                            Moguće je nebrojeno puta sačuvati podatke koje ste dosad uneli pritiskom na dugme "Sačuvaj".
                            Takođe je neophodno da svi podaci budu sačuvani pre nego što pokušate da pošaljete prijavu.
                            Prilikom slanja prijave, ukoliko postoje podaci koji nisu prethodno sačuvani, dobićete upozorenje i
                            nećete biti u mogućnosti da pošaljete formu pre nego što sačuvate podatke ili otkažete promene izborom
                            dugmeta "Otkaži", koje će vas vratiti na prethodno sačuvano stanje.
                        </p>
                        <h3>SLANJE PRIJAVE</h3>
                        <p class="text-dark">
                            Ukoliko mislite da ste uneli sve neophodne podatke pritisnite dugme "Pošalji". Ukoliko su podaci u redu,
                            dobićete potvrdu da je prijava uspešna. Ukoliko vam nedostaje još neki podatak, dobićete obaveštenje o prvom
                            parametru u nizu parametara koji nedostaju.
                        </p>
                        <h3>POMOĆ</h3>
                        <p class="text-dark">
                            Ovaj dijalog ćete moći ponovo da vidite izborom tastera "Pomoć".
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancelButton" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="okButton" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(async function() {

            let dirty = false;
            let warned = false;
            let result = 0;

            await axios.get('/user/getsessionvalue/warned')
                .then(response => {
                    console.log(`Warned is ${response.data}`);
                    if(response.data != -11) {
                        warned = true;
                    }
                    result = response.data;
                })

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

            $('input[type="text"]').keypress(function() {
                dirty = true;
            });

            $('input[type="file"]').change(function() {
                dirty = true;
            });

            $('input[type="date"]').change(function() {
                dirty = true;
            });

            $('input[type="checkbox"]').change(function() {
                dirty = true;
            });

            $('select').change(function() {
                dirty = true;
            });

            $('textarea').keypress(function() {
                dirty = true;

            });

            $('form#myForm').on('submit', function() {
                dirty = false;
            });

            $('#cancel').click(function() {
                $('form#myForm').trigger('reset');
                // $('#send').removeAttr('disabled');
                // $('#send').unwrap();
                dirty = false;
            });

            if(warned != true) {
                $('.modal-footer').hide();
                $('#exampleModal').modal();

                $('#exampleModal').on('hide.bs.modal', function () {
                    let formData = new FormData();
                    formData.append('warned', 'true');
                    axios.post('/user/setsessionvalues', formData)
                        .then(response => {
                            console.log(response.data);
                            if(response.data == 0) {
                                console.log("Session data successfully set!");
                            }
                        }).catch(error => {
                        console.log(error);
                    });
                });
            }

            $('#help').click(function() {
                $('.modal-footer').hide();
                $('#exampleModal').modal();
            });

            $('#save').click(function() {
                $('#button_save_spinner').attr('hidden', false);
                $('form#myForm').submit();
            });

            $('#send').on('click', function() {
                if(dirty === true) {
                    // alert('morate prvo sacuvati formu!');
                    let oldHtml = $('.modal-body').html();
                    $('.modal-body').html(`
                        <p class="text-dark">Da biste pokušali slanje, morate prvo sačuvati aktivne izmene pritiskom na dugme "Sačuvaj" ili
                           odustali od njih pritiskom na dugme "Odustani".
                        </p>
                    `);
                    $('.modal-footer').hide();

                    $('#exampleModal').modal();

                    $('#crossClose').click(function() {
                        $('.modal-body').html(oldHtml);
                        $('.modal-footer').show();
                    });

                    return;
                }

                $('#button_spinner').attr('hidden', false);
                var profile_id = <?php echo $model->getId(); ?>;

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
