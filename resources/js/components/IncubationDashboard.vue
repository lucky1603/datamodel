<template>
  <div>
    <basic-dashboard :program_type="program_type" :token="token"></basic-dashboard>
  </div>
</template>

<script>
export default {
  name: "IncubationDashboard",
  props: {
    program_type: { typeof: Number, default: 0 },
    token: { typeof: String, default: "" },
  },
  data() {
    return {};
  },

  mounted() {},

  methods: {},
};
</script>

<style lang="scss" scoped></style>
