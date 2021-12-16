<template>
    <div class="card ribbon-box m-2 shadow" role="button" :style="tileStyle">
        <div class="card-body" @click="tileClicked">
            <div :class="ribbonClass">
                <span>{{ ribbonText}}</span>
            </div>
            <div class="row">
                <div class="col-8">
                    <h4 class="ml-2">{{ title }}</h4>
                </div>
                <div class="col-4 text-center">
                    <img :src="tilePhoto" alt="Tile Photo" style="width: 50px">
                    <div class="text-center">
                        <span class="font-10">{{ eventTypeText }}</span>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-12">
                    <p class="text-center font-12 font-weight-bold" >{{ where }}</p>
                    <p class="text-center font-11 attribute-label">{{ date }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "EventItem",
    computed: {
        tileStyle() {
            return {
                width: this.width + 'px',
                height: this.height + 'px',
            }
        },
        ribbonClass() {
            switch (this.status) {
                case 1:
                    return "ribbon-two ribbon-two-warning";
                case 2:
                    return "ribbon-two ribbon-two-info";
                case 3:
                    return "ribbon-two ribbon-two-success";
                default:
                    return "ribbon-two ribbon-two-secondary";
            }
        },
        ribbonText() {
            switch (this.status) {
                case 1:
                    return "Zakazan";
                case 2:
                    return "U toku";
                case 3:
                    return "Završen"
                default:
                    return "Otkazan";
            }
        },
        tilePhoto() {
            switch (this.type) {
                case 1:
                    return "/images/custom/workshop1.png";
                case 2:
                    return '/images/custom/training.png';
                default:
                    return '/images/custom/meeting.png';
            }
        },
        eventTypeText() {
            switch (this.type) {
                case 1:
                    return "RADIONICA";
                case 2:
                    return "TRENING";
                default:
                    return "DEŠAVANJE";
            }
        }
    },
    props: {
        width: {typeof: Number, default: 250},
        height: {typeof: Number, default: 200},
        status: {typeof: Number, default: 1},
        type: {typeof: Number, default: 1},
        title: {typeof: String, default: 'Title'},
        description: 'Description',
        date: {typeof:String, default: '10:00 AM'},
        where: {typeof: String, default: 'Where'},
        photo: '/images/custom/nophoto2.png',
        id: 0
    },
    methods: {
        tileClicked() {
            this.$emit('event-clicked', this.id)
        }
    }
}
</script>

<style scoped>

</style>
