<template>

</template>

<script>
export default {
    name: "ProfileEditor",
    data() {
        return {
            form: {
                id: 0,
                is_company: false,
                id_number: '',
                contact_email: '',
                password: '',
                contact_phone: '',
                address: '',
                university: 0,
                short_ino_desc: '',
                business_branch: 16,
                reason_contact: 1,
                note: '',
                profile_status: 0,
                profile_logo: '',
                profile_background: '',
                profile_webpage: 'http://',
                profile_state: 0


            }
        }
    }
}
</script>

<style scoped>

</style>
