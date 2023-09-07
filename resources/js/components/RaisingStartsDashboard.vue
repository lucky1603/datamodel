<template>
  <div>
    <b-row>
        <b-col>
            <div class="d-flex flex-row w-100 my-1 mx-2">
                <label style="width: 100px; padding: 7px">Godina: </label>
                <b-form-select v-model="year" :options="years" @change="selectionChanged" style="width: 150px"></b-form-select>
            </div>
        </b-col>
        <b-col>
            <b-button variant="outline-secondary" @click="myExport" class="float-right my-1"><i class="dripicons-export"></i> {{ _('gui.rs_dashboard_export') }}</b-button>
        </b-col>
    </b-row>
    <basic-dashboard :program_type="program_type" :token="token" :year="year"></basic-dashboard>
    <div v-if="program_type == 2" class="d-flex flex-wrap">
      <h5 class="mr-2 mt-0 pt-0 attribute-label">
        {{ _("gui.rs_dashboard_additional_statistics") }}
      </h5>
      <div class="d-flex">
        <b-form-checkbox v-model="bInnovation" name="check-button" switch class="mr-2">
          {{ _("gui.rs_dashboard_innovation") }}
        </b-form-checkbox>
      </div>
      <div class="d-flex">
        <b-form-checkbox
          v-model="bTechDevelopment"
          name="check-button"
          switch
          class="mr-2"
        >
          {{ _("gui.rs_dashboard_tech_progress_phase") }}
        </b-form-checkbox>
      </div>
      <div class="d-flex">
        <b-form-checkbox
          v-model="bBusinessDevelopment"
          name="check-button"
          switch
          class="mr-2"
        >
          {{ _("gui.rs_dashboard_bus_progress_phase") }}
        </b-form-checkbox>
      </div>
      <div class="d-flex">
        <b-form-checkbox v-model="bWayOfFinding" name="check-button" switch class="mr-2">
          {{ _("gui.rs_dashboard_way_of_finding_out") }}
        </b-form-checkbox>
      </div>
      <div class="d-flex">
        <b-form-checkbox
          v-model="bIntellectualProperty"
          name="check-button"
          switch
          class="mr-2"
        >
          {{ _("gui.rs_dashboard_intellectual_property") }}
        </b-form-checkbox>
      </div>
      <div class="d-flex">
        <b-form-checkbox
          v-model="bBusinessBranch"
          name="check-button"
          switch
          class="mr-2"
        >
          {{ _("gui.rs_dashboard_field_of_product_service") }}
        </b-form-checkbox>
      </div>
      <div class="d-flex">
        <b-form-checkbox v-model="bProductType" name="check-button" switch class="mr-2">
          {{ _("gui.rs_dashboard_type_of_product_service") }}
        </b-form-checkbox>
      </div>
      <div class="d-flex">
        <b-form-checkbox
          v-model="bMunicipalityDistribution"
          name="check-button"
          switch
          class="mr-2"
        >
          {{ _("gui.rs_dashboard_municipality_distribution") }}
        </b-form-checkbox>
      </div>
    </div>
    <div v-if="program_type == 2" class="d-flex flex-wrap mt-2 mx-0 p-0">
      <find-criteria
        v-if="bInnovation"
        :title="_('gui.rs_dashboard_innovation_text')"
        source="/analytics/splitOptions/how_innovative"
        class="mr-3"
        style="max-width: 335px"
        :year="year"
      >
      </find-criteria>
      <find-criteria
        v-if="bTechDevelopment"
        :title="_('gui.rs_dashboard_tech_progress_phase_text')"
        source="/analytics/splitOptions/dev_phase_tech"
        class="mr-3"
        style="max-width: 335px"
        :year="year"
      >
      </find-criteria>
      <find-criteria
        v-if="bBusinessDevelopment"
        :title="_('gui.rs_dashboard_bus_progress_phase_text')"
        source="/analytics/splitOptions/dev_phase_business"
        class="mr-3"
        style="max-width: 335px"
        :year="year"
      >
      </find-criteria>
      <find-criteria
        v-if="bWayOfFinding"
        :title="_('gui.rs_dashboard_way_of_finding_out_text')"
        source="/analytics/splitOptions/howdiduhear"
        class="mr-3"
        style="max-width: 335px"
        :year="year"
      ></find-criteria>
      <find-criteria
        v-if="bIntellectualProperty"
        :title="_('gui.rs_dashboard_intellectual_property_text')"
        source="/analytics/splitOptions/intellectual_property"
        class="mr-3"
        style="max-width: 335px"
        :year="year"
      >
      </find-criteria>
      <find-criteria
        v-if="bBusinessBranch"
        :title="_('gui.rs_dashboard_field_of_product_service_text')"
        source="/analytics/splitOptions/innovative_area"
        class="mr-3"
        style="max-width: 335px"
        :year="year"
      >
      </find-criteria>
      <find-criteria
        v-if="bProductType"
        :title="_('gui.rs_dashboard_type_of_product_service_text')"
        source="/analytics/splitOptions/product_type"
        class="mr-3"
        style="max-width: 335px"
        :year="year"
      >
      </find-criteria>
      <find-criteria
        v-if="bMunicipalityDistribution"
        :title="_('gui.rs_dashboard_municipality_distribution_text')"
        :source="opstineSource"
        class="mr-3"
        style="max-width: 335px"
        :year="year"
      >
      </find-criteria>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import BasicDashboard from "./BasicDashboard.vue";
export default {
  components: { BasicDashboard },
  name: "RaisingStartsDashboard",
  props: {
    token: { typeof: String, default: "" },
  },
  computed: {
    opstineSource() {
        return "/analytics/splitPoOpstinama/" + this.program_type;
    }
  },
  methods: {
    selectionChanged() {
        Dispecer.$emit('refresh-components');
    },
    async myExport() {
        location.href = "/analytics/exportRaisingStartsDashboard/" + this.year;
    }
  },
  async mounted() {},
  data() {
    return {
      bInnovation: false,
      bTechDevelopment: false,
      bBusinessDevelopment: false,
      bWayOfFinding: false,
      bIntellectualProperty: false,
      bBusinessBranch: false,
      bProductType: false,
      bMunicipalityDistribution: false,
      year: 2023,
      years: [
        { value: 0, text: 'SVE'},
        { value: 2022, text: '2022'},
        { value: 2023, text: '2023'},
        { value: 2024, text: '2024'},
      ],
      program_type: 2,
      programTypes: [
        { value: 2, text: 'RAISING STARTS' },
        { value: 5, text: 'INCUBATION BITF' },
        { value: 4, text: 'GROWING COMPANIES'}
      ]
    };
  },
};
</script>

<style scoped></style>
