<template>
<div class="row">
    <div class="col-lg-3">
        <div class="d-flex align-items-center justify-content-center bg-light" style="width: 100%; min-height: 200px">
            <img :src="profile.logo" class="w-100 ">
        </div>

        <div class="d-flex bg-light p-2">
            <img :src="contact.photo" class="rounded-circle" style="height: 48px; width: 48px;">
            <div class="d-flex flex-column justify-content-center ml-3">
                <span class="font-weight-bold font-13">{{ contact.name}}</span>
            </div>
        </div>
        <div class="d-flex flex-column align-items-start bg-light shadow py-2">
            <div class="d-flex mt-2 ml-2" >
                <i class="uil-envelope mr-2"></i>
                <span class="attribute-label font-12 flex-wrap">{{ contact.email}}</span>
            </div>

            <div class="d-flex mt-2 ml-2" >
                <i class="uil-phone mr-2"></i>
                <span class="attribute-label font-12 flex-wrap">{{ contact.phone}}</span>
            </div>
        </div>
        <profile-users :profile_id="profile_id" :token="token" :active_user_id="active_user_id" class="mt-4"></profile-users>
    </div>

    <div class="col-lg-4">
        <div class="d-flex flex-column">
            <div class="card">
                <div class="card-header bg-primary text-white">OSNOVNI PODACI</div>
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <div v-if="profile.is_company" class="d-flex flex-column w-100 m-1">
                            <span>MB:</span>
                            <span class="font-weight-bold shadow-sm">{{ mb}}</span>
                        </div>
                        <div v-if="profile.webpage != null" class="d-flex flex-column w-100 m-1">
                            <span style="width: 100px; margin-top:7px">WWW:</span>
                            <span class="font-14 font-weight-bold attribute-label flex-lg-fill mr-1">{{ profile.webpage }}</span>
                        </div>
                        <div v-if="profile.address != null" class="d-flex flex-column w-100 m-1">
                            <span style="width: 100px; margin-top: 7px">Adresa:</span>
                            <span class="font-weight-bold attribute-label p-1 flex-lg-fill mr-1">{{ profile.address }}</span>
                        </div>
                        <div v-if="profile.ino_desc != null" class="d-flex flex-column w-100 m-1">
                            <span class="mb-1">Kratak opis inovacije:</span>
                            <span class="font-weight-bold attribute-label p-1 font-12">{{ profile.ino_desc }}</span>
                        </div>
                        <div v-if="profile.business_branch != null" class="d-flex flex-column w-100 m-1">
                            <span class="mb-1">Specijalnost:</span>
                            <span class="font-weight-bold attribute-label p-1 font-12">{{ profile.business_branch }}</span>
                        </div>
                        <div v-if="profile.ntp != null" class="d-flex flex-column w-100 m-1">
                            <span class="mb-1">NTP:</span>
                            <span class="font-weight-bold attribute-label p-1 font-12">{{ profile.ntp }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <profile-programs :profileId="profile_id"></profile-programs>

        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header bg-primary text-white">POSLOVNI PODACI KOMPANIJE</div>
            <div class="card-body">
                <program-statistics-form :profile_id="profile_id" class="m-0 mt-2"></program-statistics-form>
            </div>
        </div>

    </div>
</div>
</template>

<script>
export default {
    name: "ProfileView",
    props: {
        profile_id: { typeof: Number, default: 0 },
        token: { typeof: String, default: ''},
        active_user_id : { typeof: Number, default: 0 }
    },
    methods: {
        async getData() {
            await axios.get('/profiles/pvd/' + this.profile_id )
            .then(response => {
                console.log(response.data);

                for(let property in this.profile) {
                   this.profile[property] = response.data.profile[property];
                }

                for(let property in this.contact) {
                    this.contact[property] = response.data.contact[property];
                }

            });
        }
    },
    data() {
        return {
            profile: {
                name: '',
                mb: '',
                is_company: false,
                address: '',
                webpage: '',
                ino_desc: '',
                business_branch: '',
                profile_status: 0,
                profile_status_text: '',
                ntp: '',
                logo: ''
            },
            contact: {
                name: '',
                photo: '',
                email: '',
                phone: ''
            },
            programs: [],
            activeUserId: this.active_user_id
        }
    },
    async mounted() {
        await this.getData();
    }
}
</script>

<style scoped>

</style>
