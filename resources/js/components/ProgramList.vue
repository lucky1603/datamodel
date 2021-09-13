<template>
    <div class="card h-100 w-100">
        <div class="card-header text-dark">
            <span class="mb-0 mt-0 h5 attribute-label">{{ title }}</span>
            <a
                class="btn btn-success btn-sm float-right"
                :href="buttonRoute"
                :title="buttonTitle"
                id="btnAddProgram" ><i class="uil-document"></i></a>
        </div>
        <div class="card-body font-12">
            <p v-if="this.programs.length == 0">There are currently no programs attached</p>
            <b-table
                v-if="programs.length > 0"
                striped
                small
                sticky-header
                select-mode="single"
                hover
                selectable
                :items="programs"
                :fields="fields"
                @row-selected="selected"></b-table>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProgramList",
    props : {
        mentorid : {typeof: Number, default: 0},
        addroute: {typeof: String, default: ''},
        addprogramtitle: {typeof: String, default: ''},
        title : {typeof: String, default: ''}
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
            let program = rows[0];
            Event.$emit('program-selected', program.id);
        }
    },
    data() {
        return {
            programs : [],
            fields: [],
            program : { typeof: Object, default: null },
            buttonRoute: {typeof: String, default: ''},
            buttonTitle: 'Ovo je proba'
        }
    },
    mounted() {
        console.log(this.addprogramtitle);
        this.buttonTitle = this.addprogramtitle;
        this.buttonRoute = this.addroute;

        this.getPrograms();
    },

}
</script>

<style scoped>

</style>
