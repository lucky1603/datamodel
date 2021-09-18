<template>
    <div class="card h-100 w-100">
        <div class="card-header">
            {{ title}}
        </div>
        <div class="card-body">
            <div class="row h-100">
                <div class="col-lg-3 border border-warning">
                    <div class="h-75">

                    </div>
                    <div class="card h-25">
                        <div class="card-header">Mentori</div>
                        <div class="card-body">
                            <div class="inbox-widget">
                                <div v-for="(mentor, index) in mentors" class="inbox-item">
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
                <div class="col-lg-9 border border-danger">

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
        getMentors() {
            axios.get(`/mentors/forprogram/${this.programid}`)
            .then(response => {
                this.mentors = response.data;
            });
        }
    },
    data() {
        return {
            mentors: [],
            sessions: [],
            mentor: null,
            session: null,
        }
    },
    mounted() {
        this.getMentors();
    }
}
</script>

<style scoped>

</style>
