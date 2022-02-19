<template>
    <div class="row border border-secondary" style="min-height: 100px">
        <div class="col-2 d-flex align-items-center justify-content-center bg-dark text-light">
            <span class="font-14 font-weight-light">{{ fileGroup.name }}</span>
        </div>
        <div class="col-10">
            <p v-if="fileGroup.note != null" class="m-1">{{ fileGroup.note}}</p>
            <hr v-if="fileGroup.note != null">
            <div class="d-flex flex-wrap pb-1">
                <file-item
                    v-for="(file, index) in fileGroup.files"
                    :key="index"
                    :filename="file.filename"
                    :filelink="file.filelink" class="m-1"></file-item>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "FileGroupViewer",
    props: {
        index: { typeof: Number, default: 0 },
        file_group: { typeof: Object, default: null }
    },
    data() {
        return {
            fileGroup: this.file_group
        }
    }
}
</script>

<style scoped>

</style>
