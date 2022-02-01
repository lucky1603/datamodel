<template>
    <div class="card ribbon-box m-2 shadow" role="button" :style="tileStyle">
        <div class="card-body" @click="tileClicked">
            <div :class="ribbonClass">
                <span>{{ ribbonText}}</span>
            </div>
            <div v-if="is_client" style="height: 25px; display: flex; justify-content: right; align-items: start">
                <img :src="attendanceIcon" :title="attendanceText" style="width: 16px; height: 16px">
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
            <div>
                <span class="font-10 font-italic text-dark">{{ description }}</span>
            </div>
            <hr style="margin-bottom: 2px"/>
            <div class="row p-0">
                <div class="col-12 p-0">
                    <p class="text-center font-12 font-weight-bold bg-light text-dark m-0 border border-secondary p-1" >{{ where }}</p>
                    <b-row class="m-0 border-bottom border-secondary" >
                        <b-col class="bg-dark text-light d-flex justify-content-center"><span class="font-10">{{ date}}</span></b-col>
                        <b-col class="bg-light text-dark d-flex justify-content-center"><span class="font-10">{{ time }} h</span></b-col>
                        <b-col class="bg-dark text-light d-flex justify-content-center"><span class="font-10">{{ duration}} {{ duration_unit}}</span></b-col>
                    </b-row>
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
                    return "/images/custom/radionice.png";
                case 2:
                    return '/images/custom/sesije.png';
                default:
                    return '/images/custom/meetup.png';
            }
        },
        eventTypeText() {
            switch (this.type) {
                case 1:
                    return "RADIONICA";
                case 2:
                    return "SESIJA";
                default:
                    return "MEETUP";
            }
        },
        attendanceIcon() {
            switch(this.attendance) {
                case 1:
                    return '/images/custom/obavesten.png';
                case 2:
                    return '/images/custom/pristustvovaoje.png';
                default:
                    return '/images/custom/nijeprisustvovao.png';

            }
        },
        attendanceText() {
            switch(this.attendance) {
                case 1:
                    return 'Obavešten';
                case 2:
                    return 'Prisustvovao je';
                default:
                    return 'Nije prisustvovao';
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
        id: 0,
        is_client: { typeof: Boolean, default: false },
        attendance: { typeof: Number, default: 1 },
        time: { typeof: String, default: '10:00 AM' },
        duration: { typeof: Number, default: 0},
        duration_unit: { typeof: Number, default: 'm'}
    },
    methods: {
        tileClicked() {
            this.$emit('event-clicked', this.id)
        },

    }
}
</script>

<style scoped>

</style>
