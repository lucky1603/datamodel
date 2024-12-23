<template>
  <div @key.down.escape="escapeClicked">    
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
        <b-col xl="2" lg="2" clas="border border-danger" style="display: flex; justify-content: left">
          <b-form-select
            size="sm"
            class="m-2 w-100"
            v-model="form.year"
            :options="years"
            @change="onSubmit"
          ></b-form-select>
        </b-col>
        <!-- <b-col xl="2" lg="2">
            <button>Sravnjivanje</button>
        </b-col> -->
        <b-col xl="3" lg="2" class="d-flex flex-row flex-lg-row-reverse">

            <a
                href="/profiles/exportRaisingStarts"
                role="button"
                style="top: 5px"
                class="btn btn-sm text-secondary m-2 position-relative float-right"
                ><i class="dripicons-export"></i> EXPORT
            </a>
            <a
                v-if="showReject"
                href=""
                role="button"
                class="btn btn-sm btn-success m-2 position-relative float-right" :title="_('gui.program_explorer_cancel_unsent_info')" @click.prevent="sravnjivanje"
                ><i class="mdi mdi-file-cancel-outline"></i><span class="ml-2 mt-2">{{ _('gui.CancelNotSent') }}</span><b-spinner v-if="sendReject" small class="ml-2"></b-spinner>
            </a>

        </b-col>
      </b-row>
    </b-form>
    <div v-if="selectedPrograms.length > 0" class="d-flex justify-content-between shadow my-2 p-1 bg-light" >
      <div class="d-flex align-items-center justify-content-left">
        <span class="h5">AKCIJE ZA SELEKTOVANE:</span>
      </div>  
      <div class="d-flex align-items-center justify-content-left">        
        <b-button variant="success" class="m-1 float-right" @click="sravnjivanje" size="sm" title="Zaključavanje - svi koji nisu poslali prijave prebacuju se u status - odustali">
          <b-spinner v-if="sendReject" small class="ml-2"></b-spinner>
          <i class='mdi mdi-lock'></i>        
        </b-button>
        <b-button variant="danger" class="m-1 float-right" @click="showMultipleDeletionDialog" size="sm" title="Obriši selektovane programe iz baze">
          <i class='mdi mdi-trash-can'></i>
        </b-button>
        <b-button variant="info" class="m-1 float-right" size="sm" title="Pošalji podsetnike" @click="sendBulkMail">
          <i class='mdi mdi-email-outline'></i>
        </b-button>

      </div>      
    </div>
    <b-table
      :key="componentKey"
      ref="programTable"
      selectable
      select-mode="range"
      :items="programs"
      :fields="fields"
      :per-page="page_size"
      :current-page="currentPage"
      head-variant="dark"
      small
      bordered
      class="shadow-sm"
      @page-click="pageChanged"      
      @row-selected="onRowSelected"
      @key-down.escape="escapeClicked"
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
      <template #cell(action)="data">
        <div class="d-flex align-items-center justify-content-center">
          <a @click.prevent="rowClicked1(data.item.id)" role="button" class="mx-1" :title="_('gui.profile_table_edit_profile')"><i class='mdi mdi-magnify font-20'></i></a>
          <a v-if="canDelete" @click.prevent="deleteProgram(data.item.id, data.item.company)" role="button" class="mx-1" :title="_('gui.profile_table_delete_profile')"><i class='mdi mdi-trash-can-outline font-20'></i></a>
        </div>
      </template>
    </b-table>
    <b-pagination
      v-model="currentPage"
      :total-rows="programs.length"
      :per-page="page_size"
      aria-controls="profileTable"
      align="right"
    ></b-pagination>
    <b-modal
        ref="sravnjivanje-modal"
        id="sravnjivanje-modal"
        header-bg-variant="dark"
        header-text-variant="light"
        @ok="handleOk">
        <template #modal-title>{{ _('gui.program_explorer_dialog_title') }}</template>
        <template #modal-ok>{{ _('gui.Ok') }}</template>
        <template #modal-cancel>{{ _('gui.Cancel') }}</template>
        <div class="d-flex align-items-center justify-content-center">
            {{ rejectDialogMessage }}
        </div>
    </b-modal>
    <b-modal
      size="xl"
      v-model="showBulkMailDialog"
      ref="bulkMailDialog"
      id="bulkMailDialog"
      header-bg-variant="dark"
      header-text-variant="light" @ok="confirmSendMail">
      <template #modal-title>Posalji email</template>
      <template #modal-ok>{{ _('gui.Send') }}</template><template #modal-cancel>{{ _('gui.Cancel') }}</template>
      <div class="d-flex align-items-center justify-content-center">
        <bulk-mail ref="bulkMail" :recipients="emailRecipients" items_source="" :content="mailContent" :hide-buttons="true" :token="token" send-action="/programs/bulkMail">
        </bulk-mail>
      </div>
      
    </b-modal>
    <b-modal v-model="showDeleteDialog" id="deleteDialog" header-bg-variant="dark" header-text-variant="light" @ok="confirmDeleteProgram" >
      <template #modal-title>{{ _('gui.program_explorer_delete_program') }}</template>
      <template #modal-ok>{{ _('gui.Ok') }}</template>
      <template #modal-cancel>{{ _('gui.Cancel') }}</template>
      <div class="d-flex align-items-center justify-content-start">
        <span>{{ _('gui.program_explorer_delete_program') + " "}}</span> <span class="mx-1"><strong> '{{ selectedProgramName }}'</strong>?</span>
      </div>
    </b-modal>
    <b-modal v-model="showMultipleDeleteDialog" id="multipleDeleteDialog" header-bg-variant="dark" header-text-variant="light" @ok="deleteSelected">
      <template #modal-title>{{ _('gui.program_explorer_delete_programs') }}</template>
      <template #modal-ok>{{ _('gui.Ok') }}</template>
      <template #modal-cancel>{{ _('gui.Cancel') }}</template>
      <div class="d-flex align-items-center justify-content-start">
        <span>{{ _('gui.program_explorer_delete_programs') }}?</span>
      </div>
    </b-modal>
  </div>
</template>

<script>
import BulkEmail from './BulkEmail.vue';

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
    f_year: { typeof: Number, default: 0 },
    showReject: { type: Boolean, default: true },
    canDelete: { type: Boolean, default: true },
    token: { typeof: String, default: "" },
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
    onRowSelected(items) {
      this.selectedPrograms = items;
    },
    async handleOk() {
        this.sendReject = true;
        if(this.selectedPrograms.length > 0) {
          let data = new FormData();
          for (let i = 0; i < this.selectedPrograms.length; i++) {
            data.append('ids[]', this.selectedPrograms[i].id);
          }

          await axios.post('/programs/rejectSelected', data)
          .then(response => {
            this.sendReject = false;
            this.$refs.programTable.clearSelected();
          });     
        } else {
          await axios.get('/programs/rejectUnsent')
          .then(response => {
              this.sendReject = false;
          });
        }
        

        await this.getData();
    },
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
            let program = response.data[property];
            program.selected = false;
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
    rowClicked1(id) {
      window.location.href='/programs/' + id;
    },
    deleteProgram(id, name) {
      this.selectedProgramId = id;
      this.selectedProgramName = name;
      this.showDeleteDialog = true;
      
    },
    async confirmDeleteProgram() {
      await axios.get('/programs/delete/' + this.selectedProgramId);
      this.selectedProgramId = 0;
      this.selectedProgramName = '';
      await this.getData();
    },
    async confirmSendMail() {
      await this.$refs.bulkMail.onSubmit();
      this.$refs.programTable.clearSelected();

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
    sravnjivanje() {
        if(this.selectedPrograms.length == 0) {
          this.rejectDialogMessage = window.i18n['gui']['program_explorer_dialog_text'];
        } else {
          this.rejectDialogMessage = window.i18n['gui']["program_explorer_dialog_text_selected_reject"];
        }
        
        this.$refs['sravnjivanje-modal'].show();
    },
    showMultipleDeletionDialog() {
      if(this.selectedPrograms.length == 0) {
        return;
      }

      this.showMultipleDeleteDialog = true;
    },
    async deleteSelected() {
      let data = new FormData();
      for (let i = 0; i < this.selectedPrograms.length; i++) {
        data.append('ids[]', this.selectedPrograms[i].id);
      }

      await axios.post('/programs/deleteSelected', data);

      this.$refs.programTable.clearSelected();
      await this.getData();
      // this.componentKey += 1;
    },
    escapeClicked() {
      cvonsole.log('escape');
      this.$refs.programTable.clearSelected();
    },

    handleKeyDown(event) {
      if(event.key == 'Escape' || event.keycode == 27) {
        console.log('escape');
        this.$refs.programTable.clearSelected();
      }
    },
    sendBulkMail() {
      this.selectedPrograms.forEach(program => {
        this.emailRecipients.push({
          value: program.id,
          text: program.company,
          selected: true
        });
      });

      this.showBulkMailDialog = true;
    }

  },

  async mounted() {
    this.form.name = this.f_name;
    this.form.program_type = this.f_program_type;
    this.form.program_status = this.f_program_status;
    this.form.year = this.f_year;

    await this.getData();
    this.updateProgramStatuses();
    this.currentPage = this.f_page;

    this.mailContent = "<p>Poštovani/a ,</p><p>Uskoro ističe rok za slanje prijava na program 'Raising Starts'.</p><p>Podsećamo Vas, da Vašu prijavu možete poslati najkasnije do 28.12. u 12:00h. Sve prijave poslate posle tog roka neće biti uzete u razmatranje.</p><p>Srdačan pozdrav,</p><p>Vaš NTP</p>";

    window.addEventListener('keydown', this.handleKeyDown);
  },
  data() {
    return {
      componentKey: 0,
      showMultipleDeleteDialog: false,
      showBulkMailDialog: false,
      mailContent: '',
      emailRecipients: [],
      rejectDialogMessage: 'Poruka',
      selectedPrograms: [],
      selectedProgramId: 0,
      selectedProgramName: '',
      showDeleteDialog: false,
      deleteDialogMessage: 'Naslov',
      sendReject: false,
      programs: [],
      currentPage: 1,
      form: {
        name: "",
        program_type: 0,
        program_status: 0,
        year: 2024,
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
        { value: 2023, text: "2023" },
        { value: 2024, text: "2024"},
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
        },
        {
          key: "action",
          label: "Akcija",
        }
      ],
    };
  },
};
</script>

<style scoped></style>
