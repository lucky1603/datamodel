<template>
  <div>
    <b-form-group label="Naziv" description="Naziv role">
        <b-form-input v-model="form.name" placeholder="Unesite naziv role" required />
      </b-form-group>
      <b-form-group label="Opis" description="Opis role">
        <b-form-textarea v-model="form.label" placeholder="Unesite opis role" rows="3" max-rows="6"></b-form-textarea>
      </b-form-group>
      <b-form-group label="Mogućnosti" description="Mogućnosti koje poseduje">
        <div class="d-flex flex-wrap">
          <b-checkbox-group 
            v-model="form.abilities" 
            :options="allAbilities">
          </b-checkbox-group>
        </div>
      </b-form-group>
  </div>
</template>

<script>
export default {
  name: 'RoleManagerForm',
  props: {
    id: { type: Number, default: 0 }
  },
  data() {
    return {
      form: {
        name: null,
        label: null,
        abilities: []
      },
      allAbilities: []
    };
  },

  async mounted() {
    this.getAbilities();
    if(this.id != 0) {
        await this.getData();
    }
    
  },

  methods: {
    getAbilities() {
        axios.get('/abilities/list')
        .then(response => {
            this.allAbilities = [];
            let abilities = response.data;
            for(let property in abilities) {
                this.allAbilities.push({
                    value: abilities[property].id,
                    text: abilities[property].name
                });
            }
            
        });
    },
    async getData() {
        axios.get('/roles/data/' + this.id)
        .then(response => {
            let role = response.data;
            this.form.name = role.name;
            this.form.label = role.label;
            this.form.abilities = role.abilities;
        });
    },
    async send() {

    }
  },
};
</script>