<template>
  <div>
    <b-form @submit.prevent="send">
      <b-row>
        <b-col>
          <div class="d-flex flex-column align-items-start justify-content-center">
            <img :src="imagePhotoSource" id="userPhotoPreview" class="w-100 h-50">
            <input type="file" id="photo" name="photo" ref="photo" class="d-none bg-transparent" @input="imageSelected"/>
            <b-button size="sm" variant="primary" @click="buttonClicked" class="mt-1 imgbutton">Izaberi sliku</b-button>
          </div>
        </b-col>
        <b-col>
          <b-form-group label="Ime" description="Ime i prezime korisnika ili ime firme">
            <b-form-input v-model="form.name" placeholder="Unesite ime korisnika" required />
          </b-form-group>
          <b-form-group label="EMail">
            <b-form-input v-model="form.email" type="email" placeholder="Unesite email korisnika" required />
          </b-form-group>
          <b-form-group v-if="userId == 0" label="Lozinka">
            <b-form-input v-model="form.password" type="password" placeholder="Unesite lozinku korisnika" required />
          </b-form-group>
          <b-form-group v-if="userId == 0" label="Ponovite lozinku">
            <b-form-input v-model="form.repeatPassword" type="password" placeholder="Unesite lozinku korisnika" required />
          </b-form-group>
          <b-form-group label="Pozicija" description="Pozicija/zaposlenje u firmi">
            <b-form-input v-model="form.position" required />
          </b-form-group>
          <b-form-group label="Rola" description="Korisnička rola">
            <b-form-select v-model="form.role" :options="roles" size="sm"/>
          </b-form-group>
          <b-form-group v-if="form.role == 3" label="Profil" description="Profil kompanije kome korisnik pripada">
            <b-form-select v-model="form.profile" :options="profiles" size="sm"/>
          </b-form-group>
        </b-col>
      </b-row>
      <hr>
        <div class="d-flex align-items-center justify-content-center">
            <b-button type="submit" variant="primary" style="width: 150px; margin-right: 20px"><b-spinner v-if="sending" label="Loading..." style="height: 20px; width: 20px; margin-right: 10px"></b-spinner>Prihvati</b-button>
            <b-button type="button" variant="outline-primary" style="width: 150px;" @click="onCancel">Zatvori</b-button>
        </div>
    </b-form>
  </div>
</template>

<script>
export default {
  name: 'UserManagerForm',
  props: {
    userId : { type: Number, default: 0}
  },
  computed: {
    imagePhotoSource() {
      if(this.form.photo == null) {
        return '/images/custom/nophoto2.png';
      }

      return this.form.photo;
    }
  },
  data() {
    return {
      form: {
        name: null,        
        email: null,
        password: null,
        repeatPassword: null,
        role: null,
        profile: null,
        position: null,
        photo: null
      },
      profiles: [],
      roles: [], 
      sending: false
    };
  },

  async mounted() {
    if(this.userId != 0) {
      this.getRoles();
      this.getProfiles();
      await this.getData();
    }
  },

  methods: {
    async send() {
      this.sending = true;
      let formData = new FormData();
      for(let property in this.form) {
          if(property === 'photo')
              continue;
          formData.append(property, this.form[property]);
      }

      // formData.append('_token', this.token);

      if(this.$refs.photo.files.length > 0) {
          formData.append('photo', this.$refs.photo.files[0]);
      }

      let action = '';
      if(this.userId != 0) {
          action = '/users/edit/' + this.userId;
      } else {
          action = '/users/create';
      }

      await axios.post(action, formData)
      .then(response => {
        console.log(response.data);
        this.$emit('submitted');
      })
      .catch(error => {
        console.log(error.response.data.message);
        this.errors = {};
        for(let err in error.response.data.errors) {
            this.errors[err] = error.response.data.errors[err][0];
        }
        console.log(this.errors);
        this.sending = false;
      });

    },
    async getData() {
        await axios.get('/edituser/userData/' + this.userId)
        .then(response => {
            console.log(response.data);
            for(let property in this.form) {
              this.form[property] = response.data[property];
            }
        })
    },
    getProfiles() {
      axios.get('/profiles/lista')
      .then(response => {
        let profili = response.data;
        for(let property in profili) {
          this.profiles.push({
            value: profili[property].id,
            text: profili[property].name
          });
        }
      });
    },
    getRoles() {
      axios.get('/roles/list')
      .then(response => {
        let role = response.data;
        for(let property in role) {
          this.roles.push({
            value: role[property].id,
            text: role[property].name
          });
        }
      });
    },
    imageSelected(event) {
        let el = event.target;
        let fileReader = new FileReader();
        fileReader.onload = function () {
            let data = fileReader.result;
            document.getElementById('userPhotoPreview').src = data;
        };

        fileReader.readAsDataURL($(el)[0].files[0]);
    },
    buttonClicked() {
      this.$refs.photo.click();
    },
    onCancel() {
      this.$emit('cancelled');
    }
  },
};
</script>

<style scoped>
.imgbutton {
  position:relative;
  top: -50px;
  left: 10px;
}
</style>