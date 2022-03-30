<template>
<div>
    <div class="d-flex align-items-center justify-content-center">
        <div class="card p-1 m-2 shadow-sm" style="width: 150px; height: 100px">
            <div class="card-body d-flex flex-column justify-content-center align-items-start px-0">
                <h6 class="text-center text-success w-100 border-bottom border-light pb-1">Virtuelni</h6>
                <h1 class="text-center w-100">{{ analysis.virtuelni}}</h1>
            </div>
        </div>
        <div class="card p-1 m-2 shadow-sm" style="width: 150px; height: 100px">
            <div class="card-body d-flex flex-column justify-content-center align-items-start px-0">
                <h6 class="text-center text-success w-100 border-bottom border-light pb-1">Punopravni</h6>
                <h2 class="text-center w-100">{{ analysis.punopravni}}</h2>
            </div>
        </div>
        <div class="card p-1 m-2 shadow-sm" style="width: 250px; height: 100px">
            <div class="card-body d-flex flex-column justify-content-center align-items-start px-0">
                <h6 class="text-center text-primary w-100 border-bottom border-light pb-1">Prihodi</h6>
                <h3 class="text-center w-100">{{ getCurrencyValue(analysis.prihod)}}</h3>
            </div>
        </div>
        <div class="card p-1 m-2 shadow-sm" style="width: 150px; height: 100px">
            <div class="card-body d-flex flex-column justify-content-center align-items-start px-0">
                <h6 class="text-center text-info w-100 border-bottom border-light pb-1">Zaposleni</h6>
                <h2 class="text-center w-100">{{ analysis.zaposleni }}</h2>
            </div>
        </div>
        <div class="card p-1 m-2 shadow-sm" style="width: 150px; height: 100px">
            <div class="card-body d-flex flex-column justify-content-center align-items-start px-0">
                <h6 class="text-center text-info w-100 border-bottom border-light pb-1">Angažovani</h6>
                <h2 class="text-center w-100">{{ analysis.angazovani }}</h2>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <div class="shadow-sm d-flex flex-column justify-content-center align-items-start bg-white w-25 m-1" >
            <h5 class="text-center w-100 border-bottom border-light text-primary pb-1">PO TEHNOLOGIJAMA</h5>
            <canvas id="chartBB"></canvas>
        </div>
        <div class="shadow-sm d-flex flex-column justify-content-center bg-white w-25 m-1">
            <h5 class="text-center w-100 border-bottom border-light text-primary pb-1">PO FAZAMA RAZVOJA</h5>
            <canvas id="chartDP"></canvas>
            <div></div>

        </div>
        <find-criteria title="Po fazama razvoja" :input_items="items1" :item_count="analysis.count" source="" class="m-1"></find-criteria>
        <find-criteria title="Po tehnologiji" :input_items="items2" :item_count="analysis.count" source="" class="m-1"></find-criteria>
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

                this.analysis.po_stepenu_razvoja.forEach(option => {
                    if(option.count > 0) {
                        this.labels1.push(option.text);
                        this.values1.push(option.count);

                        this.items1.push(option);
                    }

                });

                for(let key in this.analysis.po_tehnologiji) {
                    let option = this.analysis.po_tehnologiji[key];
                    if(option.count > 0) {
                        this.labels2.push(option.text);
                        this.values2.push(option.count);

                        this.items2.push(option);
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
            labels2: [],
            values2: [],
            backgroundColors: [
                'rgba(255, 0, 0, 0.7)',
                'rgba(0,255,0, 0.7)',
                'rgba(0,0,255, 0.7)',
                'rgba(255, 255, 0, 0.7)',
                'rgba(255,0,255,0.7)',
                'rgba(0,255,255,0.7)'
            ],
            chart1: null,
            chart2: null,
            barchartOptions: {
                chart: {
                    id: 'vuechart-example'
                },
                xaxis: {
                    categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998]
                }
            },
            barchartSeries: [{
                name: 'series-1',
                data: [30, 40, 45, 50, 49, 60, 70, 91]
            }],
            items1 : [],
            items2 : []
        }
    }
}
</script>

<style scoped>

</style>
