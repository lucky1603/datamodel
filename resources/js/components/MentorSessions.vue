<template>
    <div class="card w-100" style="height: 100%">
        <div v-if="programs.length > 0" class="card-header bg-dark text-light">
            <div class="d-flex align-items-center">
                {{ title.toUpperCase()}}
            </div>
        </div>
        <div v-if="programs.length > 0" class="card-body">
            <div class="row h-100">
                <div class="col-lg-5 h-100">
                    <div style="height: 48vh">
                        <program-data
                            :programid="this.programId"
                            :usertype="usertype" :token="token">
                        </program-data>
                    </div>
                    <div class="card shadow-sm mt-2" style="height: 26vh">
                        <div class="card-header card-header-light-background">
                            <div class="d-inline-flex align-items-center">
                                <span class="h4 attribute-label">{{ _('gui.mentor_sessions_companies').toUpperCase()}}</span>
                            </div>
                        </div>
                        <div class="card-body overflow-auto" style="display:flex; flex-wrap: wrap">
                            <round-item v-for="(program, index) in programs"
                                :title="program.name"
                                :subtitle="program.programName"
                                :id="program.id"
                                :key="program.id"
                                :photo="program.photo"
                                class="mr-2"
                                @round-clicked="tileClicked(program.id)"></round-item>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <session-editor-table
                        :mentorid="this.mentorid"
                        :programid="this.programId"
                        :token="token"
                        :user_type="usertype"
                        style="height: 40vh; margin-bottom: 2vh"
                        :viewsessiontitle="_('gui.session_form_title_edit')"
                        :addsessiontitle="_('gui.session_form_title_create')"></session-editor-table>
                    <mentor-reports-explorer :mentorId="this.mentorid" style="height: 35vh"></mentor-reports-explorer>
                </div>
            </div>
        </div>
        <div v-else>
            <img src="/images/custom/classroom.jpg" style="position: absolute; left: 0px; top: 0px; width: 100%; opacity: 0.5">
            <div style="position: absolute; left: 100px; top: 100px">
                <p class="attribute-label" style="font-family: 'Roboto Light'; font-size: 38px; font-weight: bold">{{ _('gui.program_list_no_companies')}}</p>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "MentorSessions",
    props: {
        mentorid: { typeof: Number, default: 0 },
        title : { typeof: String, default: 'Sesije'},
        usertype: { typeof: String, default: 'administrator'},
        token: { typeof: String, default: ''},
        programid: { typeof: Number, default: 0 }
    },
    methods: {
        async getPrograms() {
            await axios.get(`/profiles/getProgramsForMentor/${this.mentorid}`)
                .then(response => {
                    console.log(response.data);
                    this.programs = response.data;

                });
        },
        async tileClicked(tileId) {
            await this.saveSelectedProgram(tileId);
            await this.selectProgram(tileId);
        },
        selectProgram(programid) {
            Dispecer.$emit('program-selected', programid);
            this.programId = programid;
            Dispecer.$emit('round-selected', programid);
            console.log('Selektovao program ' + programid);
        },
        async saveSelectedProgram(programId) {
            var data = new FormData();
            data.append('program_id', programId);
            data.append("_token", this.token);
            await axios.post('/mentors/saveSelectedProgram', data);
        },
        async getSelectedProgram() {
            var data = new FormData();
            data.append("_token", this.token);
            await axios.post('/mentors/getSelectedProgram', data)
            .then(response => {
                let programId = response.data;
                console.log('Selected Program');
                console.log(programId);


            });
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
        // await this.getSelectedProgram();
        if(this.programs.length > 0) {
            if(this.programid != 0) {
                this.selectProgram(this.programid);
            } else {
                this.selectProgram(this.programs[0].id);
            }
        }
        else {
            console.log('programi nema');
        }
    }

}
</script>

<style scoped>

</style>
