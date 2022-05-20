<template>
    <div>
        <b-form @submit.prevent="onSubmit">
            <b-form-group
                description="Izaberite jedan ili više programa ..."
                id="program-group"
                label="PROGRAMI"
                label-for="program">
                <b-form-select v-model="program" :options="programs" multiple :select-size="4"></b-form-select>
            </b-form-group>
            <b-input-group>
                <template #prepend>
                    <b-input-group-text><i class="uil-search"></i></b-input-group-text>
                </template>
                <b-form-input type="text" placeholder="Filtrirajte po imenu ..." v-model="name" @update="getPrograms"></b-form-input>
            </b-input-group>
            <div class="d-flex align-items-center justify-content-center mt-2">
                <b-button type="submit" variant="primary" size="sm" class="mr-2">Prihvati</b-button>
                <b-button type="button" variant="outline-primary" size="sm" @click="odustani">Odustani</b-button>
            </div>
        </b-form>
    </div>
</template>

<script>
export default {
    name: "MentorAddProgram",
    props: {
        mentorId: { typeof: Number, default: 0 },
        token: { typeof: String, default: ''}
    },
    methods: {
        async getPrograms() {
            let formData = new FormData();
            formData.append('name', this.name);
            await axios.post('/mentors/filterAddPrograms/' + this.mentorId, formData)
            .then(response => {
                this.programs = [];
                console.log(response.data);
                if(Array.isArray(response.data)) {
                    for(let program in response.data) {
                        this.programs.push(program);
                    }
                } else {
                    for(let property in response.data) {
                        this.programs.push(response.data[property]);
                    }
                }
            });
        },
        odustani() {
            this.$emit('finished');
        },
        onSubmit() {
            let formData = new FormData();
            this.program.forEach(program => {
                formData.append('program[]', program);
            });
            formData.append('_token', this.token);
            formData.append('mentorId', this.mentorId);
            axios.post('/mentors/addprogram', formData)
            .then(response => {
                console.log(response.data);
                this.$emit('finished');
            });
        }
    },
    async mounted() {
        await this.getPrograms();
    },
    data() {
        return {
            programs: [],
            program: [],
            name: ''
        }
    }
}
</script>

<style scoped>

</style>
