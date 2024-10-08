<template>
  <div>
    <!-- -->
    <b-form @submit.prevent="send">
      <b-form-group label="Naziv" description="Naziv korisničke mogućnosti">
        <b-form-input v-model="form.name" placeholder="Unesite naziv mogućnosti" required />
      </b-form-group>
      <b-form-group label="Opis" description="Opis korisničke mogućnosti">
        <b-form-textarea v-model="form.label" placeholder="Unesite opis korisničke mogućnosti" rows="3" max-rows="6"></b-form-textarea>
      </b-form-group>
      <b-form-group label="Role" description="Role kojima pripada">
        <div class="d-flex flex-wrap">
          <b-checkbox-group 
            v-model="form.roles" 
            :options="allRoles">
          </b-checkbox-group>
        </div>
      </b-form-group>
    </b-form>
  </div>
</template>

<script>
export default {
  name: 'AbilityManagerForm',
  props: {
    id: { type: Number, default: 0 }
  },
  data() {
    return {
      form: {
        name: null,
        label: null,
        roles: []
      },
      allRoles: []
    };
  },

  async mounted() {
    this.getAllRoles();
    await this.getData();
  },

  methods: {
    async send() {
        var action = '/abilities/create';
        if(this.id != 0) {
          action = '/abilities/edit/' + this.id;
        }

        let formData = new FormData();
        formData.append('name', this.form.name);
        formData.append('label', this.form.label);
        this.form.roles.forEach(element => {
          formData.append('roles[]', element );
        });

        await axios.post(action, formData)
        .then(response => {
          console.log(response);                    
        });
    },
    getAllRoles() {
      axios.get('/roles/list')
      .then(response => {
        let roles = response.data;
        this.allRoles = [];
        for(let property in roles) {
          this.allRoles.push({
            value: roles[property].id,
            text: roles[property].label 
          });
        }
      });
    },
    async getData() {
      if(this.id != 0) {
        await axios.get('/abilities/data/' + this.id)
        .then(response => {
          let ability = response.data;
          let roles = ability.roles;
          this.form.name = ability.name;
          this.form.label = ability.label;
          this.form.roles = [];
          for(let property in roles) {
            this.form.roles.push(roles[property].id);
          }
        });
      }
      
    }
  },
};
</script>