@extends('layouts.backbone')

@section('title')
    Raising Starts - Prijava
@endsection

@section('body-content')
    <div class="h-100 w-100 px-1">
        <div class="row bg-dark" >
            <div class="col-lg-4 h-100">
                <img src="/images/custom/ntplogo.png" class="ml-3 m-4" style="width: 90%"/>
            </div>

            <div class="col-lg-3 offset-lg-5 h-100" style="display: flex; align-items: center; justify-content: center">
                <img src="/images/custom/rstartslogo.png" class="m-4" style="height: 150px"/>
            </div>
        </div>
        <div class="row mx-1 no-gutters" >
            <div class="col-12 col-lg-8 offset-lg-2">
                @error('post_too_big') <div class="alert alert-danger">{{ $message }}</div>@enderror

                <div class="mt-4 font-14 attribute-label shadow p-4">
                    <p>Zdravo budući Raising Starteri!</p>
                    <p>
                        Pred vama je prijava za Raising Starts, prvi pre-seed program u Srbiji, koji startap timovima
                        i kompanijama u najranijim fazama razvoja inovativnih proizvoda i usluga donosi sveobuhvatnu
                        stručnu i finansijsku podršku. Program obuhvata intenzivne obuke za razvoj biznisa, rad 1 na
                        1 sa mentorima i do 20.000 CHF bespovratno (no equty) za pokrivanje troškova namenjenih izradi
                        prototipa, razvoj biznis modela, istraživanju tržišta, testiranju prvih kupaca, zaštiti intelektualne
                        svojine i ostalih troškova vezanih za razvoj novih proizvoda ili usluga.
                    </p>
                    <p>
                        Program realizuje Naučno-tehnološki park Beograd u partnerstvu sa Naučno-tehnološkim parkom Niš
                        i Naučno-tehnološkim parkom Čačak, uz podršku Vlade Švajcarske.
                    </p>
                    <p>
                        Prijava je ista za učešće u programu u sva tri parka, potrebno je samo izabrati NTP prema
                        regionu/području u kojem želite da se prijavite i u kojem želite da razvijate svoju poslovnu ideju.
                    </p>
                    <p>
                        Da biste započeli i popunili prijavu za učešće na programu, potrebno je najpre da
                        <a href="{{ route('createRaisingStarts') }}">registrujete svoj profil</a>. Nakon registracije profila
                        na mejl koji ste uneli dobićete verifikacioni link koji vas dalje vodi na prijavu.<br />
                        Formular za registrovanje je u nastavku.<br />
                        U nastavku takođe, možete informativno pogledati pitanja koja vas čekaju u samoj prijavi.
                    </p>
                    <p>
                        Važna napomena: Jednom kada budete krenuli sa popunjavanjem prijave, molimo vas da pažljivo pročitate
                        pitanja, popunite prijavu, i budete što precizniji u odgovorima kako bi prijava bila adekvatno ocenjena.
                        Nedovoljno sadržajno popunjene prijave biće slabije ocenjene. Pre popunjavanja prijavnog obrasca obavezno
                        pročitajte Javni poziv i vodič kroz Raising Starts program.<br />
                        <span style="color: #ff0000">U Prilogu 1 Vodiča (strana 17) pogledajte detaljno uputstvo kojim se definiše
                        faza razvoja startapa u kontekstu ovog Programa</span>.<br />
                        Za povratak na Raising Starts landing stranicu klinknite <a href="#">ovde</a>.

                    </p>
                    <p>
                        Prijave se podnose elektronskim putem do <strong><u>28.12.2022. u ponoć.</u></strong>
                    </p>
                    <p>
                        Ukoliko imate nekih pitanja slobodno nas kontaktirajte na: <a href="mailto://info@ntpark.rs" target="_blank">info@ntpark.rs</a>
                    </p>
                    <p>Srećno!</p>

                </div>

                <div class="text-center mt-4 mb-2">
                    <h1 class="attribute-label mt-4">KREIRAJ PROFIL</h1>
                </div>

                <form id="myRaisingStartsForm" method="POST" enctype="multipart/form-data" action="{{ route('storeRaisingStarts') }}" class="mt-4 h-100 w-100">
                    @csrf
                    @include('profiles.partials._rstarts', ['mode' => $mode])
                </form>
            </div>
        </div>

    </div>


@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            let appSent = false;

            const appType = $('#app_type').val();
            if(appType != 2) {
                $('#rstart_id_number_group').hide();
                $('#rstarts_basic_registered_activity_group').hide();
                $('#rstarts_founding_date_group').hide();
            } else {
                $('#rstart_id_number_group').show();
                $('#rstarts_basic_registered_activity_group').show();
                $('#rstarts_founding_date_group').show();
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
                    document.getElementById('myRaisingStartsForm').submit();
                    $(this).attr('disabled', true);
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
                if(appType != 2) {
                    $('#rstart_id_number_group').hide();
                    $('#rstarts_basic_registered_activity_group').hide();
                    $('#rstarts_founding_date_group').hide();
                } else {
                    $('#rstart_id_number_group').show();
                    $('#rstarts_basic_registered_activity_group').show();
                    $('#rstarts_founding_date_group').show();
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
