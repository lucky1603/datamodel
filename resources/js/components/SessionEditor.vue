<template>
    <div class="h-100 w-100 mt-0 pt-2 pb-2">
        <div class="card h-50 w-100 shadow">
            <div class="card-header text-dark">
                <span  class="mb-0 mt-0 attribute-label">
                    {{ title }}<span v-if="program != null"> za </span><span v-if="program != null" class="font-weight-bold">{{ program.profile}}</span>
                </span>
                <b-button variant="success" class="float-right" title="Dodaj novu sesiju" @click="addSession"><i class="mdi mdi-google-circles-group"></i></b-button>
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
                    select-mode="single"></b-table>
            </div>
        </div>
        <b-modal id="addSituationModal" ref="addSituationModal" size="lg" >
            <template #modal-title>{{ addsessiontitle }}</template>
            <span v-html="formContent"></span>
            <template #modal-footer>
                <b-button variant="primary" @click="onOk">Ok</b-button>
                <b-button variant="light" @click="onCancel">Cancel</b-button>
            </template>
        </b-modal>
    </div>

</template>

<script>
export default {
    name: "SessionEditor",
    props: {
        mentorid: Number,
        title: {typeof: String, default: 'Mentorske sesije'},
        addsessiontitle: {typeof:String, default: 'Dodaj novu sesiju'}
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
                    console.log(content);
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
        onCancel() {
            this.$refs['addSituationModal'].hide();
        }
    },
    data() {
        return {
            program: null,
            sessions: [],
            keys: [],
            session: null,
            formContent: null
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
