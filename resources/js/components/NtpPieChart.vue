<template>
    <canvas :id="id" height="300" class="p-2"></canvas>
</template>

<script>
export default {
    name: "NtpPieChart",
    props: {
        id: {typeof:String, default: 'PieChart'},
        source: { typeof: String, default: ''},
        labels: [],
        bgcolors:[],
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
                        backgroundColor: this.backgroundColors
                    }]
                },
                options: {

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
            backgroundColors: [
                'rgba(255, 0, 0, 0.5)',
                'rgba(0,255,0, 0.5)',
                'rgba(0,0,255, 0.5)'
            ]
        }
    },
    async mounted() {
        console.log(this.labels);
        if(this.labels != undefined && this.labels.length != 0) {
            this.names = this.labels;
        }

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
