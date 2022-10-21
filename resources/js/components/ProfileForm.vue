<template>
    <div>
        <b-form v-if="this.show" ref="forma" @submit.prevent="onSubmit" >
            <b-form-row>
                <b-col ref="nameColumn" :lg="is_company ? 6 : 12">
                    <b-form-group id="name-group" size="sm" :label="_('gui.profile_create_form_name')" label-for="name">
                        <b-form-input id="name" size="sm" v-model="form.name" :placeholder="_('gui.profile_create_form_name_placeholder')"></b-form-input>
                        <span v-if="errors.name" class="text-danger">{{ errors.name}}</span>
                    </b-form-group>
                </b-col>
                <b-col ref="id_number_column" lg="6" v-if="is_company">
                    <b-form-group id="id_number_group" size="sm" :label="_('gui.profile_create_form_id_number')" label-for="name" description="Broj od 8 cifara">
                        <b-form-input id="name" size="sm" v-model="form.id_number" :placeholder="_('gui.profile_create_form_id_number_placeholder')"></b-form-input>
                        <span v-if="errors.id_number" class="text-danger">{{ errors.id_number}}</span>
                    </b-form-group>
                </b-col>
            </b-form-row>
            <b-form-checkbox
                v-model="is_company">
                {{ _('gui.profile_create_form_is_company')}}
            </b-form-checkbox>

            <b-form-row class="mt-2">
                <b-col lg="4" size="sm">
                    <b-form-group id="contact_person_group" size="sm" :label="_('gui.profile_create_form_contact_person')" label-for="contact_person">
                        <b-form-input id="contact_person" size="sm" v-model="form.contact_person" :placeholder="_('gui.profile_create_form_contact_person_placeholder')"></b-form-input>
                        <span v-if="errors.contact_person" class="text-danger">{{ errors.contact_person}}</span>
                    </b-form-group>
                </b-col>
                <b-col lg="4" size="sm">
                    <b-form-group id="contact_email_group" size="sm" :label="_('gui.profile_create_form_email')" label-for="contact_email">
                        <b-form-input id="contact_email" size="sm" v-model="form.contact_email" :placeholder="_('gui.profile_create_form_email_placeholder')"></b-form-input>
                        <span v-if="errors.contact_email" class="text-danger">{{ errors.contact_email}}</span>
                    </b-form-group>
                </b-col>
                <b-col lg="4" size="sm">
                    <b-form-group id="contact_phone_group" size="sm" :label="_('gui.profile_create_form_contact_phone')" label-for="contact_phone">
<!--                        <b-form-input id="contact_phone" size="sm" v-model="form.contact_phone" placeholder="xxx xxx-xxx(x)" @input="enforcePhoneFormat"></b-form-input>-->
                        <b-form-input id="contact_phone" size="sm" v-model="form.contact_phone" placeholder="xxx xxx-xxx(x)" data-toggle="input-mask" data-mask-format="000 000-0000"></b-form-input>
                        <span v-if="errors.contact_phone" class="text-danger">{{ errors.contact_phone}}</span>
                    </b-form-group>
                </b-col>
            </b-form-row>

            <b-form-group id="profile_webpage_group" size="sm" :label="_('gui.profile_create_form_web_page')" label-for="profile_webpage">
                <b-form-input id="profile_webpage" size="sm" v-model="form.profile_webpage" :placeholder="_('gui.profile_create_form_web_page_placeholder')"></b-form-input>
                <span v-if="errors.profile_webpage" class="text-danger">{{ errors.profile_webpage}}</span>
            </b-form-group>

            <b-form-group id="address_group" size="sm" :label="_('gui.profile_create_form_address')" label-for="address">
                <b-form-input id="address" size="sm" v-model="form.address" :placeholder="_('gui.profile_create_form_address_placeholder')"></b-form-input>
                <span v-if="errors.address" class="text-danger">{{ errors.address}}</span>
            </b-form-group>

            <b-form-group id="profile_logo_group" size="sm" label="Logo" label-for="profile_logo">
                <b-form-file
                    id="profile_logo"
                    ref="profile_logo"
                    name="profile_logo"
                    v-model="form.profile_logo"
                    :placeholder="_('gui.profile_create_form_image_select_placeholder')"
                    drop-placeholder="Spustite fajl ovde!" @input="onFileSelect"></b-form-file>
                <file-item v-if="form.profile_logo_file != null && form.profile_logo_file.filelink != ''" :filelink="form.profile_logo_file.filelink" :filename="form.profile_logo_file.filename"></file-item>
            </b-form-group>

            <b-form-group id="profile_background_group" size="sm" :label="_('gui.profile_create_form_background')" label-for="profile_background">
                <b-form-file
                    id="profile_background"
                    ref="profile_background"
                    name="profile_background"
                    v-model="form.profile_background"
                    :placeholder="_('gui.profile_create_form_image_select_placeholder')"
                    drop-placeholder="Spustite fajl ovde!"></b-form-file>
                <file-item v-if="form.profile_background_file != null && form.profile_background_file.filelink != ''" :filelink="form.profile_background_file.filelink" :filename="form.profile_background_file.filename"></file-item>
            </b-form-group>
            <b-form-row>
                <b-col lg="6" size="sm">
                    <b-form-group id="university_group" :label="_('gui.profile_create_form_university')" label-for="university">
                        <b-form-select v-model="form.university" :options="universities" size="sm"></b-form-select>
                        <span v-if="errors.university" class="text-danger">{{ errors.university}}</span>
                    </b-form-group>
                </b-col>
                <b-col lg="6" size="sm">
                    <b-form-group id="activities_group" :label="_('gui.profile_create_form_basic_activity')" label-for="business_branch">
                        <b-form-select v-model="form.business_branch" :options="activities" size="sm"></b-form-select>
                        <span v-if="errors.business_branch" class="text-danger">{{ errors.business_branch}}</span>
                    </b-form-group>
                </b-col>
            </b-form-row>
            <b-form-group id="short_ino_desc_group" :label="_('gui.profile_create_form_short_description')" label-for="short_ino_desc">
                <b-form-textarea
                    id="short_ino_desc"
                    v-model="form.short_ino_desc"
                    :placeholder="_('gui.profile_create_form_short_description_placeholder')"
                    rows="3"></b-form-textarea>
                <span v-if="errors.short_ino_desc" class="text-danger">{{ errors.short_ino_desc}}</span>
            </b-form-group>
            <b-form-group id="membership_type_group" :label="_('gui.profile_create_form_membership_type')" label-for="membership_type">
                <b-form-select v-model="form.membership_type" :options="membershipTypes" size="sm"></b-form-select>
                <span v-if="errors.membership_type" class="text-danger">{{ errors.membership_type}}</span>
            </b-form-group>

            <b-form-group id="ntp_group" :label="_('gui.profile_create_form_ntp')" label-for="ntp">
                <b-form-select v-model="form.ntp" :options="ntps" size="sm"></b-form-select>
                <span v-if="errors.ntp" class="text-danger">{{ errors.ntp}}</span>
            </b-form-group>

            <div v-if="show_buttons" class="d-flex align-items-center justify-content-center">
                <b-button size="sm" variant="primary" type="submit" class="mx-1" >{{ _('gui.accept')}}</b-button>
                <b-button size="sm" variant="outline-primary" type="button" class="mx-1" @click="onCancel">{{ _('gui.cancel')}}</b-button>
            </div>

        </b-form>
    </div>
</template>

<script>
export default {
    name: "ProfileForm",
    props: {
        action: { typeof: String, default: '/profiles/create' },
        show_buttons: { typeof: Boolean, default: false },
        profile_id: { typeof: Number, default: 0 },
        token: {typeof: String, default: ''},
        back_location: { typeof: String, default: '/profiles'}
    },
    methods: {
        async getData() {
            if(this.profile_id != 0) {
                await axios.get(`/profiles/profileData/${this.profile_id}`)
                    .then(response => {
                        console.log(response.data);
                        let profileData = response.data;
                        this.form = {};
                        for(let property in profileData) {
                            if(property == 'id') {
                                this.form.profileid = profileData[property];
                            }
                            else if(property == 'profile_logo') {
                                this.form.profile_logo_file = profileData[property];
                            }
                            else if(property == 'profile_background') {
                                this.form.profile_background_file = profileData[property];
                            }
                            else {

                                this.form[property] = profileData[property];
                            }
                        }

                        this.is_company = this.form.is_company;
                    });
            }

        },
        onFileSelect(file) {
            console.log(file);
            console.log(this.form.profile_logo);
        },
        onSubmit() {
            this.form.is_company = this.is_company;
            let formData = new FormData();
            formData.append('_token', this.token);

            for(const property in this.form) {
                if(property == 'profile_logo' || property == 'profile_background' )
                    continue;

                formData.append(property, this.form[property]);
            }

            if(this.form.is_company === 'off') {
                formData.delete('id_number');
            }

            if(this.form.profile_logo != null && this.$refs.profile_logo.files.length > 0) {
                formData.append('profile_logo', this.$refs.profile_logo.files[0]);
            }

            if(this.form.profile_background != null && this.$refs.profile_background.files.length > 0) {
                formData.append('profile_background', this.$refs.profile_background.files[0]);
            }

            // formData.append('_token', this.token);

            if(this.profile_id != 0) {
                return new Promise((resolve, reject) => {
                    axios.post(this.action, formData)
                        .then(response => {
                            console.log(response.data);
                            if(this.show_buttons) {
                                console.log('location refreshed');
                                window.location.href = '/profiles';
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
            } else {
                ////////////////////
                // With promise
                ////////////////////
                return new Promise((resolve, reject) => {
                    axios.post(this.action, formData)
                        .then(response => {
                            console.log(response.data);
                            if(this.show_buttons) {
                                console.log('location refreshed');
                                window.location.href = '/profiles';
                            }
                            resolve(response);
                        }).catch(error => {
                            console.log(error.response.data.message);
                            this.errors = {};
                            for(let err in error.response.data.errors) {
                                this.errors[err] = error.response.data.errors[err][0];
                            }
                            reject(this.errors);
                        });
                });

            }

        },
        onCancel() {
            window.location.href = this.back_location;
        },
        enforcePhoneFormat() {
            let phone = this.form.contact_phone.substring(0,12);
            let x = this.form.contact_phone.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            phone = (!x[2] ? (x[1] ? x[1] : ' ') : x[1] + ' ' + x[2] + (x[3] ? '-' + x[3] : '')).substring(0,12);
            this.form.contact_phone = phone;
        },

    },
    async mounted() {
        await this.getData();
    },
    data() {
        return {
            is_company: false,
            show: true,
            ntps: [
                { value: 0, text: window.i18n.gui.profile_list_ntp_choice },
                { value: 1, text: 'Naučno-tehnološki park Beograd' },
                { value: 2, text: 'Naučno-tehnološki park Niš' },
                { value: 3, text: 'Naučno-tehnološki park Čačak' }
            ],
            universities: [
                { value: null, text: window.i18n.gui.choose },
                { value: 1 ,text: 'Arhitektura' },
                { value: 2, text: 'Ekonomija' },
                { value: 3, text: 'Elektrotehnika' },
                { value: 4, text: 'Pravo' },
                { value: 5, text: 'FON' },
                { value: 6, text: 'FPN' },
                { value: 7, text: 'Šumarstvo' }
            ],
            activities: [
                { value: null, text: window.i18n.gui.choose},
                { value: 1, text: window.i18n['gui-select']['BB-IOT']},
                { value: 2, text: window.i18n['gui-select']['BB-EnEff'] },
                { value: 3, text: window.i18n['gui-select']['BB-AI']},
                { value: 4, text: window.i18n['gui-select']['BB-NewMat']},
                { value: 5, text: window.i18n['gui-select']['BB-Civic']},
                { value: 6, text: window.i18n['gui-select']['BB-TechSport']},
                { value: 7, text: window.i18n['gui-select']['BB-Finance']},
                { value: 8, text: window.i18n['gui-select']['BB-Marketing']},
                { value: 9, text: window.i18n['gui-select']['BB-EcoTrans']},
                { value: 10, text: window.i18n['gui-select']['BB-RoboAuto']},
                { value: 11, text: window.i18n['gui-select']['BB-Tourism']},
                { value: 12, text: window.i18n['gui-select']['BB-Education']},
                { value: 13, text: window.i18n['gui-select']['BB-MediaGaming']},
                { value: 14, text: window.i18n['gui-select']['BB-MedTech']},
                { value: 15, text: window.i18n['gui-select']['BB-Agriculture']},
                { value: 16, text: window.i18n['gui-select']['BB-Other']},
            ],
            contactReasons: [
                { value: 0, text: window.i18n.gui.choose},
                { value: 1, text: 'Razlog 1'},
                { value: 2, text: 'Razlog 2'},
                { value: 3, text: 'Razlog 3'},
            ],
            membershipTypes: [
                { value: 0, text: window.i18n.gui.membership_type_new},
                { value: 1, text: window.i18n.gui.membership_type_virtual},
                { value: 2, text: window.i18n.gui.membership_type_full_fledged},
                { value: 3, text: window.i18n.gui.membership_type_alumni},
                { value: 4, text: window.i18n.gui.membership_type_rejected}
            ],
            form : {
                profileid: 0,
                name: '',
                id_number: '',
                is_company: false,
                contact_person: '',
                contact_email: '',
                contact_phone: '',
                address: '',
                profile_logo: null,
                profile_logo_file: null,
                profile_background: null,
                profile_background_file: null,
                short_ino_desc: '',
                // reason_contact: 0,
                university: null,
                business_branch: null,
                // note: '',
                profile_webpage: '',
                membership_type: 0,
                ntp: 0
            },
            errors: {}

        }
    }
}
</script>

<style scoped>

</style>
