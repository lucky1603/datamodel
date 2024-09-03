<template>
  <div>
    <b-form-group label="Naziv" description="Naziv role">
        <b-form-input v-model="form.name" placeholder="Unesite naziv role" required />
      </b-form-group>
      <b-form-group label="Opis" description="Opis role">
        <b-form-textarea v-model="form.label" placeholder="Unesite opis role" rows="3" max-rows="6"></b-form-textarea>
      </b-form-group>
      <b-form-group label="Startna ruta" description="Ruta početne stranice">        
        <b-form-input v-model="form.startRoute" placeholder="Unesite startnu rutu"/>
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
        startRoute: 'default',
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
            this.form.startRoute = role.startRoute;
            this.form.abilities = role.abilities;
        });
    },
    async send() {
      let formData = new FormData();
      formData.append('name', this.form.name);
      formData.append('label', this.form.label);
      formData.append('startRoute', this.form.startRoute);
      this.form.abilities.forEach(element => {
        formData.append('abilities[]', element);
      });
      // formData.append('abilities', this.form.abilities);

      var action = '/roles/create';
      if(this.id != 0) {
        action = '/roles/edit/' + this.id;
      }

      await axios.post(action, formData)
      .then(response => {
        console.log(response.data);
        this.$emit('succeded');
      });
    }
  },
};
</script>