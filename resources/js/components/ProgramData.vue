<template>
    <div class="h-100 w-100">
        <div class="card shadow-sm h-100">
            <div class="card-header align-items-center card-header-light-background">
                <div class="d-inline-flex align-items-center">
                    <span class="h4 attribute-label">{{ program.name.value }} - {{ program.programName }}</span>
                </div>
                <b-button v-if="program != null && usertype === 'administrator'" variant="primary" class="float-right" title="Promeni podatke" @click="showModal"><i class="dripicons-user"></i></b-button>
            </div>
            <div class="card-body pb-0">
                <div v-if="program != null" class="h-100">
                    <div class="row h-100">
                        <div class="col-lg-4 h-100">
                            <img class="w-100" :src="program.profile_logo.value">
                        </div>
                        <div class="col-lg-8 h-100 overflow-auto">
                            <table class="table table-sm table-borderless table-striped">
                                <tbody class="font-12 text-dark">
                                <tr v-for="(value, name) in program" v-if="!['profile_logo', 'profile_background'].includes(name)">
                                    <td style="width: 40%" class="text-dark"><strong>{{ value.label }}</strong></td>
                                    <td>{{ value.value }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div v-else>
                    Nije izabran program
                </div>
            </div>
        </div>
        <b-modal id="editProfileModal" ref="editProfileModal" size="lg" header-bg-variant="dark" header-text-variant="light">
            <template #modal-title>{{ title }}</template>
<!--            <span v-html="formContent"></span>-->
            <profile-form :profile_id="this.program.profileId" ref="myProfileForm" action="/profiles/edit" :token="token"></profile-form>
            <template #modal-footer>
                <b-button variant="primary" @click="onOk">Prihvati</b-button>
                <b-button variant="light" @click="onCancel">Odustani</b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
export default {
    name: "ProgramData",
    props: {
        programid: 0,
        programname: '',
        aboutme: { typeof: String, default: 'About Me'},
        title: { typeof: String, default: 'Edit Program Data'},
        usertype: { typeof: String, default: 'administrator'},
        token: { typeof: String, default: ''}
    },
    methods : {
        getData() {
            if(this.programId != null && this.programId != 0) {
                axios.get(`/profiles/programdata/${this.programId}`)
                .then(response => {
                    this.program = response.data;
                    console.log(this.program);
                });
            }
        },
        programSelected(programid) {
            this.programId = programid;
            this.getData();
        },
        showModal() {
            axios.get(`/profiles/edit/${this.program.profileId}`)
                .then(response => {
                    this.$refs['editProfileModal'].show();
                    this.formContent = $(response.data).find('form#myForm').first().parent().html();
                });
        },
        onOk() {
            document.body.style.cursor  = 'wait'
            this.$refs.myProfileForm.onSubmit()
                .then(response => {
                    this.getData();
                    this.$refs.editProfileModal.hide();
                    document.body.style.cursor  = 'default';
                })
                .catch(errors => {
                    console.log(errors);
                    document.body.style.cursor  = 'default';
                });
        },
        onCancel() {
            this.$refs['editProfileModal'].hide();
        }
    },
    data() {
        return {
            program: null,
            programId: 0,
            keys : [],
            values : [],
            formContent : null
        };
    },
    mounted() {
        this.programId = this.programid;
        this.getData();
        Event.$on('program-selected', this.programSelected);
    }
}
</script>

<style scoped>

</style>
