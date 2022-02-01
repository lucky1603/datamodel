<template>
    <div class="d-flex flex-column align-items-center justify-content-center">
        <report-item
            v-for="report in reports"
            :key="report.reportId"
            :report_id="report.reportId"
            :order_number="report.orderNumber"
            :upper_cell="report.reportName"
            :lower_cell="report.reportDue"
            :status="report.status" class="m-2 shadow"></report-item>
    </div>
</template>

<script>
export default {
    name: "ReportExplorer",
    props: {
        program_id: { typeof: Number, default: 0 }
    },
    methods: {
        async getData() {
            await axios.get(`/reports/programReportsInfo/${this.program_id}`)
            .then(response => {
                console.log(response.data);
                this.reports = response.data;
            });
        }
    },
    data() {
        return {
            reports: [],
        }
    },
    async mounted() {
        await this.getData();
    }
}
</script>

<style scoped>

</style>
