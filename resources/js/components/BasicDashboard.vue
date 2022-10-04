<template>
  <div class="row">
    <div class="col-lg-3">
      <percentage-card
        title="Startapovi"
        :value="startupCount"
        :total="total"
        subtitle="od svih prijavljenih"
        icon="uil-arrow-up-right"
      ></percentage-card>
      <percentage-card
        title="Kompanije"
        :value="companiesCount"
        :total="total"
        subtitle="od svih prijavljenih"
        percentage_class="text-danger"
        icon="uil-bag"
      ></percentage-card>
      <percentage-card
        title="Potpisan ugovor"
        :value="inProgram"
        :total="total"
        subtitle="od svih prijavljenih"
        icon="uil-file-contract-dollar"
      ></percentage-card>
    </div>
    <div class="col-lg-3">
      <percentage-card
        title="U procesu prijave"
        :value="applied"
        :total="total"
        subtitle="od svih prijavljenih"
        percentage_class="text-danger"
        icon="uil-file-alt"
      ></percentage-card>
      <percentage-card
        title="Poslate prijave"
        :value="sent"
        :total="total"
        subtitle="od svih prijavljenih"
        icon="uil-file-check-alt"
      ></percentage-card>
      <percentage-card
        title="Odbijeni"
        :value="outOfProgram"
        :total="total"
        subtitle="od svih prijavljenih"
        percentage_class="text-danger"
        icon="uil-sign-out-alt"
      ></percentage-card>
    </div>
    <div class="col-lg-6">
      <div class="card shadow-sm" style="height: 300px">
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
            title="Radionice"
            :value="workshops"
            :height="140"
            icon="uil-meeting-board"
          ></percentage-card>
        </div>
        <div class="col-lg-6">
          <percentage-card
            title="Mentorske sesije"
            :value="sessions"
            :height="140"
          ></percentage-card>
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
    };
  },

  async mounted() {
    await this.getData();
  },

  methods: {
    async getData() {
      let formData = new FormData();
      formData.append("program_type", this.program_type);
      formData.append("_token", this.token);
      await axios.post("/analytics/startupTypes", formData).then((response) => {
        this.startupCount = response.data.startupCount;
        this.companiesCount = response.data.companyCount;
      });

      await axios
        .get("/analytics/programStatuses/" + this.program_type)
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

      await axios.get("/analytics/ntp/" + this.program_type).then((response) => {
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
    },
  },
};
</script>

<style lang="scss" scoped></style>
