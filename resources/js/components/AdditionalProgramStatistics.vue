<template>
    <div class="row">
        <div class="col-lg-3">
            <percentage-card
                title="Potpisali ugovor"
                :value="inProgram"
                :total="totalPrograms"
                subtitle="od prijavljenih"
                icon="uil-file-contract-dollar"></percentage-card>
        </div>
        <div class="col-lg-3">
            <percentage-card title="Van programa" :value="outOfProgram" :total="totalPrograms" subtitle="od prijavljenih" icon="uil-sign-out-alt"></percentage-card>
        </div>
        <div class="col-lg-3">
            <percentage-card title="Održano radionica" :value="workshops" icon="uil-meeting-board"></percentage-card>
        </div>
        <div class="col-lg-3">
            <percentage-card title="Održano mentorskih sesija" :value="sessions" ></percentage-card>
        </div>
    </div>
</template>

<script>
export default {
    name: "AdditionalProgramStatistics",
    props: {
        program_type: { typeof: Number, default: 0 },
        token: { typeof: String, default: ''}
    },
    methods: {
        async getData() {
            await axios.get('/analytics/programStatuses/' + this.program_type)
            .then(response => {
                 this.inProgram = response.data.inProgram;
                 this.outOfProgram = response.data.outOfProgram;
                 this.totalPrograms = response.data.total;
            });

            let formData = new FormData();
            formData.append("program_type", this.program_type);
            formData.append('_token', this.token);
            await axios.post('/analytics/workshopAndSessionStats', formData)
            .then(response => {
                console.log('Vraceno za dogadjaje');
                console.log(response.data);
                this.workshops = response.data.workshops;
                this.sessions = response.data.sessions;
            });
        }
    },
    async mounted() {
        await this.getData();
    },
    data() {
        return {
            inProgram: 0,
            outOfProgram: 0,
            totalPrograms: 0,
            workshops: 0,
            sessions: 0,
        }
    }
}
</script>

<style scoped>

</style>
