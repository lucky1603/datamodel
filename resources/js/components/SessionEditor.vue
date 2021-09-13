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
            <div class="card-body">
                <b-table striped hover :items="items" sticky-header="250px" small select-mode="single"></b-table>
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
    methods : {
        programSelected(programId) {
            alert(`Program (${programId}) selected!`);
        }
    },
    data() {
        return {
            programName: {type: String, default: ''},
            programs: [],
            sessions: [],
            selectedProgram: {type: Object, default: null },
            selectedSession: {type: Object, default: null },
            items: [
                { age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
                { age: 21, first_name: 'Larsen', last_name: 'Shaw' },
                { age: 89, first_name: 'Geneva', last_name: 'Wilson' },
                { age: 38, first_name: 'Jami', last_name: 'Carney' },
                { age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
                { age: 21, first_name: 'Larsen', last_name: 'Shaw' },
                { age: 89, first_name: 'Geneva', last_name: 'Wilson' },
                { age: 38, first_name: 'Jami', last_name: 'Carney' }
            ]
        }
    },
    mounted() {
        if(this.test.length > 0)
            this.programName = this.test;

        Event.$on('program-selected', this.programSelected);
    }
}
</script>

<style scoped>

</style>
