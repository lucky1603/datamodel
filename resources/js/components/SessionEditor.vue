<template>
    <div class="h-100 w-100 mt-0 pt-2 pb-2">
        <div class="card h-50 w-100 shadow">
            <div class="card-header text-dark">
                <span  class="mb-0 mt-0 attribute-label">
                    {{ title.toUpperCase() }}<span v-if="program != null"> - </span><span v-if="program != null" class="font-weight-bold">{{ program.profile}}</span>
                </span>
                <b-button variant="primary" class="float-right" title="Dodaj novu sesiju" @click="addSession"><i class="mdi mdi-google-circles-group"></i></b-button>
                <b-button variant="primary-outline" class="float-right mr-1" title="Pregledaj podatke sesije" @click="viewSession"><i class="mdi mdi-view-agenda"></i></b-button>
            </div>
            <div class="card-body">
                <span v-if="program == null">No active programs</span>
                <b-table
                    v-if="program != null"
                    striped
                    hover
                    :items="sessions"
                    :fields="keys"
                    sticky-header="250px"
                    small
                    selectable
                    select-mode="single"
                    @row-selected="selected"></b-table>
            </div>
        </div>
        <b-modal id="addSituationModal" ref="addSituationModal" size="lg" header-bg-variant="dark" header-text-variant="light">
            <template #modal-title>{{ addsessiontitle }}</template>
            <span v-html="formContent"></span>
            <template #modal-footer>
                <b-button variant="primary" @click="onOk">Prihvati</b-button>
                <b-button variant="light" @click="onCancel">Odustani</b-button>
            </template>
        </b-modal>
        <b-modal id="viewSituationModal" ref="viewSituationModal" size="lg" header-bg-variant="dark" header-text-variant="light">
            <template #modal-title >{{ viewsessiontitle }}</template>
            <span v-html="viewContent"></span>
            <template #modal-footer>
                <b-button variant="primary" @click="onUpdate">Prihvati</b-button>
                <b-button variant="light" @click="closePreview">Zatvori</b-button>
            </template>
        </b-modal>
    </div>

</template>

<script>
export default {
    name: "SessionEditor",
    props: {
        mentorid: Number,
        title: { typeof: String, default: 'Mentorske sesije'},
        addsessiontitle: { typeof: String, default: 'Dodaj novu sesiju'},
        viewsessiontitle: { typeof: String, default: 'Pregledaj sesiju'}
    },
    methods : {
        async programSelected(program) {
            this.program = program;
            await this.getSessions(program.id)
        },
        async getSessions(programid) {
            await axios.get(`/mentors/sessions/${programid}/${this.mentorid}`)
                .then(response => {
                    console.log(response.data);
                    this.sessions = response.data.values;
                    this.keys = response.data.keys;
                });
        },
        async addSession() {
            let content = null;
            await axios.get(`/sessions/create/${this.program.id}/${this.mentorid}`)
                .then(response => {
                    let content = $(response.data).find('form#mySessionCreateForm').first().parent().html();
                    this.$refs['addSituationModal'].show();
                    this.formContent = content;
                });
        },
        selected(rows) {
            this.session = rows[0];
            console.log(`Selected ${this.session.id}`);
            Event.$emit('session-selected', this.session);
        },
        async viewSession() {
            let content = null;
            console.log(this.session);
            await axios.get(`/sessions/edit/${this.session.id}`)
                .then(response => {
                    let content = $(response.data).find('form#mySessionEditForm').first().parent().html();
                    this.$refs['viewSituationModal'].show();
                    this.viewContent = content;
                });
        },
        onOk() {
            const form = document.getElementById('mySessionCreateForm');
            const data = new FormData(form);
            axios.post(`/sessions/create`, data)
                .then(response => {
                    console.log(response.data);
                    this.$refs['addSituationModal'].hide();
                    this.getSessions(this.program.id);
                });

        },
        onUpdate() {
            const form = document.getElementById('mySessionEditForm');
            const data = new FormData(form);
            axios.post(`/sessions/edit`, data)
                .then(response => {
                    console.log(response.data);
                    this.$refs['addSituationModal'].hide();
                    this.getSessions(this.program.id);
                });
        },
        onCancel() {
            this.$refs['addSituationModal'].hide();
        },
        closePreview() {
            this.$refs['viewSituationModal'].hide();
        }
    },
    data() {
        return {
            program: null,
            sessions: [],
            keys: [],
            session: null,
            formContent: null,
            viewContent: null
        }
    },
    mounted() {
        console.log(`Mentor ID is ${this.mentorid}`);
        Event.$on('program-selected', this.programSelected);
    }
}
</script>

<style scoped>

</style>
