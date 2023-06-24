<template>
    <div>
        <div class="d-flex align-items-center justify-content-center">
            <b-form inline>
                <label for="years" class="mr-2">Godina</label>
                <b-select v-model="form.year" id="years" :options="years" @change="selectChanged"></b-select>
            </b-form>
        </div>
        <hr/>
        <b-row class="mt-4">
            <b-col lg="6">
                <div class="d-flex align-items-center justify-content-center h-100 p-4">
                    <distribution
                        ref="distribution"
                        title="Raspodela po vrstama dogadjaja"
                        source="/trainings/statistics"

                        :year="form.year"
                        :token="token"
                    ></distribution>
                </div>

            </b-col>
            <b-col lg="6">
                <div class="d-flex align-items-center justify-content-center h-100">
                    <apexchart
                        type="pie"
                        :options="chartOptions"
                        :series="chartValues"
                        height="100%" class="w-100"
                        ></apexchart>
                </div>
            </b-col>
        </b-row>
    </div>

</template>

<script>
export default {
    name: 'EventDashboard',
    props: {
        token: {typeof: String, default: ''},
        year: { typeof: Number, default: 2023 }
    },

    data() {
        return {
            count: 33,
            form: {
                year: 2023
            },
            years: [
                { value: 0, text: "svi"},
                { value: 2022, text: "2022"},
                { value: 2023, text: "2023"},
            ],
            chartOptions: {
                labels: [],
            },
            chartValues: [],
        };
    },

    async mounted() {
        await this.getData();
        console.log('mounted');
    },

    methods: {
        async getData() {
            let formData = new FormData();
            formData.append('_token', this.token);
            formData.append('year', this.form.year);
            await axios.post('/trainings/statistics', formData)
            .then(response => {

                let items = response.data.items;
                this.chartOptions.labels.length = 0;
                this.chartValues.length = 0;
                for(let property in items) {
                    this.chartOptions.labels.push(property);
                    this.chartValues.push(items[property])
                }
            })
        },
        selectChanged(idx) {
            console.log(idx);
            this.getData();
        }
    },
};
</script>

<style lang="scss" scoped>

</style>
