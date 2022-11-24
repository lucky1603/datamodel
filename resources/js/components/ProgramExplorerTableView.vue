<template>
  <div>
    <b-form v-if="show_header" id="filterForm" inline class="w-100 bg-light">
      <b-row id="toolbar" class="row w-100">
        <b-col xl="1" lg="1" class="pt-1">
          <span class="m-2 position-relative" style="top: 12px">FILTER</span>
        </b-col>
        <b-col
          xl="2"
          lg="3"
          style="display: flex; flex-direction: row; justify-content: left"
        >
          <b-input-group class="w-100 m-2 mt-3 mt-sm-3 mt-lg-2" size="sm">
            <b-form-input
              v-model="form.name"
              type="search"
              id="searchName"
              placeholder="Po nazivu ..."
              @update="onSubmit"
            ></b-form-input>
            <template #append>
              <b-input-group-text><b-icon-zoom-in></b-icon-zoom-in></b-input-group-text>
            </template>
          </b-input-group>
        </b-col>
        <b-col xl="2" lg="2" style="display: flex; justify-content: left">
          <b-form-select
            size="sm"
            class="m-2 w-100"
            v-model="form.program_type"
            :options="programTypes"
            @change="onSubmit"
          ></b-form-select>
        </b-col>
        <b-col xl="2" lg="2" style="display: flex; justify-content: left">
          <b-form-select
            size="sm"
            class="m-2 w-100"
            v-model="form.program_status"
            :options="programStatuses"
            @change="onSubmit"
          ></b-form-select>
        </b-col>
        <b-col xl="2" lg="2" style="display: flex; justify-content: left">
            <b-form-select
              size="sm"
              class="m-2 w-100"
              v-model="form.year"
              :options="years"
              @change="onSubmit"
            ></b-form-select>
          </b-col>
      </b-row>
    </b-form>
    <b-table
      :items="programs"
      :fields="fields"
      :per-page="page_size"
      :current-page="currentPage"
      head-variant="dark"
      small
      bordered
      class="shadow-sm"
      hover
      @row-clicked="rowClicked"
      @page-click="pageChanged"
    >
      <template #cell(company)="data">
        <img :src="data.item.logo" width="24px" class="mr-2" /> {{ data.value }}
      </template>
      <template #cell(type)="data">
        <strong>{{ data.item.typeText.toUpperCase() }}</strong>
      </template>
      <template #cell(status)="data">
        <span :class="getStatusClass(data.value)">{{
          data.item.statusText.toUpperCase()
        }}</span>
      </template>
    </b-table>
    <b-pagination
      v-model="currentPage"
      :total-rows="programs.length"
      :per-page="page_size"
      aria-controls="profileTable"
      align="right"
    ></b-pagination>
  </div>
</template>

<script>
export default {
  name: "ProgramExplorerTableView",
  props: {
    source: { typeof: String, default: "/programs/filterCache" },
    page_size: { typeof: Number, default: 10 },
    show_header: { typeof: Boolean, default: true },
    f_name: { typeof: String, default: "" },
    f_program_type: { typeof: Number, default: 0 },
    f_program_status: { typeof: Number, default: 0 },
    f_page: { typeof: Number, default: 1 },
  },
  watch: {
    currentPage: function (val, oldVal) {
      let data = new FormData();
      data.append("page", val);
      axios.post("/profiles/setSessionVars", data).then((response) => {
        console.log(response.data);
      });
    },
  },
  methods: {
    async getData() {
      let formData = new FormData();
      for (const property in this.form) {
        formData.append(property, this.form[property]);
      }
      console.log(this.form);
      await axios
        .post(this.source, formData)
        .then((response) => {
          console.log(response.data);
          this.programs = [];
          for (const property in response.data) {
            this.programs.push(response.data[property]);
          }
        })
        .catch((error) => {
          console.log(error);
          console.log(error.response.message);
        });
    },
    rowClicked(item, index, event) {
      // console.log('clicked on ' + item.id);
      $("body").css("cursor", "progress");
      Dispecer.$emit("program-clicked", item.id);
      // window.location.href = '/programs/' + item.id;
    },

    getLogo(logo) {
      if (logo == null || logo === "") {
        return "/images/custom/nophoto2.png";
      }

      return logo;
    },
    getStatusClass(status) {
      let retval = "mr-2";
      switch (status) {
        case -3:
          retval += " text-dark";
          break;
        case -2:
          retval += " text-danger";
          break;
        case -1:
          retval += " text-success";
          break;
        case 0:
          retval += " text-second";
        default:
          retval += " text-primary";
      }

      return retval;
    },
    async onSubmit() {
      // if(this.form.program_type == 0) this.form.program_status = 0;

      await this.getData();
      // Update statusa
      this.updateProgramStatuses();
    },
    updateProgramStatuses() {
      this.programStatuses.length = 0;
      this.programStatuses.push({ value: 0, text: "Po statusu" });

      this.programStatuses.push({ value: -1, text: "U PROGRAMU" });
      this.programStatuses.push({ value: -2, text: "ODBIJEN" });
      this.programStatuses.push({ value: -3, text: "PREKID" });
      this.programStatuses.push({ value: -4, text: "KRAJ"});
      this.programStatuses.push({ value: -5, text: "ODUSTAO"});

      switch (this.form.program_type) {
        case 2: // RAISING STARTS
          this.programStatuses.push({ value: 1, text: "PRIJAVA" });
          this.programStatuses.push({ value: 2, text: "EVALUACIJA PRIJAVE" });
          this.programStatuses.push({ value: 3, text: "FAZA 1" });
          this.programStatuses.push({ value: 4, text: "DEMO DAY" });
          this.programStatuses.push({ value: 5, text: "UGOVOR" });
          break;
        case 5: // INCUBATION BITF
          this.programStatuses.push({ value: 1, text: "PRIJAVA" });
          this.programStatuses.push({ value: 2, text: "PREDSELEKCIJA" });
          this.programStatuses.push({ value: 3, text: "SELEKCIJA" });
          this.programStatuses.push({ value: 4, text: "UGOVOR" });
          break;
        default:
          break;
      }
    },
    // pageChanged(ctx) {
    //   console.log(`Page changed ${this.currentPage}`);
    //   let data = new FormData();
    //   data.append("page", this.currentPage);
    //   axios.post("/profiles/setSessionVars", data).then((response) => {
    //     console.log("Page changed ...");
    //     console.log(response.data);
    //   });
    // },
  },
  async mounted() {
    this.form.name = this.f_name;
    this.form.program_type = this.f_program_type;
    this.form.program_status = this.f_program_status;

    await this.getData();
    this.updateProgramStatuses();

    this.currentPage = this.f_page;
  },
  data() {
    return {
      programs: [],
      currentPage: 1,
      form: {
        name: "",
        program_type: 0,
        program_status: 0,
        year: 2023,
      },
      programTypes: [
        { value: 0, text: "Po tipu" },
        { value: 2, text: "RAISING STARTS" },
        { value: 5, text: "INCUBATION BITF" },
      ],
      programStatuses: [
        { value: 0, text: "Po statusu" },
        { value: -1, text: "Aktivan" },
        { value: -2, text: "Odbijena prijava" },
        { value: -3, text: "Suspendovan" },
        { value: -4, text: "Kraj programa"},
        { value: -5, text: "Odustao"},
        { value: 1, text: "Prijava/Selekcija/Ugovor" },
      ],
      years: [
        { value: 0, text: "Po godini" },
        { value: 2022, text: "2022" },
        { value: 2023, text: "2023" }
      ],
      fields: [
        {
          key: "company",
          label: "Kompanija",
          sortable: true,
        },
        {
          key: "type",
          label: "Program",
          sortable: true,
        },
        {
          key: "status",
          label: "Status",
          sortable: true,
        },
        {
           key: "year",
           label: "Godina",
           sortable: true,
        }
      ],
    };
  },
};
</script>

<style scoped></style>
