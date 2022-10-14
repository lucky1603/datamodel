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
                    <span class="h4 text-secondary">{{ _('gui.program_list_no_companies')}}</span>
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
        <b-modal id="addProgramModal" ref="addProgramModal" hide-footer header-bg-variant="dark" header-text-variant="light" >
            <template #modal-title>{{ addprogramtitle }}</template>
            <mentor-add-program :mentorId="mentorid" :token="token" @finished="closeDialog"></mentor-add-program>
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
            this.$refs['addProgramModal'].show();
        },
        closeDialog() {
            this.$refs['addProgramModal'].hide();
            this.getPrograms();
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
