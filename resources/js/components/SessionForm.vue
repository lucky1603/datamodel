<template>
    <div>
        <form ref="session_form" method="POST" enctype="multipart/form-data" @submit.prevent="send">
            <b-form-group
                id="session_title_group"
                label="Naslov sesije"
                label-for="session_title">
                <b-form-input
                    id="session_title"
                    v-model="form.session_title"
                    type="text"
                    placeholder="Unesite naslov sesije"
                    required>
                </b-form-input>
                <span v-if="errors.session_title" class="text-danger">{{ errors.session_title}}</span>
            </b-form-group>
            <div class="row">
                <div class="col-lg-4">
                    <b-form-group
                        id="session_start_date_group"
                        label="Datum početka"
                        label-for="session_start_date">
                        <b-form-datepicker id="session_start_date" v-model="form.session_start_date"></b-form-datepicker>
                        <span v-if="errors.session_start_date" class="text-danger">{{ errors.session_start_date}}</span>
                    </b-form-group>
                </div>
                <div class="col-lg-4">
                    <b-form-group
                        id="session_start_time_group"
                        label="Vreme početka"
                        label-for="session_start_time">
                        <b-form-timepicker id="session_start_time" v-model="form.session_start_time"></b-form-timepicker>
                        <span v-if="errors.session_start_time" class="text-danger">{{ errors.session_start_time}}</span>
                    </b-form-group>
                </div>
                <div class="col-lg-2">
                    <b-form-group
                        id="session_duration_group"
                        label="Trajanje"
                        label-for="session_duration">
                        <b-input type="number" id="session_duration" v-model="form.session_duration"></b-input>
                        <span v-if="errors.session_duration" class="text-danger">{{ errors.session_duration}}</span>
                    </b-form-group>
                </div>
                <div class="col-lg-2">
                    <b-form-group
                        id="session_duration_unit_group"
                        label="Jedinica trajanja"
                        label-for="session_duration_unit">
                        <b-form-select v-model="form.session_duration_unit" :options="units"></b-form-select>
                        <span v-if="errors.session_duration_unit" class="text-danger">{{ errors.session_duration_unit}}</span>
                    </b-form-group>
                </div>
            </div>
            <b-form-group
                id="session_short_note_group"
                label="Kratka beleška"
                label-for="session_short_note">
                <b-form-textarea
                    id="session_short_note"
                    v-model="form.session_short_note"
                    placeholder="Unesite belešku ako je ima ..."
                    rows="3"
                    max-rows="6"></b-form-textarea>
            </b-form-group>
        </form>
    </div>
</template>

<script>
export default {
    name: "SessionForm.vue",
    props: {
        mentor_id: { typeof: Number, default: 0 },
        program_id: { typeof: Number, default: 0 },
        action: { typeof: String, default: ''},
        token: { typeof: String, default: '' },
        session_id: { typeof: Number, default: 0 }
    },
    methods: {
        send() {
            console.log('entered submit...');
            var data = new FormData();
            data.append('_token', this.token);
            for(let property in this.form) {
                data.append(property, this.form[property]);
            }
            data.append('programid', this.program_id);
            data.append('mentorid', this.mentor_id);
            if(this.session_id != 0) {
                data.append('sessionid', this.session_id);
            }

            return new Promise((resolve, reject) => {
                axios.post(this.action, data)
                .then(response => {
                    console.log(response.data);
                    resolve(response);
                })
                .catch((error) => {
                    console.log(error.response.data.messagge);
                    this.errors = {};
                    for(let err in error.response.data.errors) {
                        this.errors[err] = error.response.data.errors[err][0];
                    }
                    reject(this.errors);
                });
            });

        },
        async getSessionData() {
            var data = new FormData();
            data.append('_token', this.token);
            data.append('session_id', this.session_id);
            await axios.post('/sessions/getSessionData', data)
            .then(response => {
                for(let property in this.form) {
                    if(property == 'session_short_note' && response.data[property] == null)
                        continue;
                    this.form[property] = response.data[property];
                }
            });
        }
    },
    async mounted() {
        if(this.sessionId != 0) {
            await this.getSessionData();
        }
    },
    data() {
        return {
            form: {
                session_title: '',
                session_start_date: '',
                session_start_time: '',
                session_duration: 0,
                session_duration_unit: 0,
                session_short_note: ''
            },
            units: [
                { value: 0, text: "Izaberite"},
                { value: 1, text: "minute(s)"},
                { value: 2, text: "hour(s)"},
                { value: 3, text: "day(s)"}
            ],
            errors: {}
        }
    }
}
</script>

<style scoped>

</style>
