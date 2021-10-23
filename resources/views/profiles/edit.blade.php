@extends('layouts.backbone')

@section('body-content')
    <div class="row">
        <div class="col-12 bg-dark text-light" style="display: flex">
            <img src="/images/custom/white-logo-transparent-full.png" style="height: 80px" class="ml-3 mt-2"/>
            <p class="text-center mt-4 w-75 font-24 ">
                {{strtoupper(__('Edit Profile')) }}</p>
        </div>
    </div>


    <div id="contentArea" class="container">
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
