<template>
    <div class="container">
        <b-form @submit.prevent="onSubmit">
            <b-form-group size="sm" :label="_('gui.mentor_form_name')">
                <b-form-input id="name" size="sm" v-model="form.name" :placeholder="_('gui.mentor_form_name_placeholder')"></b-form-input>
                <span v-if="errors.name" class="text-danger">{{ errors.name }}</span>
            </b-form-group>
            <b-form-group size="sm" :label="_('gui.mentor_form_company')">
                <b-form-input id="company" size="sm" v-model="form.company" :placeholder="_('gui.mentor_form_company_placeholder')"></b-form-input>
                <span v-if="errors.name" class="text-danger">{{ errors.name }}</span>
            </b-form-group>
            <b-form-group size="sm" :label="_('gui.mentor_form_email')">
                <b-form-input id="email" size="sm" v-model="form.email" :placeholder="_('gui.mentor_form_email_placeholder')"></b-form-input>
                <span v-if="errors.email" class="text-danger">{{ errors.email }}</span>
            </b-form-group>
            <b-form-group size="sm" :label="_('gui.mentor_form_phone')">
                <b-form-input id="phone" size="sm" v-model="form.phone" :placeholder="_('gui.mentor_form_phone_placeholder')"></b-form-input>
                <span v-if="errors.phone" class="text-danger">{{ errors.phone }}</span>
            </b-form-group>
            <b-form-group size="sm" :label="_('gui.mentor_form_address')">
                <b-form-input id="address" size="sm" v-model="form.address" :placeholder="_('gui.mentor_form_address_placeholder')"></b-form-input>
                <span v-if="errors.address" class="text-danger">{{ errors.address }}</span>
            </b-form-group>
            <div class="row">
                <div class="col-lg-5 ">
                    <b-form-group :label="_('gui.mentor_form_photo')" size="sm">
                        <div class="d-flex flex-column align-items-center justify-content-center bg-dark" style="height: 250px">
                            <img :src="form.photo" style="height: 250px; position: relative; top: 19px" id="preview" ref="preview"/>
                            <b-button variant="primary" style="position:relative; top: -25px; width: 100px" @click="browseClicked">{{ _('gui.mentor_form_browse')}}</b-button>
                            <input type="file" id="photo" name="photo" ref="photo" style="color: transparent; display: none; position:relative; display:none; top: -50px" @change="photoChanged">
                        </div>
                    </b-form-group>
                </div>
                <div class="col-lg-7">
                    <b-form-group size="sm" :label="_('gui.mentor_form_specialities')" >
                        <b-form-select v-model="form.specialities" :options="specialitiesList" multiple :select-size="8"></b-form-select>
                        <span v-if="errors.specialities" class="text-danger">{{ errors.specialities }}</span>
                    </b-form-group>
                    <b-form-group size="sm" :label="_('gui.mentor_form_mentor_type')">
                        <b-form-select v-model="form.mentor_type" :options="mentorTypes"></b-form-select>
                        <span v-if="errors['mentor-type']" class="text-danger">{{ errors['mentor-type']}}</span>
                    </b-form-group>
                </div>
            </div>
            <div v-if="showButtons" class="d-flex flex-wrap align-items-center justify-content-center">
                <b-button variant="primary" class="m-2" style="width: 100px" @click="onSubmit">{{ _('gui.accept') }}</b-button>
                <b-button variant="outline-primary" class="m-2" style="width: 100px" @click="onCancel">{{ _('gui.cancel') }}</b-button>
            </div>
        </b-form>
    </div>

</template>

<script>
import axios from 'axios';

export default {
    name: "MentorForm",
    props: {
        action: { typeof: String, default: '/mentors/create'},
        token: { typeof: String, default: '' },
        mentor_id: { typeof: Number, default: 0 },
        showButtons: { typeof: Boolean, default: true },
        returnLocation: { typeof: String, default: '/mentors'}
    },
    computed: {
        backLocation() {
            if(this.mentor_id != 0) {
                return this.returnLocation + '/' + this.mentor_id;
            }

            return this.returnLocation;
        }
    },
    methods: {
        async getData() {
            await axios.get('/mentors/getData/' + this.mentor_id)
            .then(response => {
                console.log(response.data);
                for(let property in response.data) {
                    this.form[property] = response.data[property];
                }
            });
        },
        onSubmit(){
            let formData = new FormData();
            formData.append('_token', this.token);
            if(this.mentor_id != 0) {
                formData.append('mentorid', this.mentor_id);
            }

            for(let property in this.form) {
                if(property != 'specialities' && property != 'photo' && property != 'mentor_type') {
                    formData.append(property, this.form[property]);
                } else if(property == 'specialities') {
                    for(let i in this.form.specialities) {
                        formData.append('specialities[]', this.form.specialities[i]);
                    }
                } else if(property == 'mentor_type') {
                    formData.append('mentor-type', this.form.mentor_type);
                } else {
                    let photo = document.getElementById('photo').files[0];
                    formData.append('photo', photo);
                }
            }

            return new Promise((resolve, reject) => {
                axios.post(this.action, formData)
                .then(response => {
                    console.log(response.data);
                    if(this.showButtons) {
                        location.href = this.backLocation;
                    }

                    resolve(response);
                })
                .catch((error) => {
                    console.log(error.response.data.message);
                    this.errors = {};
                    for(let err in error.response.data.errors) {
                        this.errors[err] = error.response.data.errors[err][0];
                    }
                    reject(this.errors);
                });
            });

        },
        onCancel() {
            location.href = '/mentors';
        },
        browseClicked() {
            this.$refs.photo.click();
        },
        photoChanged(evt) {
            let el = evt.target;
            console.log(el);
            var fileReader = new FileReader();
            fileReader.onload = function () {
                var data = fileReader.result;  // data <-- in this var you have the file data in Base64 format
                $('#preview').attr('src', data);
            };

            fileReader.readAsDataURL($(el)[0].files[0]);
        }
    },
    onPhotoChanged(photo) {
        this.form.photo = photo;
    },
    async mounted() {
        Dispecer.$on('photo-changed', this.onPhotoChanged);
        if(this.mentor_id != 0) {
            await this.getData();
        }
    },
    data() {
        return {
            form: {
                name: '',
                company: '',
                email: '',
                phone: '',
                address: '',
                photo: '',
                specialities: [],
                mentor_type: 0
            },
            errors: [],
            imgPath: '/images/custom/nophoto2.png',
            specialitiesList: [
                { value: 1, text: window.i18n['gui-select']['BB-IOT'] },
                { value: 2, text: window.i18n['gui-select']['BB-EnEff'] },
                { value: 3, text: window.i18n['gui-select']['BB-AI'] },
                { value: 4, text: window.i18n['gui-select']['BB-NewMat'] },
                { value: 5, text: window.i18n['gui-select']['BB-Civic'] },
                { value: 6, text: window.i18n['gui-select']['BB-TechSport'] },
                { value: 7, text: window.i18n['gui-select']['BB-Finance'] },
                { value: 8, text: window.i18n['gui-select']['BB-Marketing'] },
                { value: 9, text: window.i18n['gui-select']['BB-EcoTrans'] },
                { value: 10, text: window.i18n['gui-select']['BB-RoboAuto'] },
                { value: 11, text: window.i18n['gui-select']['BB-Tourism'] },
                { value: 12, text: window.i18n['gui-select']['BB-Education'] },
                { value: 13, text: window.i18n['gui-select']['BB-MediaGaming'] },
                { value: 14, text: window.i18n['gui-select']['BB-MedTech'] },
                { value: 15, text: window.i18n['gui-select']['BB-Agriculture'] },
                { value: 16, text: window.i18n['gui-select']['BB-Other'] },
            ],
            mentorTypes: [
                { value: 0, text: window.i18n['gui-select'].mentor_type_choose },
                { value: 1, text: window.i18n['gui-select'].mentor_type_business },
                { value: 2, text: window.i18n['gui-select'].mentor_type_tech },
                { value: 3, text: window.i18n['gui-select'].mentor_type_specialist },
            ]
        }
    }
}
</script>

<style scoped>

</style>
