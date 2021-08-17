@extends('layouts.backbone')

@section('body-content')
    <div style="position: absolute; top:0px; left: 0px; right: 0px; height: 100px" class="bg-dark">
        <div style="position: absolute; left: 0px; top: 0px; bottom: 0px; width: 25%">
            <img src="/images/custom/white-logo-transparent-full.png" style="height: 80px" class="ml-3 mt-2"/>
        </div>

        <div style="position: absolute; left: 25%; top: 0px; right: 0px; bottom: 0px" >
            <p style="width: 100%; font-size: 27px; font-weight: 300; color: white" class="text-center mt-4">
                {{strtoupper(__('Create Your Profile')) }}</p>
        </div>
    </div>
    <div id="leftBar" style="position: absolute; top:100px; left:0px; bottom: 0px; width: 350px" class="bg-light shadow-lg">
        <p class="font-weight-light attribute-label ml-2 mr-2" style="margin-top: 200px; font-size: 1.4em">Molimo, popunite formu za registraciju kako biste napravili svoj profil.</p>
        <p class="font-weight-light attribute-label m-2" style="font-size: 1.4em">Po pravilnom popunjavanju forme i slanju podataka, dobićete e-mail poruku sa
            linkom za aktivaciju profila.</p>
        <p class="font-weight-light attribute-label m-2" style="font-size: 1.4em">Kada je profil aktiviran, moćićete da se prijavite sa svojim pristupnim podacima
        i da izaberete željeni program.</p>
    </div>
    <div id="contentArea" style="position: absolute; top:100px; left:350px; right: 0px; bottom:0px; overflow: auto">
        <div class="m-sm-5">
            @include('profiles.partials._profile_create_form')
        </div>

    </div>
@endsection


{{--@extends('layouts.create')--}}

{{--@section('title')--}}
{{--    <h1 class="page-title">Dodaj novi profil</h1>--}}
{{--@endsection--}}

{{--@section('create_user')--}}
{{--    <hr style="margin-top:40px;"/>--}}
{{--    <h3 style="text-align: center; margin-top:20px; margin-bottom: 20px">Osnovni korisnik</h3>--}}
{{--    <div class="form-group row">--}}
{{--        <div class="col-sm-3"></div>--}}
{{--        <label for="user_name" class="col-sm-2 col-form-label">Ime korisnika</label>--}}
{{--        <div class="col-sm-4">--}}
{{--            <input type="text"--}}
{{--                   class="form-control @error('user_name') is-invalid @enderror"--}}
{{--                   id="user_name"--}}
{{--                   name="user_name"--}}
{{--                   value="{{ old('user_name') }}"--}}
{{--                   required--}}
{{--                   autocomplete="user_name"--}}
{{--                   autofocus>--}}
{{--            @error('user_name')--}}
{{--            <span class="invalid-feedback" role="alert">--}}
{{--                    <strong>{{ $message }}</strong>--}}
{{--                </span>--}}
{{--            @enderror--}}
{{--        </div>--}}
{{--        <div class="col-sm-3"></div>--}}
{{--    </div>--}}
{{--    <div class="form-group row">--}}
{{--        <div class="col-sm-3"></div>--}}
{{--        <label for="user_email" class="col-sm-2 col-form-label">E-Mail</label>--}}
{{--        <div class="col-sm-4">--}}
{{--            <input type="email"--}}
{{--                   class="form-control @error('user_email') is-invalid @enderror"--}}
{{--                   id="user_email"--}}
{{--                   name="user_email"--}}
{{--                   value="{{ old('user_email') }}"--}}
{{--                   required--}}
{{--                   autocomplete="user_email"--}}
{{--            >--}}
{{--            @error('user_email')--}}
{{--            <span class="invalid-feedback" role="alert">--}}
{{--                    <strong>{{ $message }}</strong>--}}
{{--                </span>--}}
{{--            @enderror--}}
{{--        </div>--}}
{{--        <div class="col-sm-3"></div>--}}
{{--    </div>--}}
{{--    <div class="form-group row">--}}
{{--        <div class="col-sm-3"></div>--}}
{{--        <label for="user_password" class="col-sm-2 col-form-label">Password</label>--}}
{{--        <div class="col-sm-4">--}}
{{--            <input type="password"--}}
{{--                   class="form-control @error('user_password') is-invalid @enderror"--}}
{{--                   id="user_password"--}}
{{--                   name="user_password"--}}
{{--                   required--}}
{{--                   autocomplete="user_password"--}}
{{--            >--}}
{{--            @error('user_password')--}}
{{--            <span class="invalid-feedback" role="alert">--}}
{{--                    <strong>{{ $message }}</strong>--}}
{{--                </span>--}}
{{--            @enderror--}}
{{--        </div>--}}
{{--        <div class="col-sm-3"></div>--}}
{{--    </div>--}}
{{--    <div class="form-group row">--}}
{{--        <div class="col-sm-3"></div>--}}
{{--        <label for="user_repeat_password" class="col-sm-2 col-form-label">Repeat Password</label>--}}
{{--        <div class="col-sm-4">--}}
{{--            <input type="password"--}}
{{--                   class="form-control"--}}
{{--                   id="user_repeat_password"--}}
{{--                   name="user_repeat_password"--}}
{{--                   required--}}
{{--                   autocomplete="user_repeat_password"--}}
{{--            >--}}
{{--        </div>--}}
{{--        <div class="col-sm-3"></div>--}}
{{--    </div>--}}
{{--    <hr style="margin-top:20px;"/>--}}
{{--@endsection--}}

{{--@section('scripts')--}}
{{--    <script type="text/javascript">--}}
{{--        $(function() {--}}
{{--            if($(this).prop('checked') == true) {--}}
{{--                $('#id_number_group').show();--}}
{{--            } else {--}}
{{--                $('#id_number_group').hide();--}}
{{--            }--}}

{{--            $('#is_company').on('change', function(event) {--}}
{{--                if($(this).prop('checked') == true) {--}}
{{--                    $('#id_number_group').show();--}}
{{--                } else {--}}
{{--                    $('#id_number_group').hide();--}}
{{--                }--}}
{{--            });--}}
{{--        })--}}
{{--    </script>--}}
{{--@endsection--}}
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {

        if($('#is_company').prop('checked') == true) {
            $('#id_number_group').show();
        } else {
            $('#id_number_group').hide();
        }

        $('#is_company').on('change', function(event) {
            if($(this).prop('checked') == true) {
                $('#id_number_group').show();
            } else {
                $('#id_number_group').hide();
            }
        });
    })
</script>
@endsection
