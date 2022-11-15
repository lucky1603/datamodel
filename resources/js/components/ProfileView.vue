<template>
  <div class="row">
    <div class="col-lg-3">
      <profile-data :profile_id="profile_id"></profile-data>

    </div>

    <div class="col-lg-4">
      <div class="d-flex flex-column">
        <div class="card">
          <div class="card-header bg-primary text-white">OSNOVNI PODACI</div>
          <div class="card-body">
            <div class="d-flex flex-column">
              <div v-if="profile.is_company" class="d-flex flex-column w-100 m-1">
                <span>MB:</span>
                <span class="font-weight-bold shadow-sm">{{ mb }}</span>
              </div>
              <div v-if="profile.webpage != null" class="d-flex flex-column w-100 m-1">
                <span style="width: 100px; margin-top: 7px">WWW:</span>
                <span
                  class="font-14 font-weight-bold attribute-label flex-lg-fill mr-1"
                  >{{ profile.webpage }}</span
                >
              </div>
              <div v-if="profile.address != null" class="d-flex flex-column w-100 m-1">
                <span style="width: 100px; margin-top: 7px">Adresa:</span>
                <span class="font-weight-bold attribute-label p-1 flex-lg-fill mr-1">{{
                  profile.address
                }}</span>
              </div>
              <div v-if="profile.ino_desc != null" class="d-flex flex-column w-100 m-1">
                <span class="mb-1">Kratak opis inovacije:</span>
                <span class="font-weight-bold attribute-label p-1 font-12">{{
                  profile.ino_desc
                }}</span>
              </div>
              <div
                v-if="profile.business_branch != null"
                class="d-flex flex-column w-100 m-1"
              >
                <span class="mb-1">Specijalnost:</span>
                <span class="font-weight-bold attribute-label p-1 font-12">{{
                  profile.business_branch
                }}</span>
              </div>
              <div v-if="profile.ntp != null" class="d-flex flex-column w-100 m-1">
                <span class="mb-1">NTP:</span>
                <span class="font-weight-bold attribute-label p-1 font-12">{{
                  profile.ntp
                }}</span>
              </div>
            </div>
          </div>
        </div>
        <profile-programs
          :profileId="profile_id"
          :user_type="user_type"
        ></profile-programs>
      </div>
    </div>
    <div class="col-lg-5">
        <profile-users
        :profile_id="profile_id"
        :token="token"
        :active_user_id="active_user_id"
      ></profile-users>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProfileView",
  props: {
    profile_id: { typeof: Number, default: 0 },
    token: { typeof: String, default: "" },
    active_user_id: { typeof: Number, default: 0 },
    user_type: { typeof: String, default: "administrator" },
  },
  methods: {
    async getData() {
      await axios.get("/profiles/pvd/" + this.profile_id).then((response) => {
        console.log(response.data);

        for (let property in this.profile) {
          this.profile[property] = response.data.profile[property];
        }

        for (let property in this.contact) {
          this.contact[property] = response.data.contact[property];
        }
      });
    },
  },
  data() {
    return {
      profile: {
        name: "",
        mb: "",
        is_company: false,
        address: "",
        webpage: "",
        ino_desc: "",
        business_branch: "",
        profile_status: 0,
        profile_status_text: "",
        ntp: "",
        logo: "",
      },
      contact: {
        name: "",
        photo: "",
        email: "",
        phone: "",
      },
      programs: [],
      activeUserId: this.active_user_id,
    };
  },
  async mounted() {
    await this.getData();
  },
};
</script>

<style scoped></style>
