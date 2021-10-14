<template>
    <div :class="cardClass" :style="cardStyle" @click="tileClicked">
        <div :class="myClass" style="height: 80%; display: flex; align-items: center; justify-content: center">
            <img ref="photo" class="h-100" :src="imageSource">
        </div>
        <div class="card-body p-0 h-25" style="display: flex; align-items: center; justify-content: center; height: 20%">
            <div v-if="this.label.show" :class="labelClass"><span>{{ label.text}}</span></div>
            <span class="font-11" style="font-family: 'Roboto Light'">{{ title }}</span>
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
        myClass() {
            const paddingStr = `p-${this.padding}`;
            if(this.isSelected)
                return "card-header border text-center" + paddingStr + ' bg-light';

            return "card-header border text-center" + paddingStr;
        },
        cardStyle() {
            return {
                height: this.height + 'px',
                width: this.width + 'px'
            }
        },
        cardClass() {
            if(this.label.show) {
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
        label: {typeof: Object, default: { show: false, type: 1, text: 'Example'} }
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
