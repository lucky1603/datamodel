<template>
    <div>
        <b-form @submit="onSubmit" @reset="onReset" v-if="this.show" ref="forma" :href="action">
            <b-form-row>
                <b-col ref="nameColumn" :lg="form.is_company == 'on' ? 6 : 12">
                    <b-form-group id="name-group" size="sm" label="Ime" label-for="name" description="Ovo je opis">
                        <b-form-input id="name" size="sm" v-model="form.name" placeholder="Unesite ime"></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col ref="id_number_column" lg="6" v-if="form.is_company == 'on'">
                    <b-form-group id="id_number_group" size="sm" label="Matični broj" label-for="name" description="Broj od 8 cifara">
                        <b-form-input id="name" size="sm" v-model="form.id_number" placeholder="Unesite matični broj"></b-form-input>
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
                    </b-form-group>
                </b-col>
                <b-col lg="4" size="sm">
                    <b-form-group id="contact_email_group" size="sm" label="Email" label-for="contact_email">
                        <b-form-input id="contact_email" size="sm" v-model="form.contact_email" placeholder="Email osobe za kontakt"></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col lg="4" size="sm">
                    <b-form-group id="contact_phone_group" size="sm" label="Kontakt telefon" label-for="contact_phone">
                        <b-form-input id="contact_phone" size="sm" v-model="form.contact_phone" placeholder="Kontakt telefon osobe za kontakt"></b-form-input>
                    </b-form-group>
                </b-col>
            </b-form-row>

            <b-form-group id="address_group" size="sm" label="Adresa" label-for="address">
                <b-form-input id="address" size="sm" v-model="form.address" placeholder="Ime i prezime osobe za kontakt"></b-form-input>
            </b-form-group>

            <b-form-group id="profile_logo_group" size="sm" label="Logo" label-for="profile_logo">
                <b-form-file
                    id="profile_logo"
                    name="profile_logo"
                    v-model="form.profile_logo"
                    :state="Boolean(form.profile_logo)"
                    placeholder="Izaberite sliku pritiskom na dugme ili je jednostavno prevucite ovde."
                    drop-placeholder="Spustite fajl ovde!"></b-form-file>
            </b-form-group>

            <b-form-group id="profile_background_group" size="sm" label="Pozadina" label-for="profile_background">
                <b-form-file
                    id="profile_background"
                    name="profile_background"
                    v-model="form.profile_background"
                    :state="Boolean(form.profile_background)"
                    placeholder="Izaberite sliku pritiskom na dugme ili je jednostavno prevucite ovde."
                    drop-placeholder="Spustite fajl ovde!"></b-form-file>
            </b-form-group>
        </b-form>
    </div>
</template>

<script>
export default {
    name: "ProfileForm",
    props: {
        action: ''
    },
    methods: {
        onSubmit() {
            console.log('on submit detected!!!');
            // axios.post(action, form)
            // .then(response => {
            //     console.log(response.data);
            // });
        },
        onReset() {

        },
        handleSubmit(formName) {
            if(formName == 'createProfile') {
                let formData = new FormData();
                for(const property in this.form) {
                    formData.append(property, this.form[property])
                }

                formData.append('profile_logo', this.form.profile_logo);
                formData.append('profile_background', this.form.profile_background);

                axios.post(this.action, formData)
                .then(response => {
                    Event.$emit('refresh');
                });
            }
        }
    },
    mounted() {
        Event.$on('submit', this.handleSubmit)
    },
    data() {
        return {
            show: true,
            universities: [],
            activities: [],
            form : {
                name: '',
                id_number: '',
                is_company: false,
                contact_person: 'Sinisa Ristic',
                contact_email: 'sinisa.ristic@gmail.com',
                contact_phone: '+381 11 222 333',
                position: '',
                address: '',
                profile_logo: null,
                profile_background: null,
                ino_desc: '',
                reason_contact: 0,
                university: 0,
                basic_activity: 0,
                note: '',
            }
        }
    }
}
</script>

<style scoped>

</style>
