<template>
    <div class="card">
        <div class="card-header bg-primary text-white">{{ _('gui.myprograms').toUpperCase() }}</div>
        <div class="card-body d-flex flex-wrap">
            <tile-item
                v-for="(program, index) in programs"
                :title="program.name"
                :label="{ text: program.statusText, show: true }"
                :key="index"
                :photo="getImageForProgramType(program.type)"
                :show_alert="program.reportAlert"
                alert_title="Vreme za slanje izveštaja"
                :id="program.id" class="mr-2 bg-secondary" @tile-clicked="tileClicked"></tile-item>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProfilePrograms",
    props: {
        profileId: {typeof: Number, default: 0},
        source: { typeof: String, default: '/profiles/programsForProfile' },
        user_type: { typeof: String, default: 'administrator' }
    },
    data() {
        return {
            programs: [],
        }
    },
    methods: {
        async getData() {
            await axios.get(this.source + '/' + this.profileId)
            .then(response => {
                console.log(response.data);
                this.programs.length = 0;
                for(let program in response.data) {
                    this.programs.push(response.data[program]);
                }
            });
        },
        getImageForProgramType(programType) {
            switch(programType) {
                case 2:
                    return '/images/custom/raisingstarts.png';
                case 5:
                    return '/images/custom/inkubacija.png';
                default:
                    return '/images/custom/noimage.png';
            }
        },
        tileClicked(tileId) {
            console.log(tileId);
            if(this.user_type == 'administrator') {
                window.location = '/programs/' + tileId;
            } else {
                window.location = "/programs/profile/" + tileId;
            }

        }
    },
    async mounted() {
        await this.getData();
    }
}
</script>

<style scoped>

</style>
