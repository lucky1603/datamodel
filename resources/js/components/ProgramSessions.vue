<template>
    <div class="card w-100" style="height: 95%">
        <div v-if="mentors.length > 0" class="card-header bg-dark text-light">
            {{ title.toUpperCase()}}
        </div>
        <div v-if="mentors.length > 0" class="card-body">
            <div class="row h-100">
                <div class="col-lg-5 h-100">
                    <div style="height: 55%">
                        <mentor-data :mentorid="mentorId" aboutme="PODACI O MENTORU" :usertype="usertype"></mentor-data>
                    </div>
                    <div class="card shadow mt-2" style="height: 26vh">
                        <div class="card-header card-header-light-background">
                            <div class="d-inline-flex align-items-center">
                                <span class="h4 attribute-label">MENTORI</span>
                            </div>
                        </div>
                        <div class="card-body overflow-auto" style="display:flex; flex-wrap: wrap">
<!--                            <tile-item v-for="(mentor, index) in mentors"-->
<!--                                       :title="mentor.name"-->
<!--                                       :subtitle="mentor.program"-->
<!--                                       :id="mentor.id"-->
<!--                                       :key="mentor.id"-->
<!--                                       :photo="mentor.photo"-->
<!--                                       class="mr-2"-->
<!--                                       @tile-clicked="selectMentor(mentor.id)">-->

<!--                            </tile-item>-->

                            <round-item v-for="(mentor, index) in mentors"
                                        :title="mentor.name"
                                        :subtitle="mentor.program"
                                        :id="mentor.id"
                                        :key="mentor.id"
                                        :photo="mentor.photo"
                                        class="mr-2"
                                        @tile-clicked="selectMentor(mentor.id)"></round-item>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 h-100">
                    <session-editor-table :mentorid="this.mentorId" :programid="this.programid" style="height: 73vh"></session-editor-table>
                </div>
            </div>
        </div>
        <div v-else class="card-body">
            <img src="/images/custom/sizif.jpg" style="position: absolute; left: 0px; top: 0px; width: 100%; opacity: 0.3">
            <div style="position: absolute; left: 100px; top: 100px">
                <p class="text-light" style="font-family: 'Roboto Light'; font-size: 38px; font-weight: bold">NEMA IZABRANIH MENTORA</p>
            </div>
            <button type="button" class="btn btn-sm btn-primary rounded-pill" style="position: absolute; left: 45%; top: 50%">DODAJ MENTORA</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProgramSessions",
    props : {
        programid: { typeof: Number, default: 0 },
        title : { typeof: String, default: 'Sesije'},
        usertype: { typeof: String, default: 'administrator'}
    },
    methods: {
        async getMentors() {
            await axios.get(`/mentors/forprogram/${this.programid}`)
            .then(response => {
                this.mentors = response.data;
            });
        },
        selectMentor(mentorid) {
            Dispecer.$emit('mentor-selected', mentorid);
            this.mentorId = mentorid;
            Dispecer.$emit('tile-selected', mentorid);
        }
    },
    data() {
        return {
            mentors: [],
            sessions: [],
            mentorId: null,
            session: null,
        }
    },
    async mounted() {
        await this.getMentors();
        if(this.mentors.length > 0)
        {
            this.selectMentor(this.mentors[0].id);
        }

    }
}
</script>

<style scoped>

</style>
