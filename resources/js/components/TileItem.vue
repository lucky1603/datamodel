<template>
    <div :class="cardClass" style="width: 100px; height: 120px" role="button" @click="tileClicked">
        <div class="card-body p-0">
            <div v-if="label != null && label.show" :class="labelClass"><span>{{ label.text }}</span></div>
            <div class="d-flex flex-column align-items-start justify-content-center w-100 h-100">
                <img :src="imageSource" class="w-100">
                <div class="d-flex align-items-center justify-content-center bg-dark w-100" style="height: 20px">
                    <span class="font-10 text-white">{{ title }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TileItem",
    computed: {
        imageSource() {
            if(this.photo == '')
                return '/images/custom/nophoto2.png';
            return this.photo;
        },
        cardClass() {
            if(this.label != null && this.label.show) {
                return 'card shadow-sm ribbon-box';
            }

            return 'card shadow-sm';
        },
        labelClass() {
            switch(this.label.type) {
                case 1:
                    return 'ribbon-two ribbon-two-danger';
                case 2:
                    return 'ribbon-two ribbon-two-primary';
                case 3:
                    return 'ribbon-two ribbon-two-success';
                case 4:
                    return 'ribbon-two ribbon-two-warning';
                default:
                    return 'ribbon-two ribbon-two-info';
            }
        }
    },
    props: {
        id: { typeof: Number, default: 0 },
        title: {typeof: String, default: 'Title'},
        subtitle : {typeof: String, default: 'Subtitle'},
        photo: {typeof: String, default: ''},
        padding: { typeof: Number, default: 0 },
        label: null
    },
    methods: {
        tileClicked() {
            this.$emit('tile-clicked', this.id);
        },

        tileSelected(id) {
            if(this.id === id) {
                this.isSelected = true;
            } else {
                this.isSelected = false;
            }
        }
    },
    data() {
        return {
            isSelected: false,
        }
    },
    mounted() {
        Dispecer.$on('tile-selected', this.tileSelected );
    }
}
</script>

<style scoped>

</style>
