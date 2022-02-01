<template>
  <div class="card">
      <div class="card-header bg-dark text-light">
          <span v-if="report_id == 0" class="h4">KREIRAJ NOVI IZVEŠTAJ</span>
          <span v-else class="h4">PRIPREMI IZVEŠTAJ ZA SLANJE</span>
      </div>
      <div class="card-body">
          <form
              :id="form_id"
              :ref="form_id"
              method="POST"
              enctype="multipart/form-data"
              action="#">
              <input type="hidden" name="_token" :value="token">
              <div class="form-group">
                  <label class="attribute-label">Naziv izveštaja</label>
                  <b-form-input v-model="form.title" placeholder="Unesite naziv izveštaja ..."></b-form-input>
              </div>
              <div class="form-group">
                  <label class="attribute-label">Opis iveštaja</label>
                  <b-form-textarea v-model="form.description" placeholder="Opis izveštaja ..." rows="3" max-rows="6"></b-form-textarea>
              </div>
              <div class="form-group">
                  <label class="attribute-label">Datum slanja</label>
                  <b-form-input type="date" v-model="form.contract_check"></b-form-input>
              </div>
              <div class="form-group">
                  <label class="attribute-label">Priložite datoteke</label>
                  <b-form-file
                      v-model="file1"
                      :state="null"
                      placeholder="Izaberite datoteke ili ih prevucite ovde..."
                      drop-placeholder="Prevucite datoteke ovde..." multiple
                  ></b-form-file>
              </div>
              <div v-if="form.links.length > 0" style="display: flex; flex-wrap: wrap">
                  <a v-for="link in form.links" :href="link.filelink" target="_blank" class="mr-2">{{ link.filename }}</a>
              </div>
              <div class="form-group row mt-4">
                  <div class="col-lg-3">
                      <b-form-checkbox
                          id="chkTechFulfilled"
                          v-model="form.tech_fulfilled"
                          name="chkTechFulfilled"
                          value="on"
                          unchecked-value="off"
                      >
                          <span class="attribute-label">Ispunjeni tehnički uslovi</span>
                      </b-form-checkbox>
                  </div>
                  <div class="col-lg-3">
                      <b-form-checkbox
                          id="chkBusinessFulfilled"
                          v-model="form.business_fulfilled"
                          name="chkBusinessFulfilled"
                          value="on"
                          unchecked-value="off"
                      >
                          <span class="attribute-label">Ispunjeni poslovni uslovi</span>
                      </b-form-checkbox>
                  </div>
                  <div class="col-lg-2">
                      <b-form-checkbox
                          id="chkNarativeApproved"
                          v-model="form.narative_approved"
                          name="chkNarativeApproved"
                          value="on"
                          unchecked-value="off"
                      >
                          <span class="attribute-label">Odobren narativ</span>
                      </b-form-checkbox>
                  </div>
                  <div class="col-lg-2">
                      <b-form-checkbox
                          id="chkReportApproved"
                          v-model="form.report_approved"
                          name="chkReportApproved"
                          value="on"
                          unchecked-value="off"
                      >
                          <span class="attribute-label">Odobren izveštaj</span>
                      </b-form-checkbox>
                  </div>
              </div>
              <b-button type="submit" variant="primary">Submit</b-button>
              <b-button type="button" variant="danger" @click="cancelClicked">Cancel</b-button>

          </form>
      </div>
  </div>
</template>

<script>
export default {
    name: "ReportEditor",
    props: {
        report_id: { typeof: Number, default: 0 },
        program_id: { typeof: Number, default: 0 },
        form_id: { typeof: String, default: 'editReportForm' },
        token: { typeof: String, default: '' }
    },
    methods: {
        async getData() {
            await axios.get(`/reports/getData/${this.report_id}`)
            .then(response => {
                console.log(response.data);

                let report = response.data;
                this.form.title = report.report_name;
                this.form.description = report.report_description;
                this.form.contract_check = report.contract_check;
                if(report.attachments.length > 0) {
                    for(let i = 0; i < report.attachments.length; i++) {
                        this.form.links.push({
                            filename: report.attachments[i].filename,
                            filelink: report.attachments[i].filelink
                        });
                    }

                }

            })
        },
        cancelClicked() {
            window.location.href=`/reports/programReports/${this.program_id}`;
        }
    },
    async mounted() {
        await this.getData();
    },
    data() {
        return {
            contract_start: '26.01.2022.',
            contract_check: '2022-03-26',
            form: {
                files: [],
                title: { typeof: String, default: 'PRVI IZVEŠTAJ'},
                description: { typeof: String, default: 'Ovo je prvi izvestaj koji se salje posle 2 meseca.'},
                tech_fulfilled: 'off',
                business_fulfilled: 'off',
                narative_approved: 'off',
                report_approved: 'off',
                links: []
            }
        }
    }
}
</script>

<style scoped>

</style>
