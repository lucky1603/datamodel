<template>
    <div class="card ribbon-box" :style="tileStyle">
        <div class="card-body">
            <div :class="ribbonClass">
                {{ ribbonText}}
            </div>
            <div class="row">
                <div class="col-8">
                    <h4>{{ title }}</h4>                    
                </div>
                <div class="col-4">
                    <img :src="tilePhoto" alt="Tile Photo" style="width: 50px">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    
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
                width: this.width,
                height: this.height
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
        }
    },
    props: {
        width: '250px',
        height: '200px',
        status: 1,
        type: 1,
        title: 'Title',
        description: 'Description',
        time: '10:00 AM',
        where: 'Where',
        photo: '/images/custom/nophoto2.png',
        id: 0
    }
}
</script>

<style scoped>

</style>
