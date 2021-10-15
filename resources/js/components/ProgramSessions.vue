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
                    <div class="card shadow mt-2" style="height: 43%">
                        <div class="card-header"><span class="h4 attribute-label">MENTORI</span></div>
                        <div class="card-body overflow-auto" style="height: 95%; display:flex; flex-wrap: wrap">
<!--                            <div class="inbox-widget">-->
<!--                                <div v-for="(mentor, index) in mentors" class="inbox-item" @click="selectMentor(mentor.id)">-->
<!--                                    <div class="inbox-item-img">-->
<!--                                        <img v-if="mentor.photo.length > 0" :src="mentor.photo" class="rounded-circle" alt="">-->
<!--                                        <img v-if="mentor.photo.length == 0" src="/images/custom/nophoto2.png" class="rounded-circle" alt="">-->
<!--                                    </div>-->
<!--                                    <p class="inbox-item-author">{{ mentor.name }}</p>-->
<!--                                    <p class="inbox-item-text">prazno</p>-->
<!--                                    <p class="inbox-item-date">-->
<!--                                        <a-->
<!--                                            href="#"-->
<!--                                            role="button"-->
<!--                                            class="btn btn-sm btn-link text-info font-13"-->
<!--                                            >-->
<!--                                        <i class="mdi mdi-pencil"></i>-->
<!--                                        </a>-->
<!--                                    </p>-->
<!--                                </div>-->
<!--                            </div>-->
                            <tile-item v-for="(mentor, index) in mentors"
                                       :title="mentor.name"
                                       :id="mentor.id"
                                       :key="mentor.id"
                                       :photo="mentor.photo"
                                       class="mr-2"
                                       @tile-clicked="selectMentor(mentor.id)">

                            </tile-item>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 h-100">
                    <session-editor-table :mentorid="this.mentorId" :programid="this.programid"></session-editor-table>
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
            Event.$emit('mentor-selected', mentorid);
            this.mentorId = mentorid;
            Event.$emit('tile-selected', mentorid);
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
