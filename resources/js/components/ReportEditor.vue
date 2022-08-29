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
              action="#" @submit.prevent="onSubmit">
              <input type="hidden" name="_token" :value="token">
              <div class="form-group">
                  <label class="attribute-label">Naziv izveštaja</label>
                  <b-form-input v-model="form.title" placeholder="Unesite naziv izveštaja ..." :disabled="this.report_id != 0"></b-form-input>
              </div>
              <div class="form-group mb-2">
                  <label class="attribute-label">Datum očekivanog slanja</label>
                  <!-- <b-form-input type="date" v-model="form.contract_check" :disabled="this.report_id != 0"></b-form-input> -->
                  <b-form-datepicker v-model="form.contract_check" :disabled="this.report_id != 0"></b-form-datepicker>
              </div>

              <div style="margin-left: 10vw; margin-right: 10vw; padding-top: 5vh">
                  <file-group-viewer
                      v-for="(fileGroup, index) in this.form.fileGroups"
                      :file_group="fileGroup"
                      :index="index + 1" :key="index" class="m-2 shadow" >
                  </file-group-viewer>
              </div>

              <div v-if="user_role === 'profile' && this.report_status <= 3" class="d-flex align-items-center justify-content-center">
                  <button   id="btnAddMember" type="button" class="btn btn-success rounded-circle mt-4" title="Dodaj izveštaj" @click="showModal">+</button>
              </div>

              <div v-if="report_id != 0 && user_role != 'profile'" class="form-group d-flex flex-wrap align-items-center justify-content-center mt-4" >

                      <b-form-checkbox
                          id="chkTechFulfilled"
                          v-model="form.tech_fulfilled"
                          name="chkTechFulfilled"
                          value="on"
                          unchecked-value="off" :disabled="form.fileGroups.length == 0" class="mx-4 my-2"
                      >
                          <span class="attribute-label">Ispunjeni tehnički uslovi</span>
                      </b-form-checkbox>


                      <b-form-checkbox
                          id="chkBusinessFulfilled"
                          v-model="form.business_fulfilled"
                          name="chkBusinessFulfilled"
                          value="on"
                          unchecked-value="off" :disabled="form.fileGroups.length == 0" class="mx-4 my-2"
                      >
                          <span class="attribute-label">Ispunjeni poslovni uslovi</span>
                      </b-form-checkbox>


                      <b-form-checkbox
                          id="chkNarativeApproved"
                          v-model="form.narative_approved"
                          name="chkNarativeApproved"
                          value="on"
                          unchecked-value="off" :disabled="form.fileGroups.length == 0" class="mx-4 my-2"
                      >
                          <span class="attribute-label">Odobren narativ</span>
                      </b-form-checkbox>

                      <b-form-checkbox
                          id="chkReportApproved"
                          v-model="form.report_approved"
                          name="chkReportApproved"
                          value="on"
                          unchecked-value="off" :disabled="form.fileGroups.length == 0" class="mx-4 my-2"
                      >
                          <span class="attribute-label">Odobren izveštaj</span>
                      </b-form-checkbox>

              </div>
              <div class="d-flex align-items-center justify-content-center mt-4">
                  <b-button v-if="user_role != 'profile'" type="submit" variant="primary" class="mr-2">Pošalji</b-button>
                  <b-button type="button" variant="danger" @click="cancelClicked">Zatvori</b-button>
              </div>

              <b-modal id="addReportModal" ref="addReportModal" header-bg-variant="dark" header-text-variant="light" >
                  <template #modal-title>Dodaj izvestaj</template>
                  <file-group-editor ref="fed" :show_buttons="false" :token="token" :report_id="report_id"></file-group-editor>
                  <template #modal-footer>
                      <b-button type="button" variant="primary" @click="onOk">Prihvati</b-button>
                      <b-button type="button" variant="danger" @click="onCancel">Odustani</b-button>
                  </template>
              </b-modal>
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
        token: { typeof: String, default: '' },
        user_role: { typeof: String, default: 'profile'}
    },
    computed: {
        action() {
            if(this.report_id != 0) {
                return '/reports/'+this.report_id;
            } else {
                return '/reports/create/'+this.program_id;
            }
        },
        canSend() {
            return true;
        }
    },
    methods: {
        async getData() {
            await axios.get(`/reports/getData/${this.report_id}`)
            .then(response => {
                console.log(response.data);

                let report = response.data;
                this.report_status = report.status;
                this.form.title = report.report_name;
                this.form.contract_check = report.contract_check;
                if(report.file_groups.length > 0) {
                    for(let i = 0; i < report.file_groups.length; i++) {
                        const fg = report.file_groups[i];
                        this.form.fileGroups.push({
                            id: fg.id,
                            name: fg.name,
                            note: fg.note,
                            files: fg.files
                        });
                    }

                }
                this.form.tech_fulfilled = report.tech_fulfilled ? 'on' : 'off';
                this.form.business_fulfilled = report.business_fulfilled ? 'on': 'off';
                this.form.narative_approved = report.narative_approved ? 'on': 'off';
                this.form.report_approved = report.report_approved ? 'on': 'off';

            })
        },
        cancelClicked() {
            window.location.href=`/reports/programReports/${this.program_id}`;
        },
        onSubmit() {
            let data = new FormData();
            for(let property in this.form) {
                if(property == 'fileGroups' ) {
                    continue;
                } else {
                    data.append(property, this.form[property]);
                }
            }

            data.append('_token', this.token);

            axios.post(this.action, data)
            .then(response => {
                console.log(response.data);
                window.location.href='/reports/programReports/' + this.program_id;
            });
        },
        async showModal() {
            this.$refs['addReportModal'].show();
        },
        async onOk() {
            await this.$refs.fed.onSubmit();
            this.$refs['addReportModal'].hide();
            location.reload();
        },
        onCancel() {
            this.$refs['addReportModal'].hide();
        }
    },
    async mounted() {
        if(this.report_id != 0) {
            await this.getData();
        }

    },
    data() {
        return {
            contract_start: '26.01.2022.',
            contract_check: '2022-03-26',
            form: {
                title: '',
                tech_fulfilled: 'off',
                business_fulfilled: 'off',
                narative_approved: 'off',
                report_approved: 'off',
                fileGroups: []
            },
            report_status: 0
        }
    }
}
</script>

<style scoped>

</style>
