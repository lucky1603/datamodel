<template>
    <div class="card w-100" style="height: 100%">
        <div v-if="programs.length > 0" class="card-header bg-dark text-light">
            {{ title.toUpperCase()}}
        </div>
        <div v-if="programs.length > 0" class="card-body">
            <div class="row h-100">
                <div class="col-lg-5 h-100">
                    <div style="height: 70%">
                        <program-data
                            :programid="this.programId"
                            :usertype="usertype">
                        </program-data>
                    </div>
                    <div class="card shadow mt-2" style="height: 25%">
                        <div class="card-header"><span class="h4 attribute-label">KOMPANIJE</span></div>
                        <div class="card-body overflow-auto" style="height: 95%; display:flex; flex-wrap: wrap">
                            <round-item v-for="(program, index) in programs"
                                        :title="program.name"
                                        :id="program.id"
                                        :key="program.id"
                                        :photo="program.photo"
                                        class="mr-2"
                                        @tile-clicked="selectProgram(program.id)"></round-item>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 h-100">
                    <session-editor-table :mentorid="this.mentorid" :programid="this.programId"></session-editor-table>
                </div>
            </div>
        </div>
        <div v-else>Sinisa</div>
    </div>
</template>

<script>
export default {
    name: "MentorSessions",
    props: {
        mentorid: { typeof: Number, default: 0 },
        title : { typeof: String, default: 'Sesije'},
        usertype: { typeof: String, default: 'administrator'}
    },
    methods: {
        async getPrograms() {
            await axios.get(`/profiles/getProgramsForMentor/${this.mentorid}`)
                .then(response => {
                    console.log(response.data);
                    this.programs = response.data;

                });
        },
        selectProgram(programid) {
            Event.$emit('program-selected', programid);
            this.programId = programid;
            Event.$emit('tile-selected', programid);
        }
    },
    data() {
        return {
            programs : [],
            sessions : [],
            programId : null,
            session : null,
        }
    },
    async mounted() {
        await this.getPrograms();
        if(this.programs.length > 0) {
            this.selectProgram(this.programs[0].id);
        }
    }

}
</script>

<style scoped>

</style>
