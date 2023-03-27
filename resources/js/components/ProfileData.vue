<template>
    <div>
        <div v-if="short" class="card">
            <div class="card-body p-0 mb-4">
                <div class="d-flex justify-content-center" :style="profileImageContainerStyle">
                    <img :src="profileImageSource" :style="profileImageStyle" class="shadow">
                </div>
                <div class="d-flex flex-column align-items-center justify-content-center mt-4 p-3">
                    <h4>{{ profile.name }}</h4>
                    <p class="text-muted font-14 ">konkuriše za</p>
                    <b-button variant="primary" type="button" class="w-100">{{ profile.program_name}}</b-button>
                </div>
                <div class="d-flex flex-column justify-content-start px-3">
                    <p class="font-13 attribute-label font-weight-bold">KRATAK OPIS INOVACIJE</p>
                    <p class="text-muted font-13 mb-3 mt-0">{{ profile.short_ino_desc }}</p>
                    <table class="table table-sm table-borderless font-13 w-100 p-0">
                        <tr>
                            <td>Kontakt:</td>
                            <td class="font-weight-bold">{{ profile.contact_person}}</td>
                        </tr>
                        <tr>
                            <td>Telefon:</td>
                            <td class="font-weight-bold">{{ profile.contact_phone}}</td>
                        </tr>
                        <tr>
                            <td>E-Mail:</td>
                            <td class="font-weight-bold">
                                <a :href="'mailto://' + profile.contact_email" target="_blank">{{ profile.contact_email}}</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Web adresa:</td>
                            <td class="font-weight-bold">
                                <a :href="profile.profile_webpage" target="_blank">{{ profile.profile_webpage}}</a>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <b-button
                        variant="primary"
                        type="button"
                        size="sm"
                        class="rounded-circle mr-2"
                        style="width: 48px; height: 48px"
                        @click="showModal" title="Promeni podatke profila"><i class="dripicons-document-edit"></i></b-button>
                </div>
            </div>
        </div>
        <div v-else></div>
        <b-modal ref="modalUserEdit" size="lg" header-bg-variant="dark" header-text-variant="light">
            <template #modal-title >PROMENI PODATKE PROFILA</template>
            <profile-form ref="myProfileForm" action="/profiles/edit" :token="token" :profile_id="this.profile_id"></profile-form>
            <template #modal-footer>
                <b-button type="button" variant="primary" @click.prevent="onOk" >Prihvati</b-button>
                <b-button type="button" variant="light" @click="onCancel" >Zatvori</b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
export default {
    name: "ProfileData",
    props: {
        profile_id: { typeof: Number, default: 0 },
        short: { typeof: Boolean, default: true },
        role: { typeof: String, default: 'administrator' },
        token: { typeof: String, default: ''}
    },
    computed: {
        profileImageContainerStyle() {
            return {
                height: '125px',
                background: 'url(' + this.backgroundImage + ')'
            }
        },
        profileImageStyle() {
            return {
                position: 'relative',
                top: '50px',
                height: '100px',
                marginBottom: '30px'
            }
        },
        backgroundImage() {
            // if(this.profile.profile_background == null || this.profile.profile_background == '') {
            //     return '/images/custom/backdefault.jpg';
            // }

            // return this.profile.profile_background;
            return '/images/custom/backdefault.jpg';
        },
        profileImageSource() {
            if(this.profile.profile_logo == '') {
                return '/images/custom/nophoto2.png';
            }

            return this.profile.profile_logo;
        }
    },
    methods: {
        async getData() {
            await axios.get(`/profiles/profileTexts/${this.profile_id}`)
            .then(response => {
                console.log(response.data);
                this.profile = response.data;
            });
        },
        showModal() {
            this.$refs.modalUserEdit.show();
        },
        onOk() {
            // $('body').css('cursor', 'progress');
            document.body.style.cursor  = 'wait'

            this.$refs['myProfileForm'].onSubmit()
                .then(response => {
                    this.getData();
                    this.$refs.modalUserEdit.hide();
                    document.body.style.cursor  = 'default';
                })
                .catch(errors => {
                    console.log(errors);
                    document.body.style.cursor  = 'default';
                });

        },
        onCancel() {
            this.$refs.modalUserEdit.hide();
        },
    },
    async mounted() {
        await this.getData();
    },
    data() {
        return {
            profile: {
                id: 0,
                name: '',
                is_company: false,
                id_number: '',
                contact_email: '',
                contact_phone: '',
                contact_person: '',
                address: '',
                university: '',
                short_ino_desc: '',
                business_branch: '',
                reason_contact: '',
                note: '',
                profile_status: '',
                profile_logo: '',
                profile_background: '',
                profile_webpage: 'http://',
                profile_state: '',
                program_name: '',
                program_type: 0
            }
        }
    }
}
</script>

<style scoped>

</style>
