<template>
    <div class="card shadow ribbon-box m-2" :style="cardStyle" @click="tileClicked">
        <div :class="myClass" style="height: 80%; display: flex; align-items: center; justify-content: center; overflow: hidden">
            <img ref="photo" class="h-100" :src="imageSource">
        </div>
        <div class="card-body p-0 h-25" style="display: flex; align-items: center; justify-content: center; height: 20%">
            <div v-if="this.label != null && this.label.show == true" :class="labelClass"><span>{{ label.text}}</span></div>
            <span :class="titleClass" style="font-family: 'Roboto Light'">{{ title }}</span>
        </div>
    </div>

<!--    <div class="d-flex flex-column align-items-center" style="width: 100px; height: 70px">-->
<!--        <img :src="imgSource" :class="imgClass" width="50px" :style="imgStyle" :title="title" @click="imgClicked" style="border-width: 5px">-->
<!--        <span class="font-10 attribute-label text-center">-->
<!--            {{ title }}-->
<!--        </span>-->
<!--    </div>-->
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
        titleClass() {
            if(this.isSelected) {
                return 'font-11 bg-primary text-light h-100 w-100 text-center align-content-center';
            }

            return 'font-10 w-100 h-100 text-center align-content-center attribute-label';
        },
        myClass() {
            const paddingStr = `p-${this.padding}`;
            if(this.isSelected)
                return "border text-center" + paddingStr + ' bg-light';

            return "border text-center" + paddingStr;
        },
        cardStyle() {
            return {
                height: this.height + 'px',
                width: this.width + 'px',
                overflow: 'hidden',
                margin: "5px"
            }
        },
        cardClass() {
            if(this.label != null && this.label.show) {
                return 'card shadow ribbon-box';
            }

            return 'card shadow';
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
        height: {typeof: Number, default: 140 },
        width: {typeof: Number, default: 100 },
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
        Event.$on('tile-selected', this.tileSelected );
    }
}
</script>

<style scoped>

</style>
