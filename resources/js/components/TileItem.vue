<template>
    <div class="d-flex flex-column">
        <div
            :class="cardClass"
            style="width: 100px; "
            role="button"
            @click="tileClicked"
            :title="title"
        >
            <div class="card-body p-0 m-0">
                <div v-if="label != null && label.show" :class="labelClass">
                    <span>{{ label.text }}</span>
                </div>
                <div :class="tileClass">
                    <div class="d-flex align-items-center justify-content-center p-1 flex-column" >
                        <img :src="imageSource" style="width:80px; height: 60px" />
                        <img
                            v-if="show_alert"
                            src="/images/custom/Button-warning-icon.png"
                            :title="alert_title"
                            style="position: relative; left: -24px; top: -24px; height: 48px; width: 48px"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-center bg-primary text-light my-0 flex-wrap" style="width: 100px">
            <span class="font-10 text-center w-100">{{ dTitle }}</span>
        </div>
    </div>

</template>

<script>
export default {
  name: "TileItem",
  computed: {
    imageSource() {
      if (this.photo == "") return "/images/custom/nophoto2.png";
      return this.photo;
    },
    cardClass() {
      if (this.label != null && this.label.show) {
        return "card shadow-sm m-0 ribbon-box";
      }

      return "card shadow-sm m-0";
    },
    labelClass() {
      switch (this.label.type) {
        case 1:
          return "ribbon-two ribbon-two-danger";
        case 2:
          return "ribbon-two ribbon-two-primary";
        case 3:
          return "ribbon-two ribbon-two-success";
        case 4:
          return "ribbon-two ribbon-two-warning";
        default:
          return "ribbon-two ribbon-two-info";
      }
    },
    tileClass() {
      if (this.isSelected) {
        // return "d-flex flex-column align-items-top p-1 border border-primary h-100";
        return 'shadow bg-selected'
      }

    //   return "d-flex flex-column align-items-top p-1";
      return "shadow-sm";
    },
    dTitle() {
      if (this.title != null && this.title.length > this.titleMaxLength + 3) {
        return this.title.slice(0, this.titleMaxLength) + "...";
      }

      return this.title;
    },
  },
  props: {
    id: { typeof: Number, default: 0 },
    title: { typeof: String, default: "Title" },
    subtitle: { typeof: String, default: "" },
    photo: { typeof: String, default: "" },
    padding: { typeof: Number, default: 0 },
    label: null,
    titleMaxLength: { typeof: Number, default: 35 },
    show_alert: { typeof: Boolean, default: false },
    alert_title: { typeof: String, default: "Upozorenje" },
  },
  methods: {
    tileClicked() {
      this.$emit("tile-clicked", this.id);
      Dispecer.$emit('tile-selected', this.id);
    },

    tileSelected(id) {
      if (this.id === id) {
        this.isSelected = true;
      } else {
        this.isSelected = false;
      }
    },
  },
  data() {
    return {
      isSelected: false,
    };
  },
  mounted() {
    Dispecer.$on("tile-selected", this.tileSelected);
  },
};
</script>

<style scoped>
.bg-selected {
    background-color: #aaccff;
}
</style>
