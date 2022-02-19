<template>
<!--    <div class="shadow d-flex flex-column" style="width: 100px; height: 100px">-->
<!--        <div class="d-flex align-items-center justify-content-center" style="height: 50%">-->
<!--            <h3>.{{ extension }}</h3>-->
<!--        </div>-->
<!--        <div class="bg-dark text-white d-flex align-items-center justify-content-center" style="height: 50%; padding: 2px">-->
<!--            <span class="font-10">{{ filename }}</span>-->
<!--        </div>-->
<!--    </div>-->

    <div class="d-flex justify-content-start m-1" style="height: 25px" role="button" @click="followLink">
        <img src="/images/custom/icons/Word-icon.png" style="height: 24px; width: 24px">
        <span class="ml-1 mt-1 font-11 attribute-label">{{ filename }}</span>
    </div>
</template>

<script>
export default {
    name: "FileItem",
    props: {
        filename: { typeof: String, default: ''},
        filelink: { typeof: String, default: ''},

    },
    methods: {
        parseName() {
            let parts = this.filename.split('.');
            this.name = parts[0];
            this.extension = parts[1];
        },
        followLink() {

            // location.href = this.filelink;
            window.open(this.filelink, '_blank');
        }
    },
    mounted() {
        this.parseName();
    },
    data() {
        return {
            name: '',
            extension: '',
            type: ''
        }
    }
}
</script>

<style scoped>

</style>
