<template>
  <div class="card h-100 w-100">
    <div class="card-header" id="test">
      <span v-if="event_id == 0" class="h4"
        >KREIRAJ DOGAĐAJ - <span class="attribute-label">{{ getEventType }}</span></span
      >
      <span v-else class="h4"
        >UREDI DOGAĐAJ - <span class="attribute-label">{{ getEventType }}</span></span
      >
    </div>
    <div class="card-body">
      <form
        :id="formid"
        :ref="formid"
        method="POST"
        enctype="multipart/form-data"
        action="#"
        @submit="submitForm"
      >
        <input type="hidden" name="_token" :value="token" />
        <input type="hidden" name="training_type" ref="eventType" :value="eventType" />

              <div
                class="card-body h-100 p-1"
                style="display: flex; justify-content: center; flex-wrap: wrap"
              >
                <tile-item
                  class="m-1"
                  :id="1"
                  role="button"
                  photo="/images/custom/radionice.png"
                  title="RADIONICA"
                  :padding="2"
                  :width="120"
                  @tile-clicked="tileClicked"
                ></tile-item>

                <tile-item
                  :id="2"
                  class="m-1"
                  role="button"
                  photo="/images/custom/sesije.png"
                  title="SESIJA"
                  :padding="2"
                  :width="120"
                  @tile-clicked="tileClicked"
                ></tile-item>

                <tile-item
                  :id="3"
                  class="m-1"
                  role="button"
                  photo="/images/custom/meetup.png"
                  title="MEETUP"
                  :padding="2"
                  :width="120"
                  @tile-clicked="tileClicked"
                ></tile-item>

                <tile-item
                  :id="4"
                  class="m-1"
                  role="button"
                  photo="/images/custom/event.png"
                  title="SAVETOVANJE"
                  :padding="2"
                  :width="120"
                  @tile-clicked="tileClicked"
                ></tile-item>

                <tile-item
                  :id="5"
                  class="m-1"
                  role="button"
                  photo="/images/custom/event.png"
                  title="TEHNIČKA PODRŠKA"
                  :padding="2"
                  :width="120"
                  @tile-clicked="tileClicked"
                ></tile-item>

                <tile-item
                  :id="6"
                  class="m-1"
                  role="button"
                  photo="/images/custom/event.png"
                  title="Pristup finansijama / fondovima"
                  :padding="2"
                  :width="120"
                  @tile-clicked="tileClicked"
                ></tile-item>

                <tile-item
                  :id="7"
                  class="m-1"
                  role="button"
                  photo="/images/custom/event.png"
                  title="VIDLJIVOST / PROMOCIJA"
                  :padding="2"
                  :width="120"
                  @tile-clicked="tileClicked"
                ></tile-item>

                <tile-item
                  :id="8"
                  class="m-1"
                  role="button"
                  photo="/images/custom/event.png"
                  title="TRANSFER ZNANJA"
                  :padding="2"
                  :width="120"
                  @tile-clicked="tileClicked"
                ></tile-item>
              </div>


        <div class="row">
          <div class="col-lg-9">
            <div class="form-group mt-3">
              <label for="training_name" class="attribute-label">Naziv događaja *</label>
              <input
                type="text"
                id="training_name"
                name="training_name"
                class="form-control form-control-sm"
              />
              <span
                class="text-danger error-notification"
                id="training_nameError"
                style="display: none"
              ></span>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group mt-3">
              <label for="program_type" class="attribute-label">Tip programa</label>
              <select
                id="program_type"
                name="program_type"
                class="form-control form-control-sm"
              >
                <option value="0">Izaberite tip programa</option>
                <option value="2">Raising Starts</option>
                <option value="5">Incubation BITF</option>
                <option value="6">Rastuće kompanije</option>
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-4 form-group">
            <label for="training_start_date" class="attribute-label"
              >Datum početka *</label
            >
            <input
              type="date"
              id="training_start_date"
              name="training_start_date"
              class="form-control form-control-sm"
            />
            <span
              class="text-danger error-notification"
              id="training_start_dateError"
              style="display: none"
            ></span>
          </div>
          <div class="col-lg-4 form-group">
            <label for="training_start_time" class="attribute-label">Počinje u *</label>
            <input
              type="time"
              class="form-control form-control-sm"
              id="training_start_time"
              name="training_start_time"
            />
            <span
              class="text-danger error-notification"
              id="training_start_timeError"
              style="display: none"
            ></span>
          </div>
          <div class="col-lg-4 form-group">
            <div class="form-group">
              <label class="attribute-label">Trajanje *</label>
              <div style="display: flex; width: 100%">
                <div>
                  <input
                    type="text"
                    id="training_duration"
                    class="form-control form-control-sm"
                    name="training_duration"
                    style="flex-grow: 1; width: 50%"
                  />
                  <span
                    class="text-danger error-notification"
                    id="training_durationError"
                    style="display: none"
                  ></span>
                </div>

                <select
                  id="training_duration_unit"
                  name="training_duration_unit"
                  class="ml-1 form-control form-control-sm"
                  style="flex-grow: 1; width: 50%"
                >
                  <option value="1">min</option>
                  <option value="2">h</option>
                  <option value="3">d</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="location" class="attribute-label">Lokacija *</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text form-control-sm"
                ><i class="dripicons-location"></i
              ></span>
            </div>
            <input
              type="text"
              id="location"
              name="location"
              class="form-control form-control-sm"
              placeholder="Soba, zgrada, adresa itd."
            />
          </div>
          <span
            class="text-danger error-notification"
            id="locationError"
            style="display: none"
          ></span>
        </div>

        <div class="form-group">
          <label for="training_host" class="attribute-label">Organizator *</label>
          <input
            type="text"
            id="training_host"
            name="training_host"
            class="form-control"
          />
          <span
            class="text-danger error-notification"
            id="training_hostError"
            style="display: none"
          ></span>
        </div>

        <div class="form-group">
          <label for="training_short_note" class="attribute-label">Kratka beleška</label>
          <input
            type="text"
            id="training_short_note"
            name="training_short_note"
            class="form-control"
            placeholder="Kratka beleška o treningu ..."
          />
        </div>

        <div class="form-group">
          <label for="training_description" class="attribute-label"> Agenda </label>
          <div ref="sinisa" id="sinisa"></div>

          <textarea
            ref="trainingDescription"
            id="training_description"
            name="training_description"
            hidden
          ></textarea>
        </div>

        <div class="form-group">
          <label class="attribute-label">Priložite datoteke</label>
          <b-form-file
            v-model="file1"
            :state="null"
            placeholder="Izaberite datoteke ili ih prevucite ovde..."
            drop-placeholder="Prevucite datoteke ovde..."
            multiple
          ></b-form-file>
        </div>

        <div class="text-center mt-4">
          <h4 class="attribute-label">DODAJTE UČESNIKE</h4>
        </div>

        <!--                <div class="row form-group">-->
        <!--                    <label class="attribute-label">SPISAK KOMPANIJA *</label>-->
        <!--                    <b-form-select v-model="selected" :options="candidates" multiple :select-size="4"></b-form-select>-->
        <!--                    <span class="text-danger error-notification" id="candidateError" style="display: none"></span>-->
        <!--                </div>-->
        <div class="form-group mt-4">
          <companies-selector
            v-model="selected"
            source="/profiles/trainingCandidates"
          ></companies-selector>
          <span
            class="text-danger error-notification text-center"
            id="candidateError"
            style="display: none"
          ></span>
        </div>

        <div class="text-center">
          <b-button
            ref="sendButton"
            id="sendButton"
            type="submit"
            class="mt-3"
            variant="primary"
            size="sm"
          >
            <span
              id="okSpinner"
              class="spinner-border spinner-border-sm"
              role="status"
              aria-hidden="true"
            ></span>
            Kreiraj
          </b-button>
          <b-button
            ref="cancelButton"
            id="cancelButton"
            type="button"
            class="mt-3"
            variant="outline-primary"
            size="sm"
            @click="onCancel"
            >Otkaži</b-button
          >
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "EventGenerator",
  props: {
    token: { typeof: String, default: "" },
    formid: { typeof: String, default: "createEventForm" },
    event_id: { typeof: Number, default: 0 },
  },
  computed: {
    getEventType() {
      switch (this.eventType) {
        case 1:
          return "RADIONICA";
        case 2:
          return "SESIJA";
        case 3:
          return "MEETUP";
        case 4:
            return "SAVETOVANJE";
        case 5:
            return "TEHNIČKA PODRŠKA";
        case 6:
            return "PRISTUP FINANSIJAMA/FONDOVIMA";
        case 7:
            return "VIDLJIVOST/PROMOCIJA";
        default:
            return "TRANSFER ZNANJA";
      }
    },
  },
  methods: {
    tileClicked(id) {
      this.selectEventType(id);
    },
    selectEventType(id) {
    //   if (id < 1 || id > 3) id = 1;
      this.eventType = id;
      this.$refs["eventType"].value = this.eventType.toString();
      Dispecer.$emit("tile-selected", this.eventType);
    },
    initTextArea() {
      $("#sinisa").summernote({
        height: 250,
        colorButton: {
          foreColor: "#000000",
          backColor: "transparent",
        },
      });
    },
    submitForm(event) {
      event.preventDefault();
      $("#okSpinner").show();
      // $('#sendButton').attr('disabled', true);
      let button = this.$refs.sendButton;
      button.disabled = true;

      let description = $("#sinisa").summernote("code");
      $("#training_description").text(description);

      const form = document.getElementById(this.formid);
      const data = new FormData(form);

      // Add selected files.
      let files = $('input[type="file"].custom-file-input')[0].files;
      files.forEach((file) => {
        console.log(file);
        data.append("attachment[]", file);
      });

      // Add selected companies.
      if (this.selected != null && this.selected.length > 0) {
        this.selected.forEach((id) => {
          data.append("candidate[]", id);
        });
      }

      $.ajax({
        url: "/trainings/create",
        method: "POST",
        data: data,
        processData: false,
        contentType: false,
        success: function (data) {
          console.log(data);
          location.href = "/trainings";
        },
        error: function (data) {
          let errorData = data.responseJSON;
          $(".error-notification").hide();
          for (let key in errorData.errors) {
            let value = errorData.errors[key];
            $("#" + key + "Error")
              .show()
              .text(value);
          }

          $("#okSpinner").hide();
          button.disabled = false;
        },
      });
    },
    getCandidates() {
      axios.get(`/profiles/trainingCandidates`).then((response) => {
        console.log(response.data);
        this.candidates.length = 0;
        let programs = response.data;
        let candidates = [];
        programs.forEach((program) => {
          candidates.push({ value: program.id, text: program.profile });
        });

        this.candidates = candidates;
        console.log(this.candidates);
      });
    },
    onCancel() {
      history.go(-1);
    },
  },
  data() {
    return {
      eventType: { typeof: Number, default: 1 },
      file1: [],
      candidates: [],
      selected: [],
      description: null,
      selectedCompanies: [],
    };
  },
  mounted() {
    $("#okSpinner").hide();
    this.selectEventType(1);
    this.getCandidates();
    setTimeout(this.initTextArea, 1000);
  },
};
</script>

<style scoped>
.ili-circle {
  width: 30px;
  height: 30px;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
