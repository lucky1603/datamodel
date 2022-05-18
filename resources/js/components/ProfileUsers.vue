<template>
    <div>
        <div class="card">
            <div class="card-header bg-primary text-white">
                <span class="float-left">KORISNICI PROFILA</span>
                <b-button variant="primary" size="sm" class="float-right" @click="showModalAddUser"><i class="uil-user-plus"></i></b-button>
            </div>
            <div class="card-body d-flex flex-column">
                <div v-for="(user, index) in users" class="d-flex align-items-center justify-content-center w-100 py-1" :key="index">
                    <img :src="getUserPhoto(user.photo)" class="rounded-circle mr-4 float-left" style="width: 48px; height: 48px">
                    <span class="font-14 mr-4 float-left" style="width: 80%">{{ user.name }}</span>
                    <a href="#" class="float-right" @click="itemClicked" :data-id="user.id"><i class="uil-pen" :data-id="user.id"></i></a>
                </div>
            </div>
        </div>
        <b-modal ref="add-modal" id="add-modal" hide-footer header-bg-variant="dark" header-text-variant="light">
            <template #modal-title >{{ modalTitle }}</template>
            <user-form :profileId="profileId" :token="token" :userId="userId" @cancelled="hideModalAddUser" @submitted="userFormSubmitted"></user-form>
        </b-modal>
    </div>
</template>

<script>
export default {
    name: "ProfileUsers",
    props: {
        profileId: { typeof: Number, default: 0 },
        token: { typeof: String, default: ''},
    },
    methods: {
        async getData() {
            await axios.get('/profiles/profileUsers/' + this.profileId)
            .then(response => {
                console.log(response.data);
                this.users.length = 0;
                for(let property in response.data) {
                    this.users.push(response.data[property]);
                }
            });
        },
        getUserPhoto(photo) {
            if(photo == null) {
                return '/images/custom/nophoto2.png';
            }

            return photo;
        },
        itemClicked(event) {
            this.userId = $(event.target).data('id');
            this.modalTitle = "PROMENI PODATKE KORISNIKA";
            this.$refs["add-modal"].show();
        },
        showModalAddUser() {
            this.modalTitle = 'DODAJ NOVOG KORISNIKA';
            this.userId = 0;
            this.$refs["add-modal"].show();
        },
        hideModalAddUser() {
            this.$refs["add-modal"].hide();
        },
        userFormSubmitted() {
            this.hideModalAddUser();
            this.getData();
        }
    },
    async mounted() {
        await this.getData();
    },
    data() {
        return {
            users: [],
            modalTitle: 'DODAJ NOVOG KORISNIKA',
            userId: 0,
            addUser: true
        }
    }
}
</script>

<style scoped>

</style>
