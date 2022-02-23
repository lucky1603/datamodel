<template>
    <div class="h-100 w-100">
        <div class="card w-100 h-100 shadow" role="button">
            <div class="card-header">
                <span class="h4 attribute-label">SESIJE</span>
                <b-button class="float-right" variant="primary" @click="newSession"><i class="dripicons-user-group"></i></b-button>
            </div>
            <div class="card-body overflow-auto" style="display: flex; flex-wrap: wrap">
                <tile-item
                    v-for="(session, index) in sessions"
                    :title="session.title"
                    :id="session.id"
                    :key="session.id"
                    :label="{ show: session.isFinished, type: 3, text: 'Završena'}"
                    class="mr-2" photo="/images/custom/sesije.png"
                    @tile-clicked="tileClicked"></tile-item>

<!--                <session-item-->
<!--                    v-for="(session, index) in sessions"-->
<!--                    :title="session.title"-->
<!--                    :id="session.id"-->
<!--                    :key="session.id"-->
<!--                    :finished="session.isFinished"-->
<!--                    class="mr-2" photo="/images/custom/sesije.png"-->
<!--                    @tile-clicked="tileClicked"></session-item>-->

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
        <b-modal id="addSituationModal" ref="addSituationModal" size="lg" header-bg-variant="dark" header-text-variant="light">
            <template #modal-title>{{ addsessiontitle }}</template>
            <span v-html="formContent"></span>
            <template #modal-footer>
                <b-button variant="primary" @click="onAddOk">Prihvati</b-button>
                <b-button variant="light" @click="onAddCancel">Odustani</b-button>
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
        formContent: null,
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
        async newSession() {
            let content = null;
            await axios.get(`/sessions/create/${this.programId}/${this.mentorId}`)
                .then(response => {
                    let content = $(response.data).find('form#mySessionCreateForm').first().parent().html();
                    this.$refs['addSituationModal'].show();
                    this.formContent = content;
                });
        },
        mentorSelected(mentorid) {
            this.mentorId = mentorid;
            this.getSessions();
        },
        programSelected(programid) {
            this.programId = programid;
            this.getSessions();
        },
        tileClicked(id) {
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
        onAddOk() {
            const form = document.getElementById('mySessionCreateForm');
            const data = new FormData(form);
            axios.post(`/sessions/create`, data)
                .then(response => {
                    this.$refs['addSituationModal'].hide();
                    this.getSessions();
                })
                .catch(error => {
                    console.log(error);
                    this.$refs['addSituationModal'].hide();
                });
        },
        onCancel() {
            this.$refs['viewSituationModal'].hide();
        },
        onAddCancel() {
            this.$refs['addSituationModal'].hide();
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

        Event.$on('mentor-selected', this.mentorSelected);
        Event.$on('program-selected', this.programSelected);
    }

}
</script>

<style scoped>

</style>
