<template>
    <div>
        <div class="card tilebox-one">
            <div class="card-body">
                <i class="uil uil-users-alt float-right"></i>
                <h6 class="text-uppercase mt-0">Prijavljeno</h6>
                <h2 class="my-2" id="active-users-count">{{ applied}}</h2>
                <p class="mb-0 text-muted">
                    <span class="text-success mr-2">{{ appliedPercentage }}%</span>
                    <span class="text-nowrap">od ukupnog broja kompanija</span>
                </p>
            </div> <!-- end card-body-->
        </div>
        <div class="card tilebox-one shadow">
            <div class="card-body">
                <i class="uil uil-window-restore float-right"></i>
                <h6 class="text-uppercase mt-0">Poslato</h6>
                <h2 class="my-2" id="company">{{ sent}}</h2>
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
        program_id: {typeof: Number, default: 0},
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
            let program_id = this.program_id;
            await axios.get(`/analytics/applicationStatuses/${program_id}`)
            .then(response => {
                console.log(response.data);
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
