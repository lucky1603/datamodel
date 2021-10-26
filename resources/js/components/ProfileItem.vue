<template>
    <div class="card shadow ribbon-box h-100 w-100 m-2" role="button" @click="cardClicked">
        <div class="card-body p-0 h-100">
            <div :class="ribbonClass"><span>{{ statustext}}</span></div>

                <div :class="imageContainerClass" style="display: flex; justify-content: center; align-items: center">
                    <img :src="currentImage" class="h-100">
                </div>

                <div class="h-50" style="display: flex; justify-content: center; align-items: center">
                    <img v-if="logo != ''" :src="logo" class="h-75">
                    <img v-else :src="defaultLogo" class="h-75">
                    <span class="h4 ml-2">{{ title }}</span>
                </div>

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
                    return 'ribbon-two ribbon-two-primary';
                case 3:
                    return 'ribbon-two ribbon-two-info';
                case 4:
                    return 'ribbon-two ribbon-two-success'
                case 5:
                    return 'ribbon-two ribbon-two-danger';
                default:
                    return 'ribbon-two ribbon-two-success';
            }
        },

    },
    props: {
        logo: '',
        type: { typeof: Number, default:1 },
        title:'Empty',
        action: '#',
        id: 0,
        status: 1,
        statustext: 'sinisa'
    },
    methods: {
        cardClicked() {
            Event.$emit('profile-clicked', this.id);
        }
    },
    data() {
        return {
            defaultLogo: '/images/custom/emptylogo.png',
        }
    }
}
</script>

<style scoped>

</style>
