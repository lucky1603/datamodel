<template>
    <div class="card shadow ribbon-box m-2" role="button" @click="cardClicked" style="width: 200px; height: 200px">
        <div class="card-body d-flex flex-column align-items-center justify-content-center">
            <div :class="ribbonClass"><span>{{ statustext}}</span></div>

            <img v-if="logo != ''" :src="logo" style="height: 75px">
            <img v-else :src="defaultLogo" style="height: 75px">
            <hr/>
            <span class="h5 ml-2">{{ title }}</span>


<!--            <div :class="imageContainerClass" style="display: flex; justify-content: center; align-items: center; overflow: hidden">-->
<!--                <img v-if="logo != ''" :src="logo" class="h-75">-->
<!--                <img v-else :src="defaultLogo" class="h-75">-->
<!--            </div>-->

<!--            <div class="h-50" style="display: flex; justify-content: center; align-items: center">-->
<!--                <span class="h5 ml-2">{{ title }}</span>-->
<!--            </div>-->


        </div>
    </div>
</template>

<script>
export default {
    name: "ProfileItem",
    computed : {
        currentImage() {
            switch (this.type) {
                case 2:
                    return '/images/custom/raisingstarts.png';
                case 5:
                    return '/images/custom/inkubacija.png'
                default:
                    return '/images/custom/unknown.png';
            }
        },
        imageContainerClass() {
            if(this.type == 2) {
                return 'h-50 bg-dark p-2';
            } else {
                return 'h-50 bg-secondary p-2';
            }
        },
        ribbonClass() {
            switch(this.status) {
                case 1:
                case 2:
                    return 'ribbon-two ribbon-two-info';
                case 3:
                    return 'ribbon-two ribbon-two-danger';
                case 4:
                    return 'ribbon-two ribbon-two-warning'
                case 5:
                    return 'ribbon-two ribbon-two-primary';
                case 6:
                    return 'ribbon-two ribbon-two-success';
                default:
                    return 'ribbon-two ribbon-two-dark';
            }
        },

    },
    props: {
        logo: '',
        background: '',
        type: { typeof: Number, default:1 },
        title:'',
        action: '#',
        id: 0,
        status: 0,
        statustext: ''
    },
    methods: {
        cardClicked() {
            Event.$emit('profile-clicked', this.id);
        }
    },
    data() {
        return {
            defaultLogo: '/images/custom/emptylogo.png',
            defaultBackground: '/images/custom/backdefault.jpg'
        }
    }
}
</script>

<style scoped>

</style>
