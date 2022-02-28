<template>
<!--    <div class="card ribbon-box shadow" style="width: 350px; height: 200px; margin: 5px">-->
<!--        <div class="card-body">-->
<!--            <div :class="ribbonClass"><span>{{ typeText }}</span></div>-->
<!--            <div class="row">-->
<!--                <div class="col-5">-->
<!--                    <img :src="imagelink" style="width: 100%">-->
<!--                </div>-->
<!--                <div class="col-7 text-center">-->
<!--                    <div style="height: 80%">-->
<!--                        <a :href="link" class="h4 mt-0 mb-4">{{ title }}</a>-->
<!--                    </div>-->

<!--                    <div style="height: 20%">-->
<!--                        <a :href="'mailto://' + email" target="_blank">{{ email }}</a>-->
<!--                        <p>{{ phone }}</p>-->
<!--                    </div>-->

<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

    <div class="card shadow m-2" style="width: 180px; height: 250px" role="button" @click="cardClicked">
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
            return "ribbon-two ribbon-two-success";
        },
        headerClass() {
            if(this.type == 1)
                return "card-header bg-info text-white d-flex align-items-center justify-content-center py-1";
            return "card-header bg-success text-white d-flex align-items-center justify-content-center py-1";
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
        type: { typeof: Number, default: 0}
    },
    mounted() {
        this.typeText = this.type == 1 ? 'POSLOVNI' : 'TEHNIČKI';
    },
    data() {
        return {
            link : '/mentors/profile/' + this.id,
            typeText: {typeof: String, default: ''}
        }
    }
}
</script>

<style scoped>

</style>
