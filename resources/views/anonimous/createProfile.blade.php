@extends('layouts.backbone')

@section('title')
    Raising Starts - Kreiranje novog profila
@endsection

@section('body-content')
    <div class="row bg-dark" style="height: 100px">
        <div class="col-6 col-lg-2 h-100">
            <img src="/images/custom/white-logo-transparent-full.png" class="ml-3 mt-2 h-75" />
        </div>
        <div class="col-lg-8 text-center" style="display: flex; align-items: center; horiz-align: center">
            <span class="font-24 text-light w-100" style="font-family: 'Roboto Light'">
                {{strtoupper(__('Create Your Profile')) }}</span>
        </div>
        <div class="col-6 col-lg-2 h-100">
            <div class="row h-100">
                <div class="col-4 h-100" style="align-items: center; display: flex">
                    <img src="/images/custom/whiterocket.png" class="h-75 mt-auto mb-auto" />
                </div>
                <div class="col-8 h-100" style="align-items: center; display: flex">
                    <span class="text-light font-24" style="font-family: 'Roboto Light'">ACCELERATOR</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 offset-3">
            @include('profiles.partials._profile_create_form')
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            if($('#is_company').prop('checked') == true) {
                $('#nameCol').removeClass('col-lg-12').addClass('col-lg-6');
                $('#idNumberCol').show();
            } else {
                $('#idNumberCol').hide();
                $('#nameCol').removeClass('col-lg-6').addClass('col-lg-12');
            }

            $('#is_company').on('change', function(event) {
                if($(this).prop('checked') == true) {
                    $('#nameCol').removeClass('col-lg-12').addClass('col-lg-6');
                    $('#idNumberCol').show();
                } else {
                    $('#idNumberCol').hide();
                    $('#nameCol').removeClass('col-lg-6').addClass('col-lg-12');
                }
            });
        })
    </script>
@endsection
