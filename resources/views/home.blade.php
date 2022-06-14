@extends('layouts.hyper-vertical-mainframe')

{{--@section('page-title')--}}
{{--    {{__('DASHBOARD')}}--}}
{{--@endsection()--}}

@section('page-header')
    <span class="h4" style="position: relative; top:3vh; left: 2vh">{{ mb_strtoupper(__('DASHBOARD')) }}</span>
@endsection

@section('content')

    @php
        foreach (['name', 'profile_state', 'is_company', 'ntp', 'page'] as $key) {
            \Illuminate\Support\Facades\Session::forget($key);
        }
    @endphp

    <div class="row">
        <div class="col-lg-3">
            <show-company-types></show-company-types>
        </div>
        <div class="col-lg-3">
            <application-statuses program_id="{{ \App\Business\Program::$RAISING_STARTS }}"></application-statuses>
        </div>
        <div class="col-lg-6">
            <div id="mesto-kompanija" class="apex-charts shadow-sm bg-white" data-colors="#727cf5,#0acf97,#fa5c7c,#ffbc00"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <find-criteria title="{{ __('How innovative') }}" source="/analytics/splitOptions/how_innovative"></find-criteria>
            <find-criteria
                title="Da li ste sprovodili neke aktivnosti u cilju zaštite prava intelektualne svojine?"
                source="/analytics/splitOptions/intellectual_property">
            </find-criteria>
        </div>
        <div class="col-lg-3">
            <find-criteria title="Faza razvoja - Tehnološki razvoj" source="/analytics/splitOptions/dev_phase_tech"></find-criteria>
            <find-criteria
                title="Kojoj oblasti pripada inovativni proizvod i/ili usluga koju razvijate?"
                source="/analytics/splitOptions/how_innovative">
            </find-criteria>
        </div>
        <div class="col-lg-3">
            <find-criteria title="Faza razvoja - Poslovni razvoj" source="/analytics/splitOptions/dev_phase_business"></find-criteria>
        </div>
        <div class="col-lg-3">
            <find-criteria title="Kako ste nas našli?" source="/analytics/splitOptions/howdiduhear"></find-criteria>
            <find-criteria title="Tip prozvoda ili usluge" source="/analytics/splitOptions/product_type"></find-criteria>
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

            // Get Chart data series
            let series = [];
            axios.get('/analytics/ntp')
            .then(response => {
                series = response.data;
                console.log(response.data);

                let values = [];
                let labels = [];

                series.forEach(s => {
                    console.log(s);
                    values.push(s.count);
                    labels.push(s.ntp)
                });

                console.log(values);
                console.log(labels);

                const t = $('#mesto-kompanija').data('colors');
                const e = t.split(",")
                const config = {
                    chart: {
                        height: 300,
                        type: "donut"
                    },
                    legend: { show: 1 },
                    stroke: { colors: ["transparent"] },
                    series: values,
                    labels: labels,
                    colors: e,
                    responsive: [
                        {
                            breakpoint: 480,
                            options: { chart: { width: 200 }, legend: { position: "bottom" } },
                        },
                    ],
                }

                console.log('zovem chart');
                new ApexCharts(document.querySelector("#mesto-kompanija"), config).render();
                console.log('pozvao chart');

            })
            .catch(error => {
                console.log(error);
            });

        });
    </script>
@endsection



