<template>
    <div class="card shadow m-2" :style="cardStyle" @click="tileClicked">
        <div style="height: 80%; display: flex; align-items: start; justify-content: center; overflow: hidden; ">
            <img ref="photo" class="w-100" :src="imageSource">
            <img ref="status" :src="finishedIconSource" style="position: absolute; right: 4px; top: 4px"/>
        </div>
        <div class="card-body p-0 h-25" style="display: flex; align-items: center; justify-content: center; height: 20%">
            <span :class="titleClass" style="font-family: 'Roboto Light'">{{ title }}</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "SessionItem",
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
                // margin: "5px"
            }
        },
        finishedIconSource() {
            if(this.finished)
                return '/images/custom/zavrsena-sesija.png';
            return '/images/custom/zakazana-sesija.png';
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
        label: null,
        finished: { typeof: Boolean, default: false }
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


