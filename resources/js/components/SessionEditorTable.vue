<template>
    <div>
        <div class="card shadow-sm h-100" role="button">
            <div class="card-header card-header-light-background">
                <div class="d-inline-flex align-items-center">
                    <span class="h4 attribute-label">{{ _('gui.sessions').toUpperCase() }}</span>
                </div>

                <b-button
                    class="float-right mx-1"
                    variant="primary"
                    @click="newSession1"
                    :title="_('gui.session_form_title_create')"><i class="dripicons-plus"></i></b-button>

                <b-button
                    class="float-right mx-1"
                    variant="outline-primary"
                    @click="editSession"
                    :title="_('gui.session_form_title_edit')"><i class="dripicons-pencil"></i></b-button>

                <b-button
                    class="float-right mx-1"
                    variant="outline-primary"
                    @click="cloneSession"
                    :title="_('gui.session_form_title_duplicate')"><i class="dripicons-duplicate"></i></b-button>

                <b-button
                    class="float-right mx-1"
                    variant="danger"
                    @click="deleteSession"
                    :title="_('gui.session_form_title_duplicate')"><i class="dripicons-cross"></i></b-button>
            </div>
            <div class="card-body overflow-auto" style="display: flex; flex-wrap: wrap">
                <tile-item
                    v-for="(session, index) in sessions"
                    :title="session.title"
                    :id="session.id"
                    :key="session.id"
                    :label="{ show: session.isFinished, type: 3, text: 'Završena'}"
                    :titleMaxLength = 40
                    class="mr-2" photo="/images/custom/sesije.png" @tile-clicked="tileClicked"></tile-item>
            </div>
        </div>

        <b-modal id="addSituationModal1" ref="addSituationModal1" size="lg" header-bg-variant="dark" header-text-variant="light">
            <template #modal-title>{{ addsessiontitle }}</template>
            <session-form
                ref="addSessionsForm"
                :mentor_id="mentorid"
                :program_id="programid"
                :session_id="sessionId"
                :create-new="true"
                :token="token" :test-input="testInput"
                action="/sessions/create" :user_type="user_type"></session-form>
            <template #modal-footer>
                <b-button variant="primary" @click="onAddSession">{{ _('gui.accept') }}</b-button>
                <b-button variant="light" @click="onCancelAddSession">{{ _('gui.cancel')}}</b-button>
            </template>
        </b-modal>
        <b-modal id="viewSituationModal1" ref="viewSituationModal1" size="lg" header-bg-variant="dark" header-text-variant="light">
            <template #modal-title>{{ viewsessiontitle }}</template>
            <session-form
                ref="editSessionsForm"
                :mentor_id="mentorid"
                :program_id="programid"
                :create-new="false"
                :token="token" action="/sessions/edit"
                :session_id="sessionId" :user_type="user_type"></session-form>
            <template #modal-footer>
                <b-button variant="primary" @click="onEditSession">{{ _('gui.accept') }}</b-button>
                <b-button variant="light" @click="onCancelEditSession">{{ _('gui.cancel')}}</b-button>
            </template>
        </b-modal>
        <b-modal id="confirmationDialog" ref="confirmationDialog" size="lg" header-bg-variant="dark" header-text-variant="light">
            <template #modal-title>POTVRDA</template>
            <p>Da li ste sigurni da hocete da obrisete sesiju {{ this.sessionId }}?</p>
            <template #modal-footer>
                <b-button variant="primary" @click="onOk">{{ _('gui.accept') }}</b-button>
                <b-button variant="light" @click="onCancel">{{ _('gui.cancel')}}</b-button>
            </template>
        </b-modal>
    </div>

</template>

<script>
import SessionForm from './SessionForm.vue';
export default {
  components: { SessionForm },
    name: "SessionEditorTable",
    props: {
        mentorid: 0,
        programid: 0,
        viewContent: null,
        formContent: null,
        addsessiontitle: { typeof: String, default: 'Dodaj novu sesiju'},
        viewsessiontitle: { typeof: String, default: 'Pregledaj sesiju'},
        token: { typeof: String, default: ''},
        session_id: { typeof: Number, default: 0},
        user_type: { typeof: String, default: 'administrator' }
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
        },
        async onOk() {
            var data = new FormData();
            data.append('_token', this.token);
            data.append('session_id', this.sessionId);
            await axios.post('/sessions/delete', data)
            .then(response => {
                this.getSessions();
                this.$refs['confirmationDialog'].hide();
            });

        },
        onCancel() {
            this.$refs['confirmationDialog'].hide();
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
        onAddCancel() {
            this.$refs['addSituationModal'].hide();
        },
        closePreview() {
            this.$refs['viewSituationModal'].hide();
        },
        async newSession1() {
            this.testInput = {};
            Dispecer.$emit('tile-selected', 0);
            this.$refs['addSituationModal1'].show();
        },
        async cloneSession() {
            await axios.get('/sessions/cloningData/' + this.sessionId)
            .then(response => {
                console.log(response.data);
                this.testInput = response.data;
            });

            this.$refs['addSituationModal1'].show();
        },
        editSession() {
            if(this.sessionId != 0) {
                this.$refs['viewSituationModal1'].show();
            }
        },
        deleteSession() {
            if(this.sessionId != 0) {
                this.$refs['confirmationDialog'].show();
            }
        },
        onAddSession() {
            this.$refs['addSessionsForm'].send()
            .then(response => {
                this.getSessions();
                this.$refs['addSituationModal1'].hide();
            })
            .catch(errors => {
                console.log(errors);
            });

        },
        onCancelAddSession() {
            this.$refs['addSituationModal1'].hide();
        },
        onEditSession() {
            this.$refs['editSessionsForm'].send()
            .then(response => {
                this.getSessions();
                this.$refs['viewSituationModal1'].hide();
            })
            .catch(errors => {
                console.log(errors);
            });
        },
        onCancelEditSession() {
            this.$refs['viewSituationModal1'].hide();
        }
    },
    data () {
        return {
            sessions : [],
            rows: [],
            mentorId : 0,
            programId : 0,
            sessionId : 0,
            testInput: {}
        }
    },
    mounted() {
        if(this.programid != 0)
            this.programId = this.programid;

        if(this.mentorid != 0)
            this.mentorId = this.mentorid;

        if(this.mentorId != 0 && this.programId != 0)
            this.getSessions();

        Dispecer.$on('mentor-selected', this.mentorSelected);
        Dispecer.$on('program-selected', this.programSelected);
    }

}
</script>

<style scoped>

</style>
