<template>
    <div class="card h-100 w-100">
        <div class="card-header">
            {{ title}}
        </div>
        <div class="card-body">
            <div class="row h-100">
                <div class="col-lg-5">
                    <div style="height: 60%">
                        <mentor-data :mentorid="mentorId"></mentor-data>
                    </div>
                    <div class="card" style="height: 35%">
                        <div class="card-header">Mentori</div>
                        <div class="card-body overflow-auto">
                            <div class="inbox-widget">
                                <div v-for="(mentor, index) in mentors" class="inbox-item" @click="selectMentor(mentor.id)">
                                    <div class="inbox-item-img">
                                        <img v-if="mentor.photo.length > 0" :src="mentor.photo" class="rounded-circle" alt="">
                                        <img v-if="mentor.photo.length == 0" src="/images/custom/nophoto2.png" class="rounded-circle" alt="">
                                    </div>
                                    <p class="inbox-item-author">{{ mentor.name }}</p>
                                    <p class="inbox-item-text">prazno</p>
                                    <p class="inbox-item-date">
                                        <a
                                            href="#"
                                            role="button"
                                            class="btn btn-sm btn-link text-info font-13"
                                            >
                                        <i class="mdi mdi-pencil"></i>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <session-editor-table :mentorid="this.mentorId" :programid="this.programid"></session-editor-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProgramSessions",
    components : {

    },
    props : {
        programid: { typeof: Number, default: 0 },
        title : { typeof: String, default: 'Sesije'}
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
        console.log(this.mentors);
        if(this.mentors.length > 0)
        {
            this.selectMentor(this.mentors[0].id);
        }
    }
}
</script>

<style scoped>

</style>
