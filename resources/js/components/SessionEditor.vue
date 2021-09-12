<template>
    <div class="h-100 w-100 mt-0 pt-2 pb-2">
        <div class="card h-50 w-100 shadow">
            <div class="card-header text-dark">
                <span class="mb-0 mt-0 attribute-label">
                    SESSION <span class="font-weight-bold" v-if="programName.length > 0">{{ programName }}</span>
                </span>
            </div>
        </div>
        <div class="card h-50 w-100 shadow">
            <div class="card-header text-dark">
                <span class="mb-0 mt-0 attribute-label">
                    SESSION DETAILS
                </span>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "SessionEditor",
    props: {
        test: {type: String, default: ''}
    },
    data() {
        return {
            programName: {type: String, default: ''},
            programs: [],
            sessions: [],
            selectedProgram: {type: Object, default: null },
            selectedSession: {type: Object, default: null }
        }
    },
    mounted() {
        if(this.test.length > 0)
            this.programName = this.test;
    }
}
</script>

<style scoped>

</style>
