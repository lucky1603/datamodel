<template>
  <div class="d-flex flex-column align-items-center justify-content-center">
    <report-item
      v-for="report in reports"
      :key="report.reportId"
      :report_id="report.reportId"
      :order_number="report.orderNumber"
      :upper_cell="report.reportName"
      :lower_cell="report.reportDue"
      :status="report.status"
      :user_type="user_role"
      class="m-2 shadow"
      @report-error-status="reportErrorStatus"
    ></report-item>

    <!--        <button v-if="user_role === 'profile'"  id="btnAddMember" type="button" class="btn btn-success rounded-circle mt-4" title="Dodaj izveštaj" @click="addNew">+</button>-->
    <b-modal
      ref="mbox"
      title="Nedozvoljena akcija"
      header-bg-variant="dark"
      header-text-variant="light"
    >
      <p>{{ errorMessage }}</p>
      <template #modal-footer="{ ok }">
        <div class="d-flex align-items-center justify-content-center">
          <b-button size="sm" variant="outline-dark" @click="ok()">OK</b-button>
        </div>
      </template>
    </b-modal>
  </div>
</template>

<script>
export default {
  name: "ReportExplorer",
  props: {
    program_id: { typeof: Number, default: 0 },
    user_role: { typeof: String, default: "profile" },
  },
  methods: {
    async getData() {
      await axios
        .get(`/reports/programReportsInfo/${this.program_id}`)
        .then((response) => {
          console.log(response.data);
          this.reports = response.data;
        });
    },
    addNew() {
      window.location.href = "/reports/create/" + this.program_id;
    },
    reportErrorStatus(message) {
        this.errorMessage = message;
        this.$refs.mbox.show();
    },
  },
  data() {
    return {
      reports: [],
      errorMessage: "",
    };
  },
  async mounted() {
    await this.getData();
  },
};
</script>

<style scoped></style>
