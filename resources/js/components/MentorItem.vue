<template>
    <div class="card shadow m-2" :style="cardStyle" role="button" @click="cardClicked">
        <div :class="headerClass">
            <span class="font-11 font-weight-bold">{{ typeText }}</span>
        </div>
        <div class="card-body p-0">
            <div class="d-flex flex-column h-100 w-100">
                <div class="w-100 overflow-hidden text-center my-1" style="height: 80%">
                    <img :src="imagelink" class="h-100">
                </div>
                <div class="d-flex align-items-center justify-content-center w-100" style="height: 20%; border-top: 1px solid #efefef">
                    <span class="font-11 attribute-label font-weight-bold">{{ title }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "MentorItem",
    computed: {
        ribbonClass() {
            if(this.type == 1)
                return "ribbon-two ribbon-two-info";
            else if(this.type == 2)
                return "ribbon-two ribbon-two-success";
            else
                return "ribbon-two ribbon-two-warning";
        },
        headerClass() {
            if(this.type == 1)
                return "card-header bg-info text-white d-flex align-items-center justify-content-center py-1";
            else if(this.type == 2)
                return "card-header bg-success text-white d-flex align-items-center justify-content-center py-1";
            else
                return "card-header bg-warning text-white d-flex align-items-center justify-content-center py-1";
        },
        typeText() {
            switch(this.type) {
                case 1:
                    return "BUSINESS";
                case 2:
                    return "TECH";
                default:
                    return "SPECIALIST";
            }
        },
        cardStyle() {
            return {
                width: this.width,
                height: this.height
            }
        }
    },
    methods: {
        cardClicked() {
            location.href = this.link;
        }
    },
    props: {
        id: {typeof: Number, default: 0},
        imagelink: { typeof: String, default: '/images/custom/nophoto2.png' },
        title: { typeof: String, default: ''},
        email: { typeof: String, default: ''},
        phone: { typeof: String, default: ''},
        type: { typeof: Number, default: 0},
        width: { typeof: String, default: '180px'},
        height: { typeof: String, default: '250px' }
    },

    data() {
        return {
            link : '/mentors/profile/' + this.id,
        }
    }
}
</script>

<style scoped>

</style>
