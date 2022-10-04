<template>
  <div>
    <basic-dashboard :program_type="program_type" :token="token"></basic-dashboard>
    <div class="d-flex flex-wrap mt-2 mx-0 p-0">
      <find-criteria
        v-if="bInnovation"
        title="KOLIKO JE INOVATIVAN VAŠ PROIZVOD/USLUGA?"
        source="/analytics/splitOptions/how_innovative"
        class="mr-3"
        style="max-width: 335px"
      >
      </find-criteria>
      <find-criteria
        v-if="bTechDevelopment"
        title="Faza razvoja - Tehnološki razvoj"
        source="/analytics/splitOptions/dev_phase_tech"
        class="mr-3"
        style="max-width: 335px"
      >
      </find-criteria>
      <find-criteria
        v-if="bBusinessDevelopment"
        title="Faza razvoja - Poslovni razvoj"
        source="/analytics/splitOptions/dev_phase_business"
        class="mr-3"
        style="max-width: 335px"
      >
      </find-criteria>
      <find-criteria
        v-if="bWayOfFinding"
        title="Kako ste nas našli?"
        source="/analytics/splitOptions/howdiduhear"
        class="mr-3"
        style="max-width: 335px"
      ></find-criteria>
      <find-criteria
        v-if="bIntellectualProperty"
        title="Da li ste sprovodili neke aktivnosti u cilju zaštite prava intelektualne svojine?"
        source="/analytics/splitOptions/intellectual_property"
        class="mr-3"
        style="max-width: 335px"
      >
      </find-criteria>
      <find-criteria
        v-if="bBusinessBranch"
        title="Kojoj oblasti pripada inovativni proizvod i/ili usluga koju razvijate?"
        source="/analytics/splitOptions/how_innovative"
        class="mr-3"
        style="max-width: 335px"
      >
      </find-criteria>
      <find-criteria
        v-if="bProductType"
        title="Tip prozvoda ili usluge"
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
