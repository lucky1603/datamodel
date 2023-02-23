@extends('layouts.backbone')

@section('title')
    Rastuce - Prijava
@endsection

@section('body-content')
    <div class="w-100 h-100 px-1">
        <div class="row bg-dark" >
            <div class="col-lg-4 h-100">
                <img src="/images/custom/ntplogo.png" class="ml-3 m-4" style="width: 90%"/>
            </div>

            <div class="col-lg-3 offset-lg-5 h-100" style="display: flex; align-items: center; justify-content: center">
                <img src="/images/custom/rastuce.png" class="m-4" style="height: 150px"/>
            </div>
        </div>
        <div class="row mx-1 no-gutters">
            <div class="col-12 col-lg-8 offset-lg-2">
                <div class="text-center mb-4 mt-4">
                    <h1 class="attribute-lagbel">{{ __('PRIJAVA')}}</h1>
                </div>
                <form action="{{ route('storeRastuce') }}" method="post" enctype="multipart/form-data" id="myRastuceForm" class="mt-4 w-100 h-100">
                    @csrf
                    @include('profiles.partials._rastuce', ['mode' => $mode])
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#okSpinner').hide();
            $('#cancelSpinner').hide();
            $('#buttonSend').click(function() {
                $('#okSpinner').show();
                try {
                    document.getElementById('myRastuceForm').submit();
                    $(this).attr('disabled', true);
                } catch (e) {
                    console.log(e.message);
                }

            });

            $('#buttonCancel').click(function() {
                $('#cancelSpinner').show();
                location.href = 'https://ntpark.rs/raising-starts/';
            });
        })
    </script>
@endsection
