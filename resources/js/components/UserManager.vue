<template>
  <div>
    <b-table
      :items="rows"
      :fields="fields"
      :per-page="pageSize"
      :current-page="currentPage"
      head-variant="dark"
      small 
      bordered 
      class="shadow-sm"
      hover 
      >
      <template #cell(photo)="data">
        <img v-if="data.item.photo != null" :src="data.item.photo" height="40"/>
        <img v-else src="/images/custom/nophoto2.png" height="40"/>
      </template>
      <template #cell(action)="data">
        <div class="d-flex align-items-center justify-content-center">
          <a @click.prevent="editUser(data.item.id)" role="button" class="mx-1"><i class='mdi mdi-pencil font-20'></i></a>
          <a href="" @click.prevent="deleteUser(data.item.id)" class="mx-1"><i class='mdi mdi-trash-can-outline font-20'></i></a>
        </div>
      </template>
    </b-table>
    <b-pagination
      v-model="currentPage"
      :total-rows="rows.length"
      :per-page="pageSize"
      aria-controls="profileTable"
      align="right"
    ></b-pagination>
    <b-modal ref="ChangeUserForm" header-bg-variant="dark" header-text-variant="light" hide-footer size="lg">
      <template #modal-title>{{ changeUserTitle }}</template>
      <user-manager-form :user-id="selectedUserId" @cancelled="onCancel" @submitted="onSubmit"></user-manager-form>
    </b-modal>
  </div>
</template>

<script>
export default {
  name: 'UserManager',
  props: {
    pageSize: { typeof: Number, default: 10 }
  },
  data() {
    return {
      fields: [
        { key: "id", label: "ID", sortable: true },
        { key: "name", label: "Ime", sortable: true },
        { key: "email", label: "E-Mail", sortable: true },
        { key: "position", label: "Pozicija", sortable: true },
        { key: "role", label: "Rola", sortable: true },
        { key: "profile", label: "Kompanija", sortable: true },
        { key: "photo", label: "Slika", sortable: true },
        { key: "action", label: "Akcija", sortable: true },
      ],
      rows: [],
      currentPage: 1,
      selectedUserId: 0,
      changeUserTitle: "Promeni podatke korisnika",
      modalVisible: false
    };
  },

  async mounted() {
    await this.getData();
  },

  methods: {
    async getData() {
      await axios.post('/editusers/filterUsers', new FormData())
      .then(response => {
        console.log(response.data);
        this.rows = response.data;
      });
    }, 
    async editUser(id) {
      this.selectedUserId = id;
      // this.modalVisible = true;
      this.$refs.ChangeUserForm.show();
    },
    async deleteUser(id) {

    },
    onCancel() {
      this.$refs.ChangeUserForm.hide();
    },
    async onSubmit() {
      await this.getData();
      this.$refs.ChangeUserForm.hide();
      this.selectedUserId = 0;
    }
  },
};
</script>