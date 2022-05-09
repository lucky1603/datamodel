<template>
    <div class="h-100">
        <div class="card h-100 w-100">
            <div class="card-header card-header-light-background">
                <div class="d-inline-flex align-items-center">
                    <span class="h4 attribute-label">{{ title }}</span>
                </div>
                <b-button v-if="role === 'administrator'" class="float-right" variant="primary" :title="addprogramtitle" @click="showModal"><i class="uil-document"></i></b-button>
                <b-button v-if="role === 'administrator'" class="float-right mr-1" variant="primary-outline" :title="deleteprogramtitle" @click="deleteProgram"><i class="mdi mdi-delete"></i></b-button>
            </div>
            <div class="card-body font-12" style="height: 95%">
                <div v-if="this.programs.length == 0" class="d-flex align-items-center justify-content-center w-100 h-100">
                    <span class="h4 text-secondary">TRENUTNO NEMA DODELJENIH KOMPANIJA</span>
                </div>
                <b-table
                    ref="ProgramsTable"
                    v-if="programs.length > 0"
                    striped
                    small
                    sticky-header
                    select-mode="single"
                    hover
                    selectable
                    :items="programs"
                    :fields="fields"
                    head-variant="dark"
                    @row-selected="selected" style="height: 95%"></b-table>
            </div>
        </div>
        <b-modal id="addProgramModal" ref="addProgramModal" header-bg-variant="dark" header-text-variant="light" >
            <template #modal-title>{{ addprogramtitle }}</template>
            <span v-html="formContent"></span>
            <template #modal-footer>
                <b-button variant="primary" @click="onOk">Prihvati</b-button>
                <b-button variant="light" @click="onCancel">Odustani</b-button>
            </template>
        </b-modal>
    </div>

</template>

<script>
export default {
    name: "ProgramList",
    props : {
        mentorid : { typeof: Number, default: 0 },
        addroute: { typeof: String, default: '' },
        addprogramtitle: {typeof: String, default: 'Poveži'},
        deleteprogramtitle: {typeof: String, default: 'Obriši'},
        title : { typeof: String, default: '' },
        token : null,
        role: { typeof: String, default: '' }
    },
    methods: {
        async getPrograms() {
            let newRows = [];
            let newFields = [];
            await axios.get(`/mentors/programs/${this.mentorid}`)
                .then(response => {
                    response.data.values.forEach(item => {
                        newRows.push(item);
                    });

                    response.data.keys.forEach(item => {
                        newFields.push(item);
                    })
                });

            console.log('Novi redovi');
            console.log(newRows);
            console.log(newFields);

            this.fields = newFields;
            this.programs = newRows;

        },
        selected(rows) {
            this.program = rows[0];
            Dispecer.$emit('program-selected', this.program);
        },
        async showModal() {
            let content = null;
            await axios.get(`/mentors/addprogram/${this.mentorid}`)
                .then(response => {
                    let content = $(response.data).find('form#myFormAddMentorProgram').first().parent().html();
                    this.$refs['addProgramModal'].show();
                    this.formContent = content;
                    console.log(content);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        async onOk() {
            const form = $('form#myFormAddMentorProgram').first();
            const token = $(form).find('input[name="_token"]').val();
            // console.log(token);
            const data = form.serialize();
            await $.ajax({
                url: '/mentors/addprogram',
                data: data,
                method: "POST",
                headers: {
                    'X-CSRF-Token' : token
                },
                success: function(data) {
                    // console.log(data);
                }
            });

            this.$refs['addProgramModal'].hide();
            await this.getPrograms();
        },
        deleteProgram() {
            console.log(this.program);
            axios.get('/mentors/deleteProgram/'+ this.mentorid + '/' + this.program.id)
            .then(response => {
                console.log(response.data);
                location.reload();
            })
        },
        onCancel() {
            this.$refs['addProgramModal'].hide();
        }
    },
    data() {
        return {
            programs : [],
            fields: [],
            program : { typeof: Object, default: null },
            buttonRoute: {typeof: String, default: ''},
            buttonTitle: 'Ovo je proba',
            formContent: null,
        }
    },
    async mounted() {
        console.log(this.addprogramtitle);
        this.buttonTitle = this.addprogramtitle;
        this.buttonRoute = this.addroute;

        await this.getPrograms();

        if(this.programs.length > 0) {
            this.$refs['ProgramsTable'].selectRow(0);
        }
    },

}
</script>

<style scoped>

</style>
