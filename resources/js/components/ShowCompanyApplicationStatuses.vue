<template>
    <div>
        <div class="card tilebox-one">
            <div class="card-body">
                <i class="uil uil-file-alt float-right"></i>
                <h6 class="text-uppercase mt-0">Započete prijave</h6>
                <h2 class="my-2" id="active-users-count">{{ applied}}</h2>
                <p class="mb-0 text-muted">
                    <span class="text-success mr-2">{{ appliedPercentage }}%</span>
                    <span class="text-nowrap">od ukupnog broja kompanija</span>
                </p>
            </div> <!-- end card-body-->
        </div>
        <div class="card tilebox-one shadow">
            <div class="card-body">
                <i class="uil uil-file-check-alt float-right"></i>
                <h6 class="text-uppercase mt-0">Poslato prijava</h6>
                <h2 class="my-2" id="company">{{ sent }}</h2>
                <p class="mb-0 text-muted">
                    <span class="text-danger mr-2">{{ sentPercentage }}%</span>
                    <span class="text-nowrap">od ukupnog broja kompanija</span>
                </p>
            </div> <!-- end card-body-->
        </div>
    </div>
</template>

<script>
export default {
    name: "ShowCompanyApplicationStatuses",
    props: {
        program_type: {typeof: Number, default: 0},
    },
    computed: {
        appliedPercentage() {
            if(this.total == 0)
                return 0;

            return ((this.applied / this.total) * 100).toFixed(0) ;
        },
        sentPercentage() {
            if(this.total == 0)
                return 0;

            return ((this.sent / this.total) * 100).toFixed(0) ;
        }
    },
    methods: {
        async getData() {
            await axios.get(`/analytics/programStatuses/${this.program_type}`)
            .then(response => {
                this.applied = response.data.applied;
                this.sent = response.data.sent;
                this.total = response.data.total;
            });
        }
    },
    async mounted() {
        await this.getData();
    },
    data() {
        return {
            programType: this.program_id,
            applied: 0,
            sent: 0,
            total: 0
        }
    }
}
</script>

<style scoped>

</style>
