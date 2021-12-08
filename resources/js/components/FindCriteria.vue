<template>
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Kako ste nas našli?</h4>
            <div v-if="item.count > 0" v-for="item in items">
                <h5 class="mb-1 mt-0 font-weight-normal">{{ item.how }}</h5>
                <div class="progress-w-percent">
                    <span class="progress-value font-weight-bold">{{ item.percentage}}%</span>
                    <div class="progress progress-sm">
                        <div class="progress-bar" role="progressbar" :style="'width:' + item.percentage + '%;'" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "FindCriteria",
    methods: {
        async getData() {
            await axios.get('/analytics/howDidUHear')
                .then(response => {
                    this.items = response.data.items;
                    this.total = response.data.total;

                    if(this.items.length > 0 && this.total > 0) {
                        for (let i = 0; i < this.items.length; i++) {
                            this.items[i].percentage = ((this.items[i].count / this.total) * 100).toFixed(0);
                        }
                    }
                });
        },
        getItemPercentage(count) {
            if(this.total == 0) {
                return 0;
            }

            return (count / this.total).toFixed(0);
        },

    },
    async mounted() {
        await this.getData();
    },
    data() {
        return {
            items:[],
            total: 0
        }
    }
}
</script>

<style scoped>

</style>
