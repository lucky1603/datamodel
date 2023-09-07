<template>
    <div>
        <div class="d-flex align-items-center justify-content-center my-2">
            <b-form inline @submit.prevent="onSubmit">
                <label class="mr-2">From</label>
                <b-input type="date" v-model="form.from" class="mr-4" @change="onSubmit"></b-input>
                <label class="mr-2">To</label>
                <b-input type="date" v-model="form.to" class="mr-4" @change="onSubmit"></b-input>
                <b-button variant="primary" @click="resetForm">Reset</b-button>
            </b-form>
        </div>

        <b-row>
            <b-col lg="4" sm="12">
                <!-- <distribution-from-to
                    source="/analytics/prijaveProgrami"
                    :token="token"
                    :from="form.from"
                    :to="form.to" title="Podela prijava po programima">
                </distribution-from-to> -->
                <percentage-card
                    title="Ukupan broj prijava"
                    :value="workshops"
                    icon="uil-meeting-board"
                ></percentage-card>
                <percentage-card
                    title="Ukupan broj kompanija na programima"
                    :value="companies"
                    icon="uil-meeting-board"
                ></percentage-card>
            </b-col>
            <b-col lg="4" sm="12">
                <div class="d-flex align-items-center justify-content-center">
                    <b-card header="GRAFIČKA PODELA PRIJAVA PO PROGRAMIMA" header-bg-variant="white" >
                        <b-card-text>
                            <apexchart
                                type="pie"
                                :options="chartOptions"
                                :series="chartValues"
                                class="w-100"
                                ></apexchart>
                        </b-card-text>
                    </b-card>
                </div>

            </b-col>
            <b-col lg="4" sm="12">
                <div class="d-flex align-items-center justify-content-center border border-danger">
                    <b-card header="GRAFIČKA PODELA PRIJAVA PO PROGRAMIMA" header-bg-variant="white" >
                        <b-card-text>
                            <apexchart
                                type="pie"
                                :options="companyChartOptions"
                                :series="companyChartValues"
                                class="w-100"
                                ></apexchart>
                        </b-card-text>
                    </b-card>
                </div>
            </b-col>
        </b-row>
    </div>
</template>

<script>
export default {
    name: 'Statistics4',

    props: {
        token: {typeof: String, default: ''}
    },

    data() {
        return {
            form: {
                from: '',
                to: ''
            },
            workshops: 0,
            companies: 0,
            items: {},
            companyItems: {},
            chartOptions: {
                labels: []
            },
            chartValues: [],
            companyChartOptions: {
                labels: []
            },
            companyChartValues: []
        };
    },

    async mounted() {
        await this.getData();
    },

    methods: {
        async onSubmit() {
            await this.getData();
        },
        resetForm() {
            this.form.from = '';
            this.form.to = '';
            this.getData();
        },
        async getData() {
            let formData = new FormData();
            formData.append('_token', this.token);
            formData.append('from', this.form.from);
            formData.append('to', this.form.to);
            await axios.post('/analytics/prijaveProgrami', formData)
            .then(response => {
                console.log("prijave po programima");
                console.log(response.data);
                this.items = response.data;
                this.workshops = 0;
                for(let property in this.items) {
                    let item = this.items[property];
                    this.workshops += item.count;
                    this.chartOptions.labels.push(item.text);
                    this.chartValues.push(item.count);
                }

            });


            await axios.post('/analytics/kompanijeProgrami', formData)
            .then(response => {
                console.log("kompanije po programima");
                console.log(response.data);
                this.companyItems = response.data;
                this.companies = 0;
                for(let property in this.companyItems) {
                    let item = this.companyItems[property];
                    this.companies += item.count;
                    this.companyChartOptions.labels.push(item.text);
                    this.companyChartValues.push(item.count);
                }
            });
        }
    },
};
</script>

<style lang="scss" scoped>

</style>
