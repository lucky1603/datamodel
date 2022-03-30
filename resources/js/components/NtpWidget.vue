<template>
    <canvas :id="id" height="300" class="p-2"></canvas>
</template>

<script>
import Chart from "chart.js/auto";
export default {
    name: "NtpWidget",
    props: {
        source: { typeof: String, default: ''},
        labels: [],
        bgcolors: [],
        id: { typeof: String, default: `myChart` }
    },
    methods : {
        async getData() {
            await axios.get(this.source)
                .then(response => {
                    this.items = [];
                    for(const property in response.data) {
                        console.log(response.data[property]);
                        this.items.push(response.data[property]);
                    }
                    console.log(this.items);

                    this.items.forEach(item => {
                        this.values.push(item.count);
                    });

                    if(this.names.length == 0) {
                        this.items.forEach(item => {
                            this.names.push(item.ntp);
                        });
                    }

                });
        },
        async createChart() {
            const ctx = document.getElementById(this.id);
            this.chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: this.names,
                    datasets: [{
                        label: '# kandidata po NTP',
                        data: this.values,
                        backgroundColor: this.backgroundColors,
                        borderColor: [
                            'rgb(255, 159, 64)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                        ],
                        border: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    scales: {
                        xAxes: [{
                            ticks: {
                                beginAtZero: true,
                            }
                        }]
                    }
                }
            });
        }
    },
    data() {
        return {
            items: [],
            values: [],
            names: [],
            action: { typeof: String, default: ' '},
            backgroundColors:[],
            chart: {}
        }
    },

    async mounted() {
        console.log(this.labels);
        if(this.labels != undefined && this.labels.length != 0) {
            this.names = this.labels;
        }

        this.backgroundColors = [
            'rgba(255, 159, 64, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(54, 162, 235, 0.2)',
        ];

        if(this.bgcolors != undefined && this.bgcolors.length > 0) {
            this.backgroundColors = this.bgcolors;
        }

        await this.getData();
        await this.createChart();

    }
}
</script>

<style scoped>

</style>
