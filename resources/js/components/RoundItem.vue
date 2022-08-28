<template>
    <div class="d-flex flex-column align-items-center" style="width: 100px; height: 70px">
        <div class="d-flex align-items-center justify-content-center">
            <img
                :src="imgSource"
                :class="imgClass"
                :style="imgStyle"
                :title="title"
                 @click="imgClicked">
        </div>

        <div :class="titleClass">
            <div style="font-size: 11px">{{ title }}</div>
            <div v-if="subtitle != ''" style="font-size: 9px">{{ subtitle }}</div>
        </div>
        <!-- <span :class="titleClass">
            {{ title }}
        </span>
        <span v-if="subtitle != ''" class="text-dark" style="font-size: 9px">{{ subtitle }}</span> -->
    </div>


</template>

<script>
export default {
    name: "RoundItem",
    computed: {
        imgClass() {
            if(this.isSelected)
                return "rounded rounded-circle shadow-lg";
            return "rounded rounded-circle shadow";
        },
        imgStyle() {
            if(this.isSelected) {
                return {
                    width: `${this.width}px`,
                    height: `${this.height}px`,
                    border: '2px solid #727cf5'
                }
            }

            return {
                width: `${this.width}px`,
                height: `${this.height}px`
            };
        },
        imgSource() {
            if(this.photo == '')
                return '/images/custom/nophoto2.png';
            return this.photo;
        },
        titleClass() {
            let c = "d-flex flex-column justify-content-center align-items-center text-center mt-1 p-1";
            if(this.isSelected) {
                return c + " bg-primary text-white";
            }

            return c;
        }
    },
    props: {
        id : { typeof: Number, default: 0},
        photo : { typeof: String, default: ''},
        title : { typeof: String, default: 'Title'},
        subtitle: { typeof: String, default: ''},
        width : { typeof: Number, default: 50 },
        height: { typeof: Number, default: 50 }
    },
    methods: {
        imgClicked() {
            this.$emit('tile-clicked', this.id);
        },
        imgSelected(id) {
            console.log('Dobio poruku ' + id);
            if(this.id == id) {
                this.isSelected = true;
            } else {
                this.isSelected = false;
            }
        }
    },
    data() {
        return {
            isSelected: { typeof: Boolean, default: false }
        }
    },
    mounted() {
        Dispecer.$on('tile-selected', this.imgSelected );
    }
}
</script>

<style scoped>

</style>
