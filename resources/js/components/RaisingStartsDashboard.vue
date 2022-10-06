<template>
  <div>
    <basic-dashboard :program_type="program_type" :token="token"></basic-dashboard>
    <div class="d-flex flex-wrap">
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
    </div>
    <div class="d-flex flex-wrap mt-2 mx-0 p-0">
      <find-criteria
        v-if="bInnovation"
        :title="_('gui.rs_dashboard_innovation_text')"
        source="/analytics/splitOptions/how_innovative"
        class="mr-3"
        style="max-width: 335px"
      >
      </find-criteria>
      <find-criteria
        v-if="bTechDevelopment"
        :title="_('gui.rs_dashboard_tech_progress_phase_text')"
        source="/analytics/splitOptions/dev_phase_tech"
        class="mr-3"
        style="max-width: 335px"
      >
      </find-criteria>
      <find-criteria
        v-if="bBusinessDevelopment"
        :title="_('gui.rs_dashboard_bus_progress_phase_text')"
        source="/analytics/splitOptions/dev_phase_business"
        class="mr-3"
        style="max-width: 335px"
      >
      </find-criteria>
      <find-criteria
        v-if="bWayOfFinding"
        :title="_('gui.rs_dashboard_way_of_finding_out_text')"
        source="/analytics/splitOptions/howdiduhear"
        class="mr-3"
        style="max-width: 335px"
      ></find-criteria>
      <find-criteria
        v-if="bIntellectualProperty"
        :title="_('gui.rs_dashboard_intellectual_property_text')"
        source="/analytics/splitOptions/intellectual_property"
        class="mr-3"
        style="max-width: 335px"
      >
      </find-criteria>
      <find-criteria
        v-if="bBusinessBranch"
        :title="_('gui.rs_dashboard_type_of_product_service_text')"
        source="/analytics/splitOptions/how_innovative"
        class="mr-3"
        style="max-width: 335px"
      >
      </find-criteria>
      <find-criteria
        v-if="bProductType"
        :title="_('gui.rs_dashboard_field_of_product_service_text')"
        source="/analytics/splitOptions/product_type"
        class="mr-3"
        style="max-width: 335px"
      >
      </find-criteria>
    </div>
  </div>
</template>

<script>
import BasicDashboard from "./BasicDashboard.vue";
export default {
  components: { BasicDashboard },
  name: "RaisingStartsDashboard",
  props: {
    program_type: { typeof: Number, default: 0 },
    token: { typeof: String, default: "" },
  },
  methods: {},
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
    };
  },
};
</script>

<style scoped></style>
