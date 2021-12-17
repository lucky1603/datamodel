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
            <find-criteria title="{{ __('How innovative') }}" source="/analytics/splitOptions/rstarts_how_innovative"></find-criteria>
            <find-criteria
                title="Da li ste sprovodili neke aktivnosti u cilju zaštite prava intelektualne svojine?"
                source="/analytics/splitOptions/rstarts_intellectual_property">
            </find-criteria>

        </div>
        <div class="col-lg-3">
            <div class="card shadow">
                <ntp-piechart
                    id="ntpPie"
                    source="/analytics/ntp"
                    :labels="['BEOGRAD', 'NIŠ', 'ČAČAK']"
                    :bgcolors="['rgba(255,0,0,0.7)', 'rgba(0,255,0,0.7)','rgba(0,128,255,0.7)']"></ntp-piechart>
            </div>
            <find-criteria title="Faza razvoja - Tehnološki razvoj" source="/analytics/splitOptions/rstarts_dev_phase_tech"></find-criteria>
            <find-criteria
                title="Kojoj oblasti pripada inovativni proizvod i/ili usluga koju razvijate?"
                source="/analytics/splitOptions/rstarts_innovative_area">
            </find-criteria>
        </div>
        <div class="col-lg-3">
            <show-company-types></show-company-types>
            <find-criteria title="Faza razvoja - Poslovni razvoj" source="/analytics/splitOptions/rstarts_dev_phase_bussines"></find-criteria>
        </div>
        <div class="col-lg-3">
            <find-criteria title="Kako ste nas našli?" source="/analytics/howDidUHear"></find-criteria>
            <find-criteria title="Tip prozvoda ili usluge" source="/analytics/splitOptions/rstarts_product_type"></find-criteria>
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



