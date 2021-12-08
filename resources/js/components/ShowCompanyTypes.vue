<template>
    <div>
        <div class="card tilebox-one">
            <div class="card-body">
                <i class="uil uil-users-alt float-right"></i>
                <h6 class="text-uppercase mt-0">Startapovi</h6>
                <h2 class="my-2" id="active-users-count">{{ startupCount}}</h2>
                <p class="mb-0 text-muted">
                    <span class="text-success mr-2">{{ startupPercentage }}%</span>
                    <span class="text-nowrap">od ukupnog broja prijavljenih</span>
                </p>
            </div> <!-- end card-body-->
        </div>
        <div class="card tilebox-one shadow">
            <div class="card-body">
                <i class="uil uil-window-restore float-right"></i>
                <h6 class="text-uppercase mt-0">Kompanije</h6>
                <h2 class="my-2" id="company">{{ companyCount}}</h2>
                <p class="mb-0 text-muted">
                    <span class="text-danger mr-2">{{ companyPercentage }}%</span>
                    <span class="text-nowrap">od ukupnog broja prijavljenih</span>
                </p>
            </div> <!-- end card-body-->
        </div>
    </div>

</template>

<script>
export default {
    name: "ShowCompanyTypes",
    methods: {
        async getData() {
            await axios.get('/analytics/startupTypes')
                .then(response => {
                    let result = response.data;
                    this.startupCount = result.startupCount;
                    this.companyCount = result.companyCount;
                    this.total = result.total;
                });
        }
    },
    computed: {
        startupPercentage() {
            if(this.total == 0)
                return 0;

            return ((this.startupCount / this.total) * 100).toFixed(2) ;
        },
        companyPercentage() {
            if(this.total == 0)
                return 0;

            return ((this.companyCount / this.total) * 100).toFixed(2) ;
        }
    },
    async mounted() {
        await this.getData();
    },
    data() {
        return {
            startupCount : 0,
            companyCount : 0,
            total: 1.0,
        }
    }

}
</script>

<style scoped>

</style>
