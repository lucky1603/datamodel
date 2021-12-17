<template>
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">{{ title }}</h4>
            <div v-if="item.count > 0" v-for="item in items">
                <h5 class="mb-1 mt-0 font-weight-normal">{{ item.text }}</h5>
                <div class="progress-w-percent">
                    <span class="progress-value font-weight-bold">{{ item.count}}</span>
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
    props: {
        title: { typeof: String, default: 'Title'},
        source: { typeof: String, default: '/analytics/howDidUHear'}
    },
    methods: {
        async getData() {
            await axios.get(this.source)
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
