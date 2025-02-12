<template>
  <div class="bg-light p-4 shadow">
    <b-form @submit.prevent="sendData">
        <b-form-checkbox
            id="checkbox-1"
            name="checkbox-1"
            :value="1"
            :unchecked-value="0"
            v-model="form.unlock"
            @change="sendData"
        >
            {{ _('gui.unlock_public_call') }}
        </b-form-checkbox>
        <b-form-group 
            v-if="form.unlock == 1"
            :label="_('gui.public_call_start')" 
            label-cols="3"
            content-cols="9"
            label-class="text-primary"
            :description="_('gui.public_call_start_text')"  class="mt-3">
            <b-form-input type="datetime-local" v-model="form.start" @change="sendData"></b-form-input>
        </b-form-group>
        <b-form-group 
            v-if="form.unlock == 1"
            label-cols="3"
            content-cols="9"
            :label="_('gui.public_call_end')" 
            label-class="text-primary"
            :description="_('gui.public_call_end_text')" class="mt-3">
            <b-form-input type="datetime-local" v-model="form.end" @change="sendData"></b-form-input>
        </b-form-group>
    </b-form>   
  </div>
</template>
<script>
import _ from 'lodash';

export default {
  name: 'PublicCallManager',
  props: {
      callId: {typeof: Number, default: 0},
  },
  data() {
    return {
        form: {
            id: this.callId,
            unlock: 0,
            start: null,
            end: null
        }
    };
  },

  mounted() {
    if(this.id != 0) {
      this.getData(this.form.id);
    }
    
  },

  methods: {
    sendData() {
      let formData = new FormData();
      formData.append('id', this.form.id);
      formData.append('unlock', this.form.unlock);
      formData.append('start', this.form.start);
      formData.append('end', this.form.end);

      axios.post('/public-calls/edit', formData)
      .then(response => {
        console.log(response.data);
      })
    }, 
    getData(id) {
      axios.get('/public-calls/data/' + id)
      .then(response => {
        console.log(response.data);
        this.form.unlock = response.data.active;
        this.form.start = response.data.public_call_date;
        this.form.end = response.data.public_call_end_date;
      });
    }
  },
};
</script>