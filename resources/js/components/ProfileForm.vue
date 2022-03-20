<template>
    <div>
        <b-form v-if="this.show" ref="forma" @submit.prevent="onSubmit" >
            <b-form-row>
                <b-col ref="nameColumn" :lg="form.is_company == 'on' ? 6 : 12">
                    <b-form-group id="name-group" size="sm" label="Ime" label-for="name">
                        <b-form-input id="name" size="sm" v-model="form.name" placeholder="Unesite ime"></b-form-input>
                        <span v-if="errors.name" class="text-danger">{{ errors.name}}</span>
                    </b-form-group>
                </b-col>
                <b-col ref="id_number_column" lg="6" v-if="form.is_company == 'on'">
                    <b-form-group id="id_number_group" size="sm" label="Matični broj" label-for="name" description="Broj od 8 cifara">
                        <b-form-input id="name" size="sm" v-model="form.id_number" placeholder="Unesite matični broj"></b-form-input>
                        <span v-if="errors.id_number" class="text-danger">{{ errors.id_number}}</span>
                    </b-form-group>
                </b-col>
            </b-form-row>
            <b-form-checkbox
                id="is_company"
                v-model="form.is_company"
                name="is_company"
                value="on"
                unchecked-value="off"
            >
                Da li je kompanija?
            </b-form-checkbox>

            <b-form-row class="mt-2">
                <b-col lg="4" size="sm">
                    <b-form-group id="contact_person_group" size="sm" label="Kontakt osoba" label-for="contact_person">
                        <b-form-input id="contact_person" size="sm" v-model="form.contact_person" placeholder="Ime i prezime osobe za kontakt"></b-form-input>
                        <span v-if="errors.contact_person" class="text-danger">{{ errors.contact_person}}</span>
                    </b-form-group>
                </b-col>
                <b-col lg="4" size="sm">
                    <b-form-group id="contact_email_group" size="sm" label="Email" label-for="contact_email">
                        <b-form-input id="contact_email" size="sm" v-model="form.contact_email" placeholder="Email osobe za kontakt"></b-form-input>
                        <span v-if="errors.contact_email" class="text-danger">{{ errors.contact_email}}</span>
                    </b-form-group>
                </b-col>
                <b-col lg="4" size="sm">
                    <b-form-group id="contact_phone_group" size="sm" label="Kontakt telefon" label-for="contact_phone">
                        <b-form-input id="contact_phone" size="sm" v-model="form.contact_phone" placeholder="xxx xxx-xxx(x)" @input="enforcePhoneFormat"></b-form-input>
                        <span v-if="errors.contact_phone" class="text-danger">{{ errors.contact_phone}}</span>
                    </b-form-group>
                </b-col>
            </b-form-row>

            <b-form-group id="profile_webpage_group" size="sm" label="Web stranica" label-for="profile_webpage">
                <b-form-input id="profile_webpage" size="sm" v-model="form.profile_webpage" placeholder="Web stranica kompanije"></b-form-input>
                <span v-if="errors.profile_webpage" class="text-danger">{{ errors.profile_webpage}}</span>
            </b-form-group>

            <b-form-group id="address_group" size="sm" label="Adresa" label-for="address">
                <b-form-input id="address" size="sm" v-model="form.address" placeholder="Adresa kompanije"></b-form-input>
                <span v-if="errors.address" class="text-danger">{{ errors.address}}</span>
            </b-form-group>

            <b-form-group id="profile_logo_group" size="sm" label="Logo" label-for="profile_logo">
                <b-form-file
                    id="profile_logo"
                    ref="profile_logo"
                    name="profile_logo"
                    v-model="form.profile_logo"
                    placeholder="Izaberite sliku pritiskom na dugme ili je jednostavno prevucite ovde."
                    drop-placeholder="Spustite fajl ovde!" @input="onFileSelect"></b-form-file>
                <file-item v-if="form.profile_logo_file != null && form.profile_logo_file.filelink != ''" :filelink="form.profile_logo_file.filelink" :filename="form.profile_logo_file.filename"></file-item>
            </b-form-group>

            <b-form-group id="profile_background_group" size="sm" label="Pozadina" label-for="profile_background">
                <b-form-file
                    id="profile_background"
                    ref="profile_background"
                    name="profile_background"
                    v-model="form.profile_background"
                    placeholder="Izaberite sliku pritiskom na dugme ili je jednostavno prevucite ovde."
                    drop-placeholder="Spustite fajl ovde!"></b-form-file>
                <file-item v-if="form.profile_background_file != null && form.profile_background_file.filelink != ''" :filelink="form.profile_background_file.filelink" :filename="form.profile_background_file.filename"></file-item>
            </b-form-group>
            <b-form-row>
                <b-col lg="6" size="sm">
                    <b-form-group id="university_group" label="Fakultet" label-for="university">
                        <b-form-select v-model="form.university" :options="universities" size="sm"></b-form-select>
                        <span v-if="errors.university" class="text-danger">{{ errors.university}}</span>
                    </b-form-group>
                </b-col>
                <b-col lg="6" size="sm">
                    <b-form-group id="activities_group" label="Osnovna aktivnost" label-for="business_branch">
                        <b-form-select v-model="form.business_branch" :options="activities" size="sm"></b-form-select>
                        <span v-if="errors.business_branch" class="text-danger">{{ errors.business_branch}}</span>
                    </b-form-group>
                </b-col>
            </b-form-row>
            <b-form-group id="short_ino_desc_group" label="Kratak opis inovacije" label-for="short_ino_desc">
                <b-form-textarea
                    id="short_ino_desc"
                    v-model="form.short_ino_desc"
                    placeholder="Unesite kratak opis vaše inovacije"
                    rows="3"></b-form-textarea>
                <span v-if="errors.short_ino_desc" class="text-danger">{{ errors.short_ino_desc}}</span>
            </b-form-group>
            <b-form-group id="reason_contact_group" label="Razlog kontaktiranja" label-for="reason_contact">
                <b-form-select v-model="form.reason_contact" :options="contactReasons" size="sm"></b-form-select>
                <span v-if="errors.reason_contact" class="text-danger">{{ errors.reason_contact}}</span>
            </b-form-group>
            <b-form-group id="note_group" label="Napomena/Primedba" label-for="note">
                <b-form-textarea
                    id="note"
                    v-model="form.note"
                    placeholder="Unesite primedbu ako je imate..."
                    rows="3"></b-form-textarea>
            </b-form-group>
            <div v-if="show_buttons" class="d-flex align-items-center justify-content-center">
                <b-button size="sm" variant="primary" type="submit" class="mx-1" >Prihvati</b-button>
                <b-button size="sm" variant="outline-primary" type="button" class="mx-1">Odustani</b-button>
            </div>

        </b-form>
    </div>
</template>

<script>
export default {
    name: "ProfileForm",
    props: {
        action: '/profiles/create',
        show_buttons: { typeof: Boolean, default: false },
        profile_id: { typeof: Number, default: 0 },
        token: {typeof: String, default: ''}
    },
    methods: {
        async getData() {
            await axios.get(`/profiles/profileData/${this.profile_id}`)
            .then(response => {
                console.log(response.data);
                let profileData = response.data;
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
            });
        },
        onFileSelect(file) {
            console.log(file);
            console.log(this.form.profile_logo);
        },
        onSubmit() {
            let formData = new FormData();
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
                    axios.post(this.action, formData, {
                        'x-csrf-token': $('[name=_token]').val()
                    })
                        .then(response => {
                            console.log(response.data);
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
                    axios.post(this.action, formData,
                        {
                            'x-csrf-token' : $('[name=_token]').val()
                        })
                        .then(response => {
                            console.log(response.data);
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

                //////////
                // With return value
                /////////
                // let retValue = false;
                // await axios.post('/profiles/create', formData)
                //     .then(response => {
                //         console.log(response.data);
                //         this.errors = {};
                //         retValue = true;
                //     }).catch(error => {
                //         this.errors = {};
                //         for(let err in error.response.data.errors) {
                //             this.errors[err] = error.response.data.errors[err][0];
                //         }
                //         retValue = false;
                //     });
                // return retValue;

                // $.ajax({
                //     url: '/profiles/create',
                //     method: 'POST',
                //     data: formData,
                //     processData: false,
                //     contentType: false,
                //     success: function(data) {
                //         console.log(data);
                //
                //     },
                //     error: function(data) {
                //         let errorData = data.responseJSON;
                //         console.log(errorData);
                //         // $('.error-notification').hide();
                //         // for(let key in errorData.errors) {
                //         //     let value = errorData.errors[key];
                //         //     $('#' + key + 'Error').show().text(value);
                //         // }
                //
                //         // $('#okSpinner').hide();
                //         // button.disabled = false;
                //     }
                // })
            }

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
            show: true,
            universities: [
                { value: 0, text: 'Izaberite ...' },
                { value: 1 ,text: 'Arhitektura' },
                { value: 2, text: 'Ekonomija' },
                { value: 3, text: 'Elektrotehnika' },
                { value: 4, text: 'Pravo' },
                { value: 5, text: 'FON' },
                { value: 6, text: 'FPN' },
                { value: 7, text: 'Šumarstvo' }
            ],
            activities: [
                { value: 0, text: 'Izaberite ...'},
                { value: 1, text: 'Energetska efikasnost, zelene, čiste tehnologije i ekologija'},
                { value: 2, text: 'Veštačka inteligencija, baze podataka i analitika'},
                { value: 3, text: 'Novi materijali i 3 D štampa'},
                { value: 4, text: 'Tehnologija u sportu'},
                { value: 5, text: 'Ekonomske transakcije, finansije, marketing i prodaja'},
                { value: 6, text: 'Robotika i automatizacija'},
                { value: 7, text: 'Turizam i putovanja'},
                { value: 8, text: 'Edukacija , obrazovanje i usavršavanje'},
                { value: 9, text: 'Mediji , komunikacije i društvene mreže/ Gaming i zabava'},
                { value: 10, text: 'Medicinske tehnologije'},
                { value: 11, text: 'Ostalo'},
            ],
            contactReasons: [
                { value: 0, text: 'Izaberite ...'},
                { value: 1, text: 'Razlog 1'},
                { value: 2, text: 'Razlog 2'},
                { value: 3, text: 'Razlog 3'},
            ],
            form : {
                profileid: 0,
                name: '',
                id_number: '',
                is_company: 'off',
                contact_person: '',
                contact_email: '',
                contact_phone: '',
                address: '',
                profile_logo: null,
                profile_logo_file: null,
                profile_background: null,
                profile_background_file: null,
                short_ino_desc: '',
                reason_contact: 0,
                university: 0,
                business_branch: 0,
                note: '',
                profile_webpage: ''
            },
            errors: {}

        }
    }
}
</script>

<style scoped>

</style>
