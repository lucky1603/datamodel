<template>
  <div class="row border border-secondary" style="width: 400px; height: 80px;" role="button" @click="onClick">
      <div class="col-2 d-flex flex-column justify-content-center align-items-center">
          <span class="display-4">{{ order_number }}</span>
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
          <img :src="iconSource"  :title="iconText">
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
                    return '/images/custom/izvestaj-zakazan.png';
                case 1:
                    return '/images/custom/izvestaj-upozorenje.png';
                case 2:
                    return '/images/custom/envelope24-icon.png';
                case 3:
                    return '/images/custom/izvestaj-kasnjenje.png';
                case 4:
                    return '/images/custom/izvestaj-poslato.png';
                default:
                    return '/images/custom/attention-icon.png';
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
                case 3:
                    return 'Zakasnio';
                case 4:
                    return 'Prihvaćen';
                default:
                    return "Odbijen";
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
