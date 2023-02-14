<template>
    <div>
        <div class="row">
            <div class="col-lg-3">
            <percentage-card
                :title="_('gui.basic_dashboard_startups')"
                :value="startupCount"
                :total="total"
                :subtitle="_('gui.basic_dashboard_of_all_registered')"
                icon="uil-arrow-up-right"
            ></percentage-card>
            <percentage-card
                :title="_('gui.basic_dashboard_companies')"
                :value="companiesCount"
                :total="total"
                :subtitle="_('gui.basic_dashboard_of_all_registered')"
                percentage_class="text-danger"
                icon="uil-bag"
            ></percentage-card>
            <percentage-card
                :title="_('gui.basic_dashboard_contract_signed')"
                :value="inProgram"
                :total="total"
                :subtitle="_('gui.basic_dashboard_of_all_registered')"
                icon="uil-file-contract-dollar"
            ></percentage-card>
            </div>
            <div class="col-lg-3">
            <percentage-card
                :title="_('gui.basic_dashboard_application')"
                :value="applied"
                :total="total"
                :subtitle="_('gui.basic_dashboard_of_all_registered')"
                percentage_class="text-danger"
                icon="uil-file-alt"
            ></percentage-card>
            <percentage-card
                :title="_('gui.basic_dashboard_applications_sent')"
                :value="sent"
                :total="total"
                :subtitle="_('gui.basic_dashboard_of_all_registered')"
                icon="uil-file-check-alt"
            ></percentage-card>
            <percentage-card
                :title="_('gui.basic_dashboard_rejected')"
                :value="outOfProgram"
                :total="total"
                :subtitle="_('gui.basic_dashboard_of_all_registered')"
                percentage_class="text-danger"
                icon="uil-sign-out-alt"
            ></percentage-card>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-sm" style="height: 300px">
                    <div class="card-header">
                        {{ _('gui.basic_dashboard_distribution_programs_by_ntp').toUpperCase() }}
                    </div>
                    <div class="card-body">
                        <apexchart
                        type="donut"
                        :options="chartOptions"
                        :series="chartValues"
                        height="100%"
                        ></apexchart>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                    <percentage-card
                        :title="_('gui.basic_dashboard_worshops')"
                        :value="workshops"
                        :height="140"
                        icon="uil-meeting-board"
                    ></percentage-card>
                    </div>
                    <div class="col-lg-6">
                    <percentage-card
                        :title="_('gui.basic_dashboard_mentoring_sessions')"
                        :value="sessions"
                        :height="140"
                    ></percentage-card>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow-sm" style="height: 300px">
                    <div class="card-header">
                        {{ _('gui.basic_dashboard_distribution_apps_by_city').toUpperCase() }}
                    </div>
                    <div class="card-body">
                    <apexchart
                        type="donut"
                        :options="chartOptionsGradovi"
                        :series="chartValuesGradovi"
                        height="100%"
                    ></apexchart>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-sm" style="height: 300px">
                    <div class="card-header">
                        {{ _('gui.basic_dashboard_distribution_apps_by_municipalities').toUpperCase() }}
                    </div>
                    <div class="card-body">
                    <apexchart
                        type="donut"
                        :options="chartOptionsOpstine"
                        :series="chartValuesOpstine"
                        height="100%"
                    ></apexchart>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  name: "BasicDashboard",
  props: {
    program_type: { typeof: Number, default: 0 },
    token: { typeof: String, default: "" },
    year: { typeof: Number, default: 0}
  },
  data() {
    return {
      startupCount: 0,
      companiesCount: 0,
      applied: 0,
      sent: 0,
      inProgram: 0,
      total: 0,
      outOfProgram: 0,
      workshops: 0,
      sessions: 0,
      chartOptions: {
        labels: [],
      },
      chartValues: [],
      chartOptionsGradovi: {
        labels: [],
      },
      chartValuesGradovi: [],
      chartOptionsOpstine: {
        labels: [],
      },
      chartValuesOpstine: [],
    };
  },

  async mounted() {
    await this.getData();
    Dispecer.$on('refresh-components', this.refresh);
  },

  methods: {
    async getData() {
      let formData = new FormData();
      formData.append("program_type", this.program_type);
      formData.append("_token", this.token);
      formData.append('year', this.year);

      await axios.post("/analytics/startupTypes", formData).then((response) => {
        this.startupCount = response.data.startupCount;
        this.companiesCount = response.data.companyCount;
      });

      await axios
        .post("/analytics/programStatuses", formData)
        .then((response) => {
          this.applied = response.data.applied;
          this.total = response.data.total;
          this.sent = this.total - this.applied;
          this.inProgram = response.data.inProgram;
          this.outOfProgram = response.data.outOfProgram;
        });

      await axios
        .post("/analytics/workshopAndSessionStats", formData)
        .then((response) => {
          this.workshops = response.data.workshops;
          this.sessions = response.data.sessions;
        });

      await axios.post("/analytics/ntp", formData).then((response) => {
        console.log("Chart data");
        console.log(response.data);
        this.chartValues.length = 0;
        this.chartOptions.labels.length = 0;
        for (let property in response.data) {
          let item = response.data[property];
          this.chartOptions.labels.push(item.ntp);
          this.chartValues.push(item.count);
        }

      });

      await axios.post("/analytics/prijaveGradovi", formData).then((response) => {
        console.log("Chart data - prijave po gradovima");
        console.log(response.data);
        this.chartValuesGradovi.length = 0;
        this.chartOptionsGradovi.labels.length = 0;
        for (let property in response.data) {
          let item = response.data[property];
          this.chartOptionsGradovi.labels.push(item.ntp);
          this.chartValuesGradovi.push(item.count);
        }

      });


      await axios.post("/analytics/prijaveOpstine", formData).then((response) => {
        console.log("Chart data - prijave po opstinama");
        console.log(response.data);
        this.chartValuesOpstine.length = 0;
        this.chartOptionsOpstine.labels.length = 0;
        for (let property in response.data) {
          let item = response.data[property];
          this.chartOptionsOpstine.labels.push(item.opstina);
          this.chartValuesOpstine.push(item.count);
        }

      });





    },
    async refresh() {
        await this.getData();
    }
  },
};
</script>

<style lang="scss" scoped></style>
