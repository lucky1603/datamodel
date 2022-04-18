<template>
<div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header text-center"><h4>ČLANSTVO</h4></div>
                <div class="card-body row">
                    <div class="col-lg-4">
                        <div class="card m-2 shadow-sm" style="height: 100px; width: 120px">
                            <div class="card-header bg-primary p-0">
                                <h6 class="text-center text-light">Evidentirani</h6>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center align-items-start px-0">
                                <h1 class="text-center w-100">{{ analysis.count}}</h1>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="card m-2 shadow-sm" style="height: 100px; width: 120px">
                            <div class="card-header bg-primary text-light p-0">
                                <h6 class="text-center text-light">Virtuelni</h6>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center align-items-start px-0">
                                <h1 class="text-center w-100">{{ analysis.virtuelni}}</h1>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="card m-2 shadow-sm" style="height: 100px; width: 120px">
                            <div class="card-header bg-primary text-light p-0">
                                <h6 class="text-center text-light">Punopravni</h6>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center align-items-start px-0">
                                <h1 class="text-center w-100">{{ analysis.punopravni}}</h1>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm" >
                <div class="card-header text-center"><h4>FINANSIJE</h4></div>
                <div class="card-body" style="padding: 5px 10px 5px 10px">
                    <div class="row">
                        <div class="col-lg-6">
                                <div class="d-flex flex-column justify-content-center align-items-start shadow-sm mb-1 p-0">
                                    <h6 class="text-center text-success w-100 bg-primary text-light py-1 mt-0">Prihodi</h6>
                                    <p class="text-center w-100 font-12 font-weight-bold" style="font-family: 'Roboto Light'">{{ getCurrencyValue(analysis.prihod)}}</p>
                                </div>
                        </div>
                        <div class="col-lg-6">
                                <div class="d-flex flex-column justify-content-center align-items-start shadow-sm mb-1 p-0">
                                    <h6 class="text-center text-light w-100 bg-primary py-1 mt-0">Izvoz</h6>
                                    <p class="text-center w-100 font-12 font-weight-bold" style="font-family: 'Roboto Light'">{{ getCurrencyValue(analysis.izvoz)}}</p>
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                                <div class="d-flex flex-column justify-content-center align-items-start shadow-sm mb-1 p-0">
                                    <h6 class="text-center text-light w-100 bg-primary py-1 mt-0">Plaćeni porezi</h6>
                                    <p class="text-center w-100 font-12 font-weight-bold" style="font-family: 'Roboto Light'">{{ getCurrencyValue(analysis.porez)}}</p>
                                </div>
                        </div>
                        <div class="col-lg-6">
                                <div class="d-flex flex-column justify-content-center align-items-start shadow-sm mb-1 p-0">
                                    <h6 class="text-center text-light w-100 bg-primary py-1 mt-0">Investicije</h6>
                                    <p class="text-center w-100 font-12 font-weight-bold" style="font-family: 'Roboto Light'">{{ getCurrencyValue(analysis.investicije)}}</p>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header text-center"><h4>LJUDSKI RESURSI</h4></div>
                <div class="card-body row">
                    <div class="col-lg-4">
                        <div class="card m-2 shadow-sm" style="height: 100px; width: 120px">
                            <div class="card-header bg-primary text-light p-0">
                                <h6 class="text-center text-light">ZAPOSLENI</h6>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center align-items-start px-0">
                                <h1 class="text-center w-100">{{ analysis.zaposleni}}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card m-2 shadow-sm" style="height: 100px; width: 120px">
                            <div class="card-header bg-primary text-light p-0">
                                <h6 class="text-center text-light">ANGAŽOVANI</h6>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center align-items-start px-0">
                                <h1 class="text-center w-100">{{ analysis.angazovani}}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card m-2 shadow-sm" style="height: 100px; width: 120px">
                            <div class="card-header bg-primary text-light p-0">
                                <h6 class="text-center text-light">OD TOGA ŽENE</h6>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center align-items-start px-0">
                                <h1 class="text-center w-100">{{ analysis.zene}}</h1>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6" >
            <div class="card shadow-sm">
                <div class="card-header mt-1">
                    <h4 class="header-title mt-1">PO TEHNOLOGIJAMA</h4>
                </div>
                <div class="card-body">
                    <apexchart width="100%" type="donut" :options="chart1Options" :series="values1"></apexchart>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header mt-1">
                    <h4 class="header-title mt-1">PO FAZAMA RAZVOJA</h4>
                </div>
                <div class="card-body">
<!--                    <canvas id="chartDP"></canvas>-->
                    <apexchart width="100%" type="donut" :options="chart2Options" :series="values2"></apexchart>
                </div>
            </div>
        </div>

    </div>



</div>
</template>

<script>
import Chart from 'chart.js/auto';
export default {
    name: "ProfileStatistics",
    components: { Chart },
    methods: {
        async getData() {
            await axios.get('/analytics/getProfileStatisticsSummary')
            .then(response => {
                this.analysis = response.data;
                this.labels1.length = 0;
                this.values1.length = 0;
                this.labels2.length = 0;
                this.values2.length = 0;
                console.log(this.analysis);

                this.chart1Options.labels.length = 0;
                this.analysis.po_stepenu_razvoja.forEach(option => {
                    if(option.count > 0) {
                        this.chart1Options.labels.push(option.text);
                        this.values1.push(option.count);
                    }

                });

                this.chart2Options.labels.length = 0;

                for(let key in this.analysis.po_tehnologiji) {
                    let option = this.analysis.po_tehnologiji[key];
                    if(option.count > 0) {
                        this.chart2Options.labels.push(option.text);
                        this.values2.push(option.count);
                    }

                }

                // this.analysis.po_tehnologiji.forEach(option => {
                //     this.labels2.push(option.name);
                //     this.values2.push(option.count);
                // });
            })
        },
        async createChart(id, labels, values) {
            const data = {
                labels: labels,
                datasets: [{
                    label: 'My First Dataset',
                    data: values,
                    backgroundColor: this.backgroundColors,
                    hoverOffset: 4
                }]
            };

            const config = {
                type: 'pie',
                data: data,
                options: {
                    layout: {
                        padding: 20
                    },

                }
            };

            const ctx = document.getElementById(id);
            return new Chart(ctx, config);
        },
        getCurrencyValue(value) {
            let formatter = new Intl.NumberFormat('sr-RS', {
                style: 'currency',
                currency: 'RSD',

                // These options are needed to round to whole numbers if that's what you want.
                //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
            });

            return formatter.format(value);
        }
    },
    async mounted() {
        await this.getData();
        this.chart1 = await this.createChart('chartBB', this.labels2, this.values2);
        this.chart2 = await this.createChart('chartDP', this.labels1, this.values1);
    },
    data() {
        return {
            analysis : {},
            labels1: [],
            values1: [],
            labels2: ["prvi", "drugi", "treci", "cetvrti"],
            values2: [55, 33, 22, 11],
            backgroundColors: [
                'rgba(200,200,200,0.7)',
                'rgba(255, 0, 0, 0.7)',
                'rgba(0,255,0, 0.7)',
                'rgba(0,0,255, 0.7)',
                'rgba(255, 255, 0, 0.7)',
                'rgba(255,0,255,0.7)',
                'rgba(0,255,255,0.7)'
            ],
            chart1: null,
            chart2: null,
            chart2Options: {
                labels: []
            },
            chart1Options: {
                labels: []
            },
        }
    }
}
</script>

<style scoped>

</style>
