@extends('layouts.hyper-vertical-mainframe')

@section('page-title')
    {{__('DASHBOARD')}}
@endsection()

@section('content')

    <div class="row">

        <div class="col-lg-3">
            <div class="card shadow">
                <ntp-widget
                    id="ntpStructure"
                    source="/analytics/ntp"
                    :labels="['BEOGRAD', 'NIŠ', 'ČAČAK']"
                    :bgcolors="['rgba(255,0,0,0.7)', 'rgba(0,255,0,0.7)','rgba(0,128,255,0.7)']"></ntp-widget>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card shadow">
                <ntp-piechart
                    id="ntpPie"
                    source="/analytics/ntp"
                    :labels="['BEOGRAD', 'NIŠ', 'ČAČAK']"
                    :bgcolors="['rgba(255,0,0,0.7)', 'rgba(0,255,0,0.7)','rgba(0,128,255,0.7)']"></ntp-piechart>
            </div>
        </div>
        <div class="col-lg-3">
            <show-company-types></show-company-types>
        </div>
        <div class="col-lg-3">
            <find-criteria></find-criteria>
        </div>
    </div>

@endsection

@section('scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            if(!$('#link_home').hasClass('active')) {
                $('#link_home').addClass('active');
            }

            if($('#link_clients').hasClass('active')) {
                $('#link_clients').removeClass('active');
            }

            if($('#link_contracts').hasClass('active')) {
                $('#link_contracts').removeClass('active');
            }

            $('#btnTestMail').click(function() {
                $.get('testmail/sinisa.ristic@prosmart.rs', function(data) {
                    console.log(data);
                }) ;
            });

        });
    </script>
@endsection



