<template>
    <div>
        <div class="row">
            <div class="col-lg-3">
                <percentage-card
                    title="Startapovi"
                    :value="startupCount"
                    :total="total"
                    subtitle="od svih prijavljenih"
                    icon="uil-arrow-up-right"></percentage-card>
                <percentage-card
                    title="Kompanije"
                    :value="companiesCount"
                    :total="total"
                    subtitle="od svih prijavljenih"
                    percentage_class="text-danger"
                    icon="uil-bag"></percentage-card>
                <percentage-card
                    title="Potpisan ugovor"
                    :value="inProgram"
                    :total="total"
                    subtitle="od svih prijavljenih"
                    icon="uil-file-contract-dollar"></percentage-card>

            </div>
            <div class="col-lg-3">
                <percentage-card
                    title="U procesu prijave"
                    :value="applied"
                    :total="total"
                    subtitle="od svih prijavljenih"
                    percentage_class="text-danger"
                    icon="uil-file-alt"></percentage-card>
                <percentage-card
                    title="Poslate prijave"
                    :value="sent"
                    :total="total"
                    subtitle="od svih prijavljenih"
                    icon="uil-file-check-alt"></percentage-card>
                <percentage-card
                    title="Odbijeni"
                    :value="outOfProgram"
                    :total="total"
                    subtitle="od svih prijavljenih"
                    percentage_class="text-danger"
                    icon="uil-sign-out-alt"></percentage-card>

            </div>
            <div class="col-lg-6">
                <div class="card shadow-sm" style="height:300px">
<!--                    <div class="card-header">-->
<!--                        <h4 class="header-title mt-1">BROJ PRIJAVLJENIH PO NTP</h4>-->
<!--                    </div>-->
                    <div class="card-body" >
                        <apexchart type="donut" :options="chartOptions" :series="chartValues" height="100%" ></apexchart>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <percentage-card
                            title="Radionice"
                            :value="workshops"
                            :height="140" icon="uil-meeting-board"
                        ></percentage-card>
                    </div>
                    <div class="col-lg-6">

                        <percentage-card
                            title="Mentorske sesije"
                            :value="sessions"
                            :height="140"
                        ></percentage-card>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap">
            <h5 class="mr-2 mt-0 pt-0 attribute-label">Prikaži dodatnu statistiku i za:</h5>
            <div class="d-flex">
                <b-form-checkbox v-model="bInnovation" name="check-button" switch class="mr-2">
                    Inovativnost</b>
                </b-form-checkbox>
            </div>
            <div class="d-flex">
                <b-form-checkbox v-model="bTechDevelopment" name="check-button" switch class="mr-2">
                    Faza tehnološkog razvoja
                </b-form-checkbox>
            </div>
            <div class="d-flex">
                <b-form-checkbox v-model="bBusinessDevelopment" name="check-button" switch class="mr-2">
                    Faza poslovnog razvoja
                </b-form-checkbox>
            </div>
            <div class="d-flex">
                <b-form-checkbox v-model="bWayOfFinding" name="check-button" switch class="mr-2">
                    Način nalaženja
                </b-form-checkbox>
            </div>
            <div class="d-flex">
                <b-form-checkbox v-model="bIntellectualProperty" name="check-button" switch class="mr-2">
                    Intelektualna svojina
                </b-form-checkbox>
            </div>
            <div class="d-flex">
                <b-form-checkbox v-model="bBusinessBranch" name="check-button" switch class="mr-2">
                    Oblast proizvoda/usluge
                </b-form-checkbox>
            </div>
            <div class="d-flex">
                <b-form-checkbox v-model="bProductType" name="check-button" switch class="mr-2">
                    Tip proizvoda/usluge
                </b-form-checkbox>
            </div>

        </div>
        <div class="d-flex flex-wrap mt-2 mx-0 p-0">
            <find-criteria v-if="bInnovation"
                           title="KOLIKO JE INOVATIVAN VAŠ PROIZVOD/USLUGA?"
                           source="/analytics/splitOptions/how_innovative"
                           class="mr-3"
                           style="max-width: 335px">
            </find-criteria>
            <find-criteria v-if="bTechDevelopment"
                           title="Faza razvoja - Tehnološki razvoj"
                           source="/analytics/splitOptions/dev_phase_tech"
                           class="mr-3"
                           style="max-width: 335px">
            </find-criteria>
            <find-criteria v-if="bBusinessDevelopment"
                           title="Faza razvoja - Poslovni razvoj"
                           source="/analytics/splitOptions/dev_phase_business"
                           class="mr-3"
                           style="max-width: 335px">
            </find-criteria>
            <find-criteria v-if="bWayOfFinding" title="Kako ste nas našli?"
                           source="/analytics/splitOptions/howdiduhear"
                           class="mr-3"
                           style="max-width: 335px"></find-criteria>
            <find-criteria v-if="bIntellectualProperty"
                            title="Da li ste sprovodili neke aktivnosti u cilju zaštite prava intelektualne svojine?"
                            source="/analytics/splitOptions/intellectual_property"
                            class="mr-3"
                            style="max-width: 335px">
            </find-criteria>
            <find-criteria v-if="bBusinessBranch"
                           title="Kojoj oblasti pripada inovativni proizvod i/ili usluga koju razvijate?"
                           source="/analytics/splitOptions/how_innovative"
                           class="mr-3"
                           style="max-width: 335px">
            </find-criteria>
            <find-criteria v-if="bProductType"
                           title="Tip prozvoda ili usluge"
                           source="/analytics/splitOptions/product_type"
                           class="mr-3"
                           style="max-width: 335px">
            </find-criteria>
        </div>
    </div>
</template>

<script>
export default {
    name: "RaisingStartsDashboard",
    props: {
        program_type: { typeof: Number, default: 0 },
        token: { typeof: String, default: ''},
    },
    methods: {
        async getData() {
            let formData = new FormData();
            formData.append("program_type", this.program_type);
            formData.append("_token", this.token);
            await axios.post('/analytics/startupTypes', formData)
            .then(response => {
                this.startupCount = response.data.startupCount;
                this.companiesCount = response.data.companyCount;
            });

            await axios.get('/analytics/programStatuses/' + this.program_type)
            .then(response => {
                this.applied = response.data.applied;
                this.total = response.data.total;
                this.sent = this.total - this.applied;
                this.inProgram = response.data.inProgram;
                this.outOfProgram = response.data.outOfProgram;
            });

            await axios.post('/analytics/workshopAndSessionStats', formData)
            .then(response => {
                this.workshops = response.data.workshops;
                this.sessions = response.data.sessions;
            });

            await axios.get('/analytics/ntp/' + this.program_type)
            .then(response => {
                console.log('Chart data');
                console.log(response.data);
                this.chartValues.length = 0;
                this.chartOptions.labels.length = 0;
                for(let property in response.data) {
                    let item = response.data[property];
                    this.chartOptions.labels.push(item.ntp);
                    this.chartValues.push(item.count);
                }
            });
        }
    },
    async mounted() {
        await this.getData();
    },
    data() {
        return {
            startupCount: 0,
            companiesCount: 0,
            applied: 0,
            sent: 0,
            inProgram: 0,
            total: 0,
            outOfProgram: 0,
            workshops: 0,
            sessions: 0,
            chartOptions: {
                labels: []
            },
            chartValues: [],
            bInnovation: false,
            bTechDevelopment: false,
            bBusinessDevelopment: false,
            bWayOfFinding: false,
            bIntellectualProperty: false,
            bBusinessBranch: false,
            bProductType: false

        }
    }
}
</script>

<style scoped>

</style>
