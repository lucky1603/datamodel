<template>
    <b-form @submit.prevent="onSubmit">
        <b-form-group size="sm" label="Ime i prezime">
            <b-form-input id="name" size="sm" v-model="form.name" placeholder="Ime i prezime mentora"></b-form-input>
            <span v-if="errors.name" class="text-danger">{{ errors.name }}</span>
        </b-form-group>
        <b-form-group size="sm" label="E-Mail">
            <b-form-input id="email" size="sm" v-model="form.name" placeholder="E-Mail adresa mentora"></b-form-input>
            <span v-if="errors.email" class="text-danger">{{ errors.email }}</span>
        </b-form-group>
        <b-form-group size="sm" label="Br. telefona">
            <b-form-input id="phone" size="sm" v-model="form.phone" placeholder="Br. telefona mentora"></b-form-input>
            <span v-if="errors.phone" class="text-danger">{{ errors.phone }}</span>
        </b-form-group>
        <b-form-group size="sm" label="Adresa">
            <b-form-input id="address" size="sm" v-model="form.address" placeholder="Adresa mentora"></b-form-input>
            <span v-if="errors.address" class="text-danger">{{ errors.address }}</span>
        </b-form-group>
        
    </b-form>
</template>

<script>
export default {
    name: "MentorForm",
    methods: {
        onSubmit(){

        },
        onReset() {

        }
    },
    data() {
        return {
            form: {
                name: '',
                company: '',
                email: '',
                phone: '',
                address: '',
                photo: '',
                specialities: [],
                type: 0,
            },
            errors: []
        }
    }
}
</script>

<style scoped>

</style>
