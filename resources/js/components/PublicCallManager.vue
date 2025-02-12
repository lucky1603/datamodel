<template>
  <div>
    <b-form @submit.prevent="sendData">
        <b-form-checkbox
            id="checkbox-1"
            name="checkbox-1"
            :value="true"
            :unchecked-value="false"
            v-model="form.unlock"
        >
            {{ _('gui.unlock_public_call') }}
        </b-form-checkbox>
        <b-form-group 
            v-if="form.unlock == true"
            :label="_('gui.public_call_start')" 
            label-cols="3"
            content-cols="9"
            label-class="text-primary"
            :description="_('gui.public_call_start_text')"  class="mt-3">
            <b-form-input type="datetime-local" v-model="form.start"></b-form-input>
        </b-form-group>
        <b-form-group 
            v-if="form.unlock == true"
            label-cols="3"
            content-cols="9"
            :label="_('gui.public_call_end')" 
            label-class="text-primary"
            :description="_('gui.public_call_end_text')" class="mt-3">
            <b-form-input type="datetime-local" v-model="form.end"></b-form-input>
        </b-form-group>
    </b-form>   
  </div>
</template>
<script>
import _ from 'lodash';

export default {
  name: 'PublicCallManager',

  data() {
    return {
        form: {
            unlock: false,
            start: null,
            end: null
        }
    };
  },

  mounted() {
    
  },

  methods: {
    
  },
};
</script>