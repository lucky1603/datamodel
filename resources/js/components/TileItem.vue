<template>
    <div class="card shadow" style="width: 100px; height: 140px" @click="tileSelected">
        <div class="card-header p-0 border h-75">
            <img v-if="photo != ''" class="h-100 p-0" :src="photo">
            <img v-if="photo == ''" class="h-100 p-0" src="/images/custom/nophoto2.png">
        </div>
        <div class="card-body p-0 font-11 text-center bg-primary text-light align-items-center h-25">
            <span class="mt-2">{{ title }}</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "TileItem",
    props: {
        id: { typeof: Number, default: 0 },
        title: {typeof: String, default: 'Title'},
        subtitle : {typeof: String, default: 'Subtitle'},
        photo: {typeof: String, default: ''}
    },
    methods: {
        tileSelected() {
            this.$emit('tile-selected', this.id);
        }
    },
    data() {
        return {

        }
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>
