@extends('layouts.backbone')

@section('title')
    Incubation BITF - Prijava
@endsection

@section('body-content')
    <div class="h-100 w-100 px-1">
        <div class="row bg-dark" >
            <div class="col-lg-4 h-100">
                <img src="/images/custom/ntplogo.png" class="ml-3 m-4" style="width: 90%"/>
            </div>

            <div class="col-lg-3 offset-lg-5 h-100" style="display: flex; align-items: center; justify-content: center">
                <img src="/images/custom/inkubacija.png" class="m-4" style="height: 150px"/>
            </div>
        </div>
        <div class="row mx-1 no-gutters">
            <div class="col-12 col-lg-8 offset-lg-2">
                <div class="text-center mt-4 mb-4">
                    <h1 class="attribute-label">PRIJAVA</h1>
                </div>

                <form action="{{ route('storeIncubationBITF') }}" method="POST" enctype="multipart/form-data" id="myIncubationBITFForm" class="mt-4 w-100 h-100">
                    @csrf

                    @include('profiles.partials._ibitf', ['mode' => $mode])

                    {{-- <div class="text-center mt-4">
                        <p>Ukoliko ste već potvrdili vašu e-mail adresu i kreirali nalog, prijaviti se sa vašim korisničkim imenom i lozinkom
                           na adresi <a href="https://platforma.ntpark.rs/login" target="_blank">https://platforma.ntpark.rs/login</a> i nastavite
                           popunjavanje prijave.</p>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Initially hide spinners.
            $('#okSpinner').hide();
            $('#cancelSpinner').hide();

            // Refresh captcha.
            $('#refresh').click(function(){
                $.ajax({
                    type:'GET',
                    url:'/refreshcaptcha',
                    success:function(data){
                        $(".captcha span").html(data.captcha);
                    }
                });
            });

            // Prevent file inputs to be bigger than 1M.
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
            });


            // // Toggle PIB and ID_NUMBER
            // const legalStatus = $('#legal_status').val();
            // if(legalStatus != 2) {
            //     $('#pibRow').hide();
            //     $('#idNumberRow').hide();
            //     $('#dateRow').hide();
            // } else {
            //     $('#pibRow').show();
            //     $('#idNumberRow').show();
            //     $('#dateRow').show();
            // }

            // $('#legal_status').change(function() {
            //     const legalStatus = $('#legal_status').val();
            //     if(legalStatus != 2) {
            //         $('#pibRow').hide();
            //         $('#idNumberRow').hide();
            //         $('#dateRow').hide();
            //     } else {
            //         $('#pibRow').show();
            //         $('#idNumberRow').show();
            //         $('#dateRow').show();
            //     }
            // });

            $('#buttonSend').click(function() {
                $('#okSpinner').show();
                try {
                    document.getElementById('myIncubationBITFForm').submit();
                    $(this).attr('disabled', true);
                } catch (e) {
                    console.log(e.message);
                }

            });

            $('#buttonCancel').click(function() {
                $('#cancelSpinner').show();
                location.href = 'https://ntpark.rs/incubation/';
            });
        });
    </script>
@endsection
