<template>

</template>

<script>
export default {
    name: "MenthorView",
    props : {
        mentorId: ''
    },
    data() {
        return {
            mentor: {type: Object, default: null },
            programs : [],
            sessions : [],
        }
    }
}
</script>

<style scoped>

</style>
