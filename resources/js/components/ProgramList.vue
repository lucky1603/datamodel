<template>
    <div>
        <div class="card h-100 w-100">
            <div class="card-header text-dark">
                <span class="mb-0 mt-0 h5 attribute-label">{{ title }}</span>
                <b-button class="float-right" variant="success" :title="addprogramtitle" @click="showModal"><i class="uil-document"></i></b-button>
                <b-button class="float-right mr-1" variant="danger" :title="deleteprogramtitle"><i class="mdi mdi-delete"></i></b-button>
            </div>
            <div class="card-body font-12">
                <p v-if="this.programs.length == 0">There are currently no programs attached</p>
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
                    @row-selected="selected"></b-table>
            </div>
        </div>
        <b-modal id="addProgramModal" ref="addProgramModal" >
            <template #modal-title>{{ addprogramtitle }}</template>
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
    name: "ProgramList",
    props : {
        mentorid : {typeof: Number, default: 0},
        addroute: {typeof: String, default: ''},
        addprogramtitle: {typeof: String, default: 'Poveži'},
        deleteprogramtitle: {typeof: String, default: 'Obriši'},
        title : {typeof: String, default: ''},
        token : null
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
            Event.$emit('program-selected', this.program);
        },
        async showModal() {
            let content = null;
            await axios.get(`/mentors/addprogram/${this.mentorid}`)
                .then(response => {
                    let content = $(response.data).find('form#myFormAddMentorProgram').first().parent().html();
                    this.$refs['addProgramModal'].show();
                    this.formContent = content;
                    console.log(content);
                });
        },
        async onOk() {
            const form = $('form#myFormAddMentorProgram').first();
            const token = $(form).find('input[name="_token"]').val();
            console.log(token);
            const data = form.serialize();
            await $.ajax({
                url: '/mentors/addprogram',
                data: data,
                method: "POST",
                headers: {
                    'X-CSRF-Token' : token
                },
                success: function(data) {
                    console.log(data);
                }
            });

            this.$refs['addProgramModal'].hide();
            await this.getPrograms();
        },
        deleteProgram(programId) {

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
