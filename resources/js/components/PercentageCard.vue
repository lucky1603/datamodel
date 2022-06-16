<template>
    <div class="card tilebox-one shadow" :style="cardStyle">
        <div class="card-body">
            <i :class="iconClass"></i>
            <h6 class="text-uppercase mt-0">{{ title }}</h6>
            <h2 class="my-2" id="active-users-count">{{ value}}</h2>
            <p v-if="total > 0" class="mb-0 text-muted">
                <span :class="percentageClass">{{ percentage }} %</span>
                <span class="text-nowrap">{{subtitle }}</span>
            </p>
        </div> <!-- end card-body-->
    </div>
</template>

<script>
export default {
    name: "PercentageCard",
    props: {
        title: { typeof: String, default: "Title"},
        subtitle: { typeof: String, default: "Subtitle"},
        value: { typeof: Number, default: 0 },
        total: { typeof: Number, default: 0 },
        icon: { typeof: String, default: 'uil-users-alt'},
        height: { typeof:Number, default: 140 },
        percentage_color: { typeof: String, default: 'text-success'}
    },

    computed: {
        percentage() {
            if(this.total != 0) {
                return ((this.value / this.total) * 100).toFixed(0) ;
            }

            return 0;
        },
        percentageClass() {
            return `${this.percentage_color} mr-2`;
        },
        iconClass() {
            return `uil ${this.icon} float-right`;
        },
        cardStyle() {
            return {
                minHeight: this.height + 'px',
            }
        }
    },
    data() {
        return {
            value: 0,
            total: 0
        }
    }
}
</script>

<style scoped>

</style>
