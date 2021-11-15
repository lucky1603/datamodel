@extends('layouts.backbone')

@section('body-content')
    <div class="h-100 w-100 ">
        <div class="row bg-dark" >
            <div class="col-lg-4 h-100">
                <img src="/images/custom/ntplogo.png" class="ml-3 m-4" style="width: 90%"/>
            </div>

            <div class="col-lg-2 offset-lg-6 h-100" style="display: flex; align-items: center; justify-content: center">
                <img src="/images/custom/rstartslogo.png" class="m-4" style="height: 150px"/>
            </div>
        </div>
        <div class="row w-100" style="margin-left: 12px; margin-right: 12px">
            <div class="col-12 col-lg-8 offset-lg-2">
                @error('post_too_big') <div class="alert alert-danger">{{ $message }}</div>@enderror
                <div class="text-center mt-4 mb-4">
                    <h1 class="attribute-label">PRIJAVA</h1>
                </div>
                <div class="mt-4 font-14 attribute-label shadow p-4">
                    <p>Zdravo, budući Raising Starteri!</p>
                    <p>
                        Pred vama je prijavni formular za program Raising Starts. Program realizuje Naučno-tehnološki park Beograd
                        u partnerstvu sa Naučno-tehnološkim parkom Niš i Naučno-tehnološkim parkom Čačak. Prijavni formular je isti
                        za sve, potrebno je izabrati NTP prema regionu/području u kojem želite da se prijavite.
                    </p>
                    <p>
                        Molimo vas da pažljivo pročitate pitanja, popunite prijavu i budete što precizniji u odgovorima kako bi
                        prijava bila adekvatno ocenjena. Pre popunjavanja prijavnog obrasca obavezno pročitajte Javni poziv i
                        Raising Starts VODIČ. (dokumenta možete preuzeti na sajtu <a href="https://ntpark.rs/raising-starts/" target="_blank" class="font-weight-bold">programa</a> )
                    </p><p>
                        Prijave su otvorene od …. do …. u ponoć
                    </p>
                    <p>
                        Srećno!
                    </p>

                </div>

                <form id="myRaisingStartsForm" method="POST" enctype="multipart/form-data" action="{{ route('storeRaisingStarts') }}" class="mt-4 h-100 w-100">
                    @csrf
                    @include('profiles.partials._rstarts')

                    <div class="mt-4" style="display: flex">
                        <input
                            type="checkbox"
                            id="gdpr"
                            name="gdpr"
                            style="position: relative; top:4px"
                            class="@error('gdpr') is-invalid @enderror"
                            @if(old('gdpr') == 'on') checked @endif>
                        <label class="ml-1 attribute-label">
                            Popunjavanjem i podnošenjem ove prijave potvrdjujem da sam saglasan sa svim navedenim uslovima poziva.
                        </label>
                    </div>
                    @error('gdpr') <div class="alert alert-danger">{{ $message }}</div> @enderror

                    <div class="row mt-4">
                        <div class="col-md-4"></div>
                        <div class="form-group col-md-3">
                            <div class="captcha text-center">
                                <span>{!! captcha_img('ntp') !!}</span>
                                <button type="button" id="refresh" class="btn btn-sm btn-success text-light"><i class="mdi mdi-refresh font-18" id="refresh"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="form-group col-md-3">
                            <input id="captcha" type="text" class="form-control" placeholder="Unesite karaktere sa slike" name="captcha"></div>

                    </div>
                    @error('captcha') <div class="alert alert-danger text-center">{{ $message }}</div>@enderror

{{--                    <div class="row pt-4 mt-3" style="height: 5%">--}}
                        <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: center">

                            <button type="button" id="buttonSend" class="btn btn-sm btn-primary rounded-pill mr-2 mt-4" style="width: 250px" title="{{ __('gui.Application-SaveDataAndSendApp') }}">
                                <span id="okSpinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                {{ __('Save Data and Create Profile') }}
                            </button>

                            <button type="button" id="buttonCancel" class="btn btn-sm btn-outline-primary rounded-pill ml-2 mt-4" style="width: 250px" title="{{ __('gui.Application-ReturnToMain') }}">
                                <span id="cancelSpinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                {{ __('Return to Main Page') }}
                            </button>


                    </div>
                </form>
            </div>
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

            $('#okSpinner').hide();
            $('#cancelSpinner').hide();
            $('#buttonSend').click(function() {
                $('#okSpinner').show();


                try {
                    // $('#myRaisingStartsForm').submit();
                    document.getElementById('myRaisingStartsForm').submit();
                } catch (e) {
                    console.log(e.message);
                }

            });

            $('#buttonCancel').click(function() {
                $('#cancelSpinner').show();
                location.href = 'https://ntpark.rs/raising-starts/';
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

            $('#refresh').click(function(){
                $.ajax({
                    type:'GET',
                    url:'/refreshcaptcha',
                    success:function(data){
                        $(".captcha span").html(data.captcha);
                    }
                });
            });

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

        });
    </script>

@endsection
