<template>
  <div class="row border border-secondary" style="width: 400px; height: 120px;" role="button" @click="onClick">
      <div class="col-2 d-flex flex-column justify-content-center align-items-center">
          <span class="display-3">{{ order_number }}</span>
      </div>
      <div class="col-8 d-flex flex-column align-items-center justify-content-center bg-dark text-light">
          <div class="d-flex justify-content-center">
              <h4>{{ upper_cell }}</h4>
          </div>
          <div class="d-flex justify-content-center">
              <span class="font-10">{{ lower_cell }}</span>
          </div>
      </div>
      <div class="col-2 d-flex flex-column align-items-center justify-content-center">
          <span class="font-10">STATUS</span>
          <img :src="iconSource" style="width: 48px; height: 48px" :title="iconText">
      </div>
  </div>
</template>

<script>
export default {
    name: "ReportItem",
    props: {
        order_number: { typeof: Number, default: 1 },
        upper_cell: { typeof: String, default: 'Upper cell content'},
        lower_cell: { typeof: String, default: 'Lower cell content'},
        status: { typeof: Number, default: 1},
        report_id: { typeof: Number, default: 0 }
    },
    computed: {
        iconSource() {
            switch(this.status) {
                case 0:
                    return '/images/custom/scheduled.png';
                case 1:
                    return '/images/custom/upozorenje.png';
                case 2:
                    return '/images/custom/poslao.png';
                default:
                    return '/images/custom/zakasnio.png';
            }
        },
        iconText() {
            switch(this.status) {
                case 0:
                    return 'Zakazan';
                case 1:
                    return 'Upozorenje';
                case 2:
                    return 'Poslat';
                default:
                    return 'Zakasnio';
            }
        }
    },
    methods: {
        onClick() {
            window.location.href = '/reports/'+this.report_id;
        }
    }
}
</script>

<style scoped>

</style>
