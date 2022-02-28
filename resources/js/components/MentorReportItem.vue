<template>
    <div class="card shadow-sm ribbon-box" role="button" @click="handleClick">
        <div class="card-header bg-primary text-white justify-content-center py-0" style="height: 25px">
            <span class="font-10">{{ date }}</span>
        </div>
        <div class="card-body py-0">
            <div class="ribbon-two ribbon-two-success"><span>Poslat</span></div>
            <div class="d-flex align-items-center justify-content-center" style="height: 80px;">
                <img src="/images/custom/chart-icon.png" style="width: 64px">
            </div>
            <div class="d-flex align-items-center justify-content-center attribute-label" style="height:20px; border-top: 1px solid #efefef">
                <span class="font-10 font-weight-bold">{{ name }}</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "MentorReportItem",
    props: {
        date: { typeof: String, default: '####-##-##' },
        sent: { typeof: Boolean, default: false },
        name: { typeof: String, default: 'Dummy' },
        link: { typeof: String, default: ''}
    },
    methods: {
        handleClick() {
            location.href = this.link;
        }
    }
}
</script>

<style scoped>

</style>
