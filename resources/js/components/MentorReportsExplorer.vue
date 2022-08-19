<template>
    <div class="card shadow-sm">
        <div class="card-header" style="background-color: #efefef">
            <span class="h4 attribute-label">IZVEŠTAJI</span>
        </div>
        <div class="card-body d-flex flex-wrap align-items-center justify-content-start overflow-auto">
            <mentor-report-item
                v-for="(report, index) in reports"
                :key="index"
                :name="report.name"
                :sent="report.status == 2 ? true : false"
                :alert="report.status == 1 ? true : false"
                :date="report.dueDate" :link="'/mentor-reports/edit/' + report.id" class="ml-2 mr-2">
            </mentor-report-item>
        </div>
    </div>
</template>

<script>
export default {
    name: "MentorReportsExplorer",
    props: {
        mentorId: { typeof: Number, default: 0 }
    },
    methods: {
        async getData() {
            axios.get(`/mentors/reportsForProgram/${this.mentorId}/${this.programId}`)
            .then(response => {
                console.log('reports are ...');
                console.log(response.data);
                this.reports = response.data;
            });
        },
        selectProgram(programId) {
            this.programId = programId;
            this.getData();
        }
    },
    mounted() {
        Dispecer.$on('program-selected', this.selectProgram);
    },
    data() {
        return {
            reports: [],
            programId: 0
        }
    }
}
</script>

<style scoped>

</style>
