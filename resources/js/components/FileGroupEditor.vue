<template>
    <div>
        <b-form id="myFormAddFileGroup" ref="myForm" @submit="onSubmit" @submit.prevent>
            <b-form-input hidden v-model="token"/>
            <b-form-input hidden v-model="report_id"/>
            <h3 class="text-center">{{ title }}</h3>
            <hr>
            <b-form-group
                id="files"
                label="Datoteke izveštaja"
                label-for="fileInput"
            >
                <b-form-file
                    ref="fileInput"
                    id="fileInput"
                    v-model="form.files"
                    :state="null"
                    placeholder="Izaberite datoteke ili ih prevucite ovde..."
                    drop-placeholder="Prevucite datoteke ovde..." multiple
                ></b-form-file>
            </b-form-group>
            <b-form-group label="Napomena">
                <b-form-textarea
                    id="textarea"
                    v-model="form.note"
                    placeholder="Unesite napomenu ako je imate..."
                    rows="3"
                    max-rows="6"
                ></b-form-textarea>
            </b-form-group>
            <div v-if="show_buttons" class="d-flex align-items-center justify-content-center">
                <b-button type="submit" variant="info" class="mr-2">Prihvati</b-button>
                <b-button type="button" variant="danger" @click="onCancel">Odustani</b-button>
            </div>
        </b-form>
    </div>
</template>

<script>
export default {
    name: "FileGroupEditor",
    props: {
        title: { typeof: String, default: 'Izveštaj'},
        action: { typeof: String, default: ''},
        token: {typeof: String, default: ''},
        report_id: {typeof: Number, default: 0},
        show_buttons: {typeof: Boolean, default: true}
    },
    data() {
        return {
            form: {
                files: [],
                note: ''
            }
        }
    },
    methods: {
        async onSubmit() {
            alert('about to submit the form');
            let formData = new FormData();
            formData.append('_token', this.token);
            formData.append('report_id', this.report_id);
            formData.append('note', this.form.note);
            if(this.$refs.fileInput.files.length > 0) {
                for(let i = 0; i < this.$refs.fileInput.files.length; i++) {
                    formData.append('files[]', this.$refs.fileInput.files[i]);
                }
            }
            await axios.post('/reports/addFileGroup', formData)
            .then(response => {
                console.log(response.data);
            })
            .catch(error => {
                console.log(error);
            });
        },
        onCancel() {
            alert('canceling form');
        }
    }
}
</script>

<style scoped>

</style>
