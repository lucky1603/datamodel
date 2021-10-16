<template>
    <img :src="photo" :class="imgClass" width="50px" :style="imgStyle" :title="title" @click="imgClicked" style="border-width: 5px">
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
        }
    },
    props: {
        id : { typeof: Number, default: 0},
        photo : { typeof: String, default: ''},
        title : { typeof: String, default: 'Title'},
        width : { typeof: Number, default: 50 },
        height: { typeof: Number, default: 50 }
    },
    methods: {
        imgClicked() {
            this.$emit('tile-clicked', this.id);
        },
        imgSelected(id) {
            if(this.id === id) {
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
        Event.$on('tile-selected', this.imgSelected );
    }
}
</script>

<style scoped>

</style>
