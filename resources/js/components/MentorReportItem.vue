<template>
    <div class="shadow d-flex flex-column" style="width: 100px; height: 140px; overflow: hidden" role="button" @click="handleClick">
        <div class="d-flex align-items-center justify-content-center bg-info text-white">
            <span class="font-10">{{ date }}</span>
        </div>
        <img src="/images/custom/Custom-reports-icon.png" style="width: 100px">
        <div class="d-flex align-items-center justify-content-center bg-info text-white">
            <span class="font-10">{{ name }}</span>
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
