<template>
  <div class="card">
    <div class="card-header bg-dark text-light">
      <span class="float-left h4">{{ eventTypeDescription }} - </span>
      <span :class="eventStatusClass">{{ eventStatusText }}</span>
      <b-button
        v-if="program_id === 0"
        variant="success"
        class="float-right"
        @click="onEdit"
        ><i class="mdi mdi-pencil"></i
      ></b-button>
      <div v-else class="d-inline float-right">
        <span :class="attendanceStatusClass">{{ attendanceStatusText }}</span>
        <span v-if="company != ''" class="h4 float-right mr-1">{{ company }} - </span>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-2">
          <div
            class="d-flex flex-column align-items-start justify-content-center shadow-sm"
          >
            <img :src="eventTypeImage" class="w-100" />
            <span class="w-100 text-center py-2 attribute-label font-weight-bold">{{
              eventTypeDescription
            }}</span>
          </div>
        </div>
        <div class="col-lg-10">
          <div class="row">
            <div class="col-lg-9">
              <div class="d-flex flex-column">
                <label class="attribute-label font-italic">Name</label>
                <h4 class="border p-2 mt-0">{{ training.training_name }}</h4>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="d-flex flex-column">
                <label class="attribute-label font-italic">Tip programa</label>
                <h4 class="border p-2 mt-0">{{ programType }}</h4>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-5">
              <div class="d-flex flex-column">
                <label class="attribute-label font-italic">Kad i gde</label>
                <div
                  class="d-flex flex-wrap align-items-center justify-content-center border py-1"
                >
                  <div
                    class="d-inline-flex mx-2 align-items-center"
                    title="Datum početka    "
                  >
                    <i class="mdi mdi-calendar mr-1 attribute-label font-16"></i>
                    <span>{{ training.training_start_date }}</span>
                  </div>
                  <div
                    class="d-inline-flex mx-2 align-items-center"
                    title="Vreme početka"
                  >
                    <i
                      class="mdi mdi-clock-alert-outline mr-1 attribute-label font-16"
                    ></i>
                    <span>{{ training.training_start_time }}</span>
                  </div>
                  <div class="d-inline-flex mx-2 align-items-center" title="Koliko traje">
                    <i class="mdi mdi-timer mr-1 attribute-label font-16"></i>
                    <span>{{ training.training_duration }}</span>
                    <span>{{ training.training_duration_unit }}</span>
                  </div>
                  <div class="d-inline-flex mx-2 align-items-center" title="Lokacija">
                    <i class="dripicons-location mr-1 attribute-label font-16"></i>
                    <span>{{ training.location }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="d-flex flex-column">
                <label class="attribute-label font-italic">Organizator</label>
                <p class="border p-1 mt-0">{{ training.training_host }}</p>
              </div>
            </div>
            <div class="col-lg-2">
              <div class="d-flex flex-column">
                <label class="attribute-label font-italic">Status</label>
                <b-form-select
                  v-model="form.eventStatus"
                  :options="statusOptions"
                ></b-form-select>
              </div>
            </div>
          </div>

          <div class="d-flex flex-column mt-1">
            <label class="attribute-label font-italic">Kratka beleška</label>
            <p class="border p-1 mt-0">{{ training.training_short_note }}</p>
          </div>

          <div
            v-if="
              training != null &&
              training.files.length > 0 &&
              training.files[0].filelink != ''
            "
            class="d-flex flex-wrap justify-content-start align-items-center"
          >
            <span class="attribute-label font-italic mr-2 font-weight-bold"
              >Priloženi fajlovi:</span
            >
            <file-item
              v-for="(file, index) in training.files"
              :filename="file.filename"
              :filelink="file.filelink"
              :key="index"
              :fontsize="14"
              class="mr-2"
            ></file-item>
          </div>
          <div v-else>
            <label class="attribute-label font-italic">Nema priloženih fajlova</label>
          </div>
        </div>
      </div>

      <div class="d-flex flex-column mt-2">
        <label class="attribute-label font-italic">Organizator</label>
        <div
          id="trainingDescriptionHtml"
          class="p-2 overflow-auto border"
          style="height: 15vh"
        ></div>
      </div>

      <div v-if="program_id == 0" class="d-flex flex-column mt-4">
        <h4 class="attribute-label mb-2">POLAZNICI</h4>

        <b-table
          id="attTable"
          :items="form.attendances"
          :fields="fields"
          head-variant="dark"
          :small="true"
          :bordered="true"
          class="shadow-sm"
          :per-page="10"
          :current-page="currentPage"
          :hover="true"
        >
          <template #cell(status)="data">
            <b-form-select
              v-model="data.item.status"
              :options="attendanceOptions"
            ></b-form-select>
          </template>
          <template #cell(company)="data">
            <div class="d-flex">
              <img :src="data.item.company.photo.filelink" width="24px" class="mr-2" />
              {{ data.item.company.name }}
            </div>
          </template>
        </b-table>
        <b-pagination
          v-model="currentPage"
          :total-rows="form.attendances.length"
          :per-page="10"
          aria-controls="attTable"
          align="right"
        ></b-pagination>
      </div>

      <div class="d-flex flex-wrap align-items-center justify-content-center mt-4">
        <b-button
          v-if="program_id == 0"
          variant="primary"
          size="sm"
          class="m-1"
          @click="onOk"
          >Prihvati</b-button
        >
        <b-button variant="outline-primary" size="sm" class="m-1" @click="onCancel"
          >Zatvori</b-button
        >
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "EventForm",
  props: {
    event_id: { typeof: Number, default: 0 },
    backroute: { typeof: String, default: "/trainings" },
    role: { typeof: String, default: "administrator" },
    program_id: { typeof: Number, default: 0 },
  },
  computed: {
    attendanceStatusText() {
      if (this.userAttendance != null) {
        switch (this.userAttendance.attendance) {
          case 1:
            return "POZVAN";
          case 2:
            return "PRISUSTVOVAO";
          default:
            return "NIJE PRISUSTVOVAO";
        }
      }

      return "";
    },
    attendanceStatusClass() {
      let c = "h4 float-right";
      if (this.userAttendance != null) {
        switch (this.userAttendance.attendance) {
          case 1:
            c += " text-secondary";
            break;
          case 2:
            c += " text-success";
            break;
          default:
            c += " text-danger";
            break;
        }
      }

      return c;
    },
    eventTypeDescription() {
      switch (this.eventType) {
        case 1:
          return "RADIONICA";
        case 2:
          return "SESIJA";
        default:
          return "MEETUP";
      }
    },
    eventTypeImage() {
      switch (this.eventType) {
        case 1:
          return "/images/custom/radionice.png";
        case 2:
          return "/images/custom/sesije.png";
        default:
          return "/images/custom/meetup.png";
      }
    },
    eventStatusText() {
      if (this.training != null) {
        switch (this.training.event_status) {
          case 1:
            return "ZAKAZAN";
          case 2:
            return "U TOKU";
          case 3:
            return "ZAVRŠEN";
          default:
            return "OTKAZAN";
        }
      } else {
        return "";
      }
    },
    eventStatusClass() {
      let c = "float-left h4 ml-1";
      if (this.training != null) {
        switch (this.training.event_status) {
          case 1:
            c += " text-warning";
            break;
          case 2:
            c += " text-info";
            break;
          case 3:
            c += " text-success";
            break;
          default:
            c += " text-danger";
            break;
        }
      }

      return c;
    },
  },
  methods: {
    async getData() {
      await axios.get(`/trainings/get/${this.event_id}`).then((response) => {
        console.log(response.data);
        let trainingData = response.data;
        this.training = trainingData.attributes;
        console.log(this.training);
        this.form.eventId = this.event_id;
        this.form.eventStatus = this.training.event_status;
        this.form.attendances = trainingData.attendances;
        this.eventType = this.training.training_type;
        this.programType = this.training.program_type;
      });
    },
    async getAttendance() {
      if (this.program_id != 0) {
        await axios
          .get(`/trainings/attendance/${this.event_id}/${this.program_id}`)
          .then((response) => {
            console.log(response.data);
            this.userAttendance = response.data.attendance;
            this.company = response.data.company;
          });
      }
    },
    getCompanyPhoto(index) {
      const photo = this.form.attendances[index].photo;
      if (photo != null && photo.filelink != "") return photo.filelink;
      return "/images/custom/nophoto2.png";
    },
    async onOk() {
      let formData = new FormData();
      formData.append("event_status", this.form.eventStatus);
      this.form.attendances.forEach((attendance) => {
        formData.append("attids[]", attendance.id);
        formData.append("attendances[]", attendance.status);
      });

      await axios.post(`/trainings/${this.event_id}`, formData).then((response) => {
        console.log(response.data);
        location.href = this.backroute;
      });
    },
    onCancel() {
      location.href = this.backroute;
    },
    onEdit() {
      location.href = "/trainings/edit/" + this.event_id;
    },
  },
  async mounted() {
    await this.getData();
    await this.getAttendance();
    $("#trainingDescriptionHtml").html(this.training.training_description);
  },
  data() {
    return {
      form: {
        eventId: 0,
        eventStatus: 0,
        attendances: [],
      },
      programType: "Neodređeno",
      programTypes: {
        0: "Nije izabran",
        2: "Raising Starts",
        5: "Incubation BITF",
        6: "Rastuce kompanije",
      },
      eventType: 1,
      training: null,
      statusOptions: [
        { value: 1, text: "Zakazan" },
        { value: 2, text: "U toku" },
        { value: 3, text: "Završen" },
        { value: 4, text: "Otkazan" },
      ],
      attendanceOptions: [
        { value: 1, text: "Pozvan" },
        { value: 2, text: "Došao" },
        { value: 3, text: "Nije došao" },
      ],
      fields: [
        {
          key: "company",
          label: "Kompanija",
          sortable: true,
        },
        {
          key: "status",
          label: "Status",
          sortable: true,
        },
      ],
      currentPage: 0,
      userAttendance: null,
      company: "",
    };
  },
};
</script>

<style scoped></style>
