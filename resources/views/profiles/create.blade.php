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
    <div id="contentArea" style="position: absolute; top:100px; left:350px; right: 0px; bottom:0px; overflow: auto; padding: 50px 200px 0 200px">
        <div>
            @include('profiles.partials._profile_create_form')
        </div>

    </div>
@endsection

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
