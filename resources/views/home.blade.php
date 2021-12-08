@extends('layouts.hyper-vertical-mainframe')

@section('content')

    <div class="row">

        <div class="col-md-3">
            <div class="card shadow">
                <ntp-widget id="ntpStructure" source="/analytics/ntp" :labels="['BEOGRAD', 'NIŠ', 'ČAČAK']"></ntp-widget>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow">
                <ntp-piechart id="ntpPie" source="/analytics/ntp" :labels="['BEOGRAD', 'NIŠ', 'ČAČAK']"></ntp-piechart>
            </div>
        </div>
        <div class="col-md-3">

                <show-company-types></show-company-types>

        </div>

    </div>
{{--    <div class="text-center">--}}
{{--        <button type="button" id="btnTestMail" class="btn btn-sm btn-primary rounded-pill">Test Email</button>--}}
{{--    </div>--}}

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



