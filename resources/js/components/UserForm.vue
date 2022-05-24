<template>
    <div>
        <form action="#" method="post" enctype="multipart/form-data" @submit.prevent="onSubmit">
            <div class="row">
                <div class="col-lg-4">
                    <div class="d-flex flex-column">
                        <img :src="userPhotoSource" id="userPhotoPreview" ref="userPhotoPreview" style="width: 100%">
                        <input
                            type="file"
                            id="photo"
                            name="photo"
                            ref="photo"
                            class="d-none bg-transparent" @input="imageSelected">
                        <b-button
                            size="sm"
                            variant="primary"
                            @click="buttonClicked">Izmeni sliku</b-button>
                    </div>
                </div>
                <div class="col-lg-8">
                    <b-form-group
                        id="lblName"
                        label="Name:"
                        label-for="name"
                        description="Ime i prezime korisnika">
                        <b-form-input
                            type="text"
                            size="sm"
                            id="name"
                            v-model="userdata.name"
                            placeholder="Unesite ime korisnika">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group
                        id="lblEmail"
                        label="E-Mail:"
                        label-for="email"
                        description="E-Mail korisnika">
                        <b-form-input
                            type="email"
                            size="sm"
                            id="name"
                            v-model="userdata.email" :disabled="userId != 0"
                            placeholder="Unesite ime korisnika">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group
                        v-if="this.userId == 0"
                        id="lblPassword"
                        label="Lozinka:"
                        label-for="password"
                        description="Unesite lozinku">
                        <b-form-input
                            type="password"
                            size="sm"
                            id="name"
                            v-model="userdata.password"
                            placeholder="Unesite lozinku">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group
                        v-if="this.userId == 0"
                        id="lblRepeatPassword"
                        label="Ponovite lozinku:"
                        label-for="repeatPassword"
                        description="Ponovite lozinku kao gore">
                        <b-form-input
                            type="password"
                            size="sm"
                            id="name"
                            v-model="userdata.password_confirmation"
                            placeholder="Unesite lozinku">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group
                        id="lblPozicija"
                        label="Pozicija:"
                        label-for="pozicija"
                        description="Pozicija u organizaciji">
                        <b-form-input
                            type="text"
                            size="sm"
                            id="pozicija"
                            v-model="userdata.position">
                        </b-form-input>
                    </b-form-group>
                </div>
            </div>
            <hr>
            <div class="d-flex align-items-center justify-content-center">
                <b-button type="submit" variant="primary" style="width: 120px; margin-right: 20px">Prihvati</b-button>
                <b-button type="button" variant="outline-primary" style="width: 120px;" @click="onCancel">Zatvori</b-button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: "UserForm",
    props: {
        token: { typeof: String, default: ''},
        profileId: { typeof: Number, default: 0 },
        userId: { typeof: Number, default: 0 },
    },
    computed: {
        userPhotoSource() {
            if(this.userdata.photo == null)
                return '/images/custom/nophoto2.png';
            return this.userdata.photo;
        }
    },
    methods: {
        buttonClicked() {
            console.log('Button clicked');
            $('#photo').trigger('click');
        },
        onSubmit() {
            let formData = new FormData();
            for(let property in this.userdata) {
                if(property === 'photo')
                    continue;
                formData.append(property, this.userdata[property]);
            }

            formData.append('_token', this.token);

            if(this.$refs.photo.files.length > 0) {
                formData.append('photo', this.$refs.photo.files[0]);
            }

            let action = '';
            if(this.userId == 0) {
                action = '/edituser/addedforprofile/' + this.profileId;
            } else {
                action = '/edituser/' + this.userId;
            }

            axios.post(action, formData)
            .then(response => {
                console.log(response.data);
                this.$emit('submitted');
            })
            .catch(error => {
                console.log(error);
            });


        },
        onCancel() {
            this.$emit('cancelled');
        },
        imageSelected(event) {
            let el = event.target;
            let fileReader = new FileReader();
            fileReader.onload = function () {
                let data = fileReader.result;
                $('#userPhotoPreview').attr('src', data);
            };
            fileReader.readAsDataURL($(el)[0].files[0]);
        },
        async getData() {
            await axios.get('/edituser/userData/' + this.userId)
            .then(response => {
                console.log(response);
                for(let property in this.userdata) {
                    this.userdata[property] = response.data[property];
                }
            });
        }
    },
    async mounted() {
        if(this.userId != 0) {
            await this.getData();
        }
    },
    data() {
        return {
            userdata: {
                name: '',
                photo: null,
                position: '',
                email: '',
                password: '',
                password_confirmation: '',
            },
        }
    }
}
</script>

<style scoped>

</style>
