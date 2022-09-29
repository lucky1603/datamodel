<template>
  <div v-if="showFileGroup" class="card shadow" style="min-height: 100px">
    <div class="card-header bg-dark text-light">
      <span class="font-14 font-weight-light">{{ fileGroup.name }}</span>
      <div class="float-right font-14 font-weight-light">
        <span class="text-warning mr-2">Dodat:</span>
        <span class="text-white">{{ fileGroup.created_at }}</span>
      </div>
    </div>
    <div class="card-body">
      <p v-if="fileGroup.note != null">{{ fileGroup.note }}</p>
      <hr v-if="fileGroup.note != null" />
      <div class="d-flex flex-wrap p-1">
        <file-item
          v-for="(file, index) in fileGroup.files"
          :key="index"
          :filename="file.filename"
          :filelink="file.filelink"
          class="m-1"
        ></file-item>
      </div>
      <div
        v-if="showFooter"
        style="width: 100%; height: 20px; padding-bottom: 5px; padding-right: 5px"
      >
        <hr class="m-0 p-0" />
        <button
          v-if="showButton"
          type="button"
          @click="clickButton"
          class="btn btn-sm btn-outline-warning float-right mt-2 mr-1 mb-1"
        >
          <i class="uil-trash mr-1"></i>Obrisi
        </button>
        <div
          v-if="showNotification"
          class="float-right text-warningm-1 font-11 mt-1 mr-1"
        >
          <span class="mr-2 text-danger font-weight-bold">Obrisano</span>
          <span class="font-weight-bold">{{ this.fileGroup.updated_at }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "FileGroupViewer",
  props: {
    index: { typeof: Number, default: 0 },
    file_group: { typeof: Object, default: null },
    user_role: { typeof: String, default: "administrator" },
  },
  computed: {
    showFileGroup() {
      return !this.fileGroup.deleted || this.user_role == "administrator";
    },
    showFooter() {
      var condition = this.fileGroup.deleted && this.user_role == "administrator";
      condition = condition || this.user_role == "profile";
      return condition;
    },
    showButton() {
      return !this.fileGroup.deleted && this.user_role == "profile";
    },
    showNotification() {
      return this.fileGroup.deleted && this.user_role == "administrator";
    },
  },
  methods: {
    clickButton(evt) {
      this.$emit("delete-file-group", this.fileGroup.id);
    },
  },
  data() {
    return {
      fileGroup: this.file_group,
    };
  },
};
</script>

<style scoped></style>
