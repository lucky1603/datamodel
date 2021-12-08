<template>
    <canvas :id="id" height="300" class="p-2"></canvas>
</template>

<script>
export default {
    name: "NtpPieChart",
    props: {
        id:'PieChart',
        source: { typeof: String, default: ''},
        labels: [],
    },
    methods: {
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
                type: 'pie',
                data: {
                    labels: this.names,
                    datasets: [{
                        data: this.values,
                        backgroundColor: [
                            'rgba(255, 0, 0, 0.5)',
                            'rgba(0,255,0, 0.5)',
                            'rgba(0,0,255, 0.5)'
                        ]
                    }]
                },
                options: {
                    indexAxis: 'y',
                    scales: {
                        xAxes: [{
                            ticks: {
                                beginAtZero: true
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
        }
    },
    async mounted() {
        console.log(this.labels);
        if(this.labels != undefined && this.labels.length != 0) {
            this.names = this.labels;
        }

        await this.getData();
        await this.createChart();
    }
}
</script>

<style scoped>

</style>
