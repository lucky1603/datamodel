<template>
<div>
    <div class="row">
        <div class="col-xl-4">
            <div class="card shadow-sm" >
                <div class="card-header text-center"><h4>ČLANSTVO</h4></div>
                <div class="card-body row" style="padding: 30px 24px">
                    <div class="col-lg-4">
                        <div class="d-flex justify-content-center align-items-center h-100 w-100">
                            <div class="card m-2 shadow-sm text-center" style="height: 100px; width: 120px">
                                <div class="card-header bg-primary p-0">
                                    <h6 class="text-center text-light">Evidentirani</h6>
                                </div>
                                <div class="card-body d-flex flex-column justify-content-center align-items-start px-0">
                                    <h1 class="text-center w-100">{{ analysis.count}}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="d-flex justify-content-center align-items-center h-100 w-100">
                            <div class="card m-2 shadow-sm" style="height: 100px; width: 120px">
                            <div class="card-header bg-primary text-light p-0">
                                <h6 class="text-center text-light">Virtuelni</h6>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center align-items-start px-0">
                                <h1 class="text-center w-100">{{ analysis.virtuelni}}</h1>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="d-flex justify-content-center align-items-center h-100 w-100">
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
        </div>
        <div class="col-xl-4">
            <div class="card shadow-sm" >
                <div class="card-header text-center"><h4>FINANSIJE</h4></div>
                <div class="card-body" style="padding: 16px 24px">
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
        <div class="col-xl-4">
            <div class="card shadow-sm" >
                <div class="card-header text-center"><h4>LJUDSKI RESURSI</h4></div>
                <div class="card-body row" style="padding: 30px 24px">
                    <div class="col-lg-4">
                        <div class="d-flex justify-content-center align-items-center h-100 w-100">
                            <div class="card m-2 shadow-sm" style="height: 100px; width: 120px">
                            <div class="card-header bg-primary text-light p-0">
                                <h6 class="text-center text-light">ZAPOSLENI</h6>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center align-items-start px-0">
                                <h1 class="text-center w-100">{{ analysis.zaposleni}}</h1>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="d-flex justify-content-center align-items-center h-100 w-100">
                            <div class="card m-2 shadow-sm" style="height: 100px; width: 120px">
                            <div class="card-header bg-primary text-light p-0">
                                <h6 class="text-center text-light">ANGAŽOVANI</h6>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center align-items-start px-0">
                                <h1 class="text-center w-100">{{ analysis.angazovani}}</h1>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="d-flex justify-content-center align-items-center h-100 w-100">
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
    </div>

    <div class="row">
        <div class="col-lg-6" >
            <div class="card shadow-sm">
                <div class="card-header mt-1">
                    <h4 class="header-title mt-1">PO TEHNOLOGIJAMA</h4>
                </div>
                <div class="card-body" style="height: 400px">
                    <apexchart type="donut" :options="chart1Options" :series="values1" height="350px"></apexchart>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header mt-1">
                    <h4 class="header-title mt-1">PO FAZAMA RAZVOJA</h4>
                </div>
                <div class="card-body" style="height: 400px">
<!--                    <canvas id="chartDP"></canvas>-->
                    <apexchart type="donut" :options="chart2Options" :series="values2" height="350px"></apexchart>
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
                console.log(response.data);
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

            })
        },

        getCurrencyValue(value) {
            let formatter = new Intl.NumberFormat('sr-RS', {
                style: 'currency',
                currency: 'RSD',
            });

            return formatter.format(value);
        }
    },
    async mounted() {
        await this.getData();
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
                chart: {
                    height: 'auto',
                },
                labels: []
            },
            chart1Options: {
                chart: {
                    height: 'auto',
                },
                labels: []
            },
        }
    }
}
</script>

<style scoped>

</style>
