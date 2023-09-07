<template>
    <div>
        <div class="card shadow-sm">
            <div class="card-header mt-1">
                <h4 class="header-title mt-1">{{ title }}</h4>
            </div>
            <div class="card-body">
                <div v-for="item in items">
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
    </div>
</template>

<script>
export default {
    name: 'DistributionFromTo',
    props: {
        from: { typeof: Date, default: null },
        to: { typeof: Date, default: null },
        token: { typeof: String, default: ''},
        source: {typeof: String, default: ''},
        title: { typeof: String, default: 'Title'},
    },
    watch: {
        from: function() {
            this.getData();
        },
        to: function() {
            this.getData();
        }
    },
    data() {
        return {
            items: [],
            total: 0
        };
    },

    async mounted() {
        await this.getData();
    },

    methods: {
        async getData() {
            let formData = new FormData();
            formData.append('_token', this.token);

            if(this.from != null) {
                formData.append('from', this.from);
            }

            if(this.to != null) {
                formData.append('to', this.to);
            }

            if(this.source != '') {
                await axios.post(this.source, formData)
                .then(response => {
                    console.log("u distribuciji");
                    console.log(response.data);
                    let items = response.data;
                    this.items = [];
                    for(let property in items) {
                        let item = items[property];
                        this.items.push({
                            text: item.text,
                            count: item.count
                        });

                        this.total += item.count;
                    }

                    if(this.items.length > 0 && this.total > 0) {
                        for (let i = 0; i < this.items.length; i++) {
                            this.items[i].percentage = ((this.items[i].count / this.total) * 100).toFixed(0);
                        }
                    }
                });
            }

        }
    },
};
</script>

<style lang="scss" scoped>

</style>
