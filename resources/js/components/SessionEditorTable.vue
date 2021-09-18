<template>
    <div class="h-100 w-100">
        <div class="card h-100 w-100 shadow" role="button">
            <div class="card-header">
                Sessions
            </div>
            <div class="card-body overflow-auto">
                <div v-for="(row, index) in rows" class="row">
                    <div v-for="session in row.cols" class="col-lg-2">
                        <tile-item :title="session.title" :id="session.id" @tile-selected="tileSelected"></tile-item>
                    </div>
                </div>
            </div>
        </div>
        <b-modal id="viewSituationModal" ref="viewSituationModal" size="lg" header-bg-variant="dark" header-text-variant="light">
            <template #modal-title >{{ viewsessiontitle }}</template>
            <span v-html="viewContent"></span>
            <template #modal-footer>
                <b-button variant="primary" @click="onOk">Prihvati</b-button>
                <b-button variant="light" @click="onCancel">Zatvori</b-button>
            </template>
        </b-modal>
    </div>

</template>

<script>
export default {
    name: "SessionEditorTable",
    props: {
        mentorid: 0,
        programid: 0,
        viewContent: null,
        addsessiontitle: { typeof: String, default: 'Dodaj novu sesiju'},
        viewsessiontitle: { typeof: String, default: 'Pregledaj sesiju'}
    },
    methods : {
        async getSessions() {
            this.rows.length = 0;
            await axios.get(`/mentors/sessions/${this.programId}/${this.mentorId}`)
                .then(response => {
                    this.sessions = response.data.values;
                    let row = null;
                    for(let i = 0; i < this.sessions.length; i++) {
                        if(i % 6 === 0) {
                            if(row != null) {
                                this.rows.push(row);
                            }

                            row = { cols: []};
                        }

                        row.cols[i % 6] = this.sessions[i];

                        if(i === this.sessions.length - 1)
                        {
                            this.rows.push(row);
                        }
                    }
                });

        },
        async viewSession() {
            let content = null;
            await axios.get(`/sessions/edit/${this.sessionId}`)
                .then(response => {
                    let content = $(response.data).find('form#mySessionEditForm').first().parent().html();
                    this.$refs['viewSituationModal'].show();
                    this.viewContent = content;
                });
        },
        mentorSelected(mentorid) {
            this.mentorId = mentorid;
            this.getSessions();
        },
        tileSelected(id) {
            console.log(`Tile ${id} selected`);
            this.sessionId = id;
            this.viewSession();
        },
        onOk() {
            const form = document.getElementById('mySessionEditForm');
            const data = new FormData(form);
            axios.post(`/sessions/edit`, data)
                .then(response => {
                    this.$refs['viewSituationModal'].hide();
                    this.getSessions();
                })
                .catch(error => {
                    console.log(error);
                    this.$refs['viewSituationModal'].hide();
                });
        },
        onCancel() {
            this.$refs['viewSituationModal'].hide();
        },
        closePreview() {
            this.$refs['viewSituationModal'].hide();
        }
    },
    data () {
        return {
            sessions : [],
            rows: [],
            mentorId : 0,
            programId : 0,
            sessionId : 0
        }
    },
    mounted() {
        if(this.programid != 0)
            this.programId = this.programid;

        if(this.mentorid != 0)
            this.mentorId = this.mentorid;

        if(this.mentorId != 0 && this.programId != 0)
            this.getSessions();

        Event.$on('mentor-selected', this.mentorSelected)
    }

}
</script>

<style scoped>

</style>
