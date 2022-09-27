<template>
  <div class="card shadow" style="min-height: 100px">
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
      <div class="d-flex flex-wrap">
        <file-item
          v-for="(file, index) in fileGroup.files"
          :key="index"
          :filename="file.filename"
          :filelink="file.filelink"
          class="m-1"
        ></file-item>
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
  },
  data() {
    return {
      fileGroup: this.file_group,
    };
  },
};
</script>

<style scoped></style>
