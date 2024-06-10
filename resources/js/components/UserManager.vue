<template>
  <div>
    <div class="d-flex align-items-center justify-content-center">
      <b-button 
       variant="primary" 
       class="rounded-circle my-4 d-flex align-items-center justify-content-center" 
       style="width: 30px; height: 30px" 
       @click="addUser"
       >
        <!-- <b-icon icon="plus" class="font-20"></b-icon> -->
        <i class="mdi mdi-account-plus font-20"></i>
      </b-button>
      <span class="mx-2">{{ _('gui.AddAccount') }}</span>
    </div>
    <b-form inline @submit="submitFilter" class="bg-light p-2">
      <div class="d-flex align-items-center justify-content-start flex-wrap">
        <span class="mx-1">FILTER</span>
        <b-input-group size="sm">
          <b-form-input v-model="filter.name" @change="submitFilter" placeholder="Po imenu" class="mx-1"></b-form-input>
          <template #append>
            <b-input-group-text><b-icon-zoom-in></b-icon-zoom-in></b-input-group-text>
          </template>
        </b-input-group>
        <b-input-group size="sm">
          <b-form-input v-model="filter.email" @change="submitFilter" placeholder="Po imejlu" class="mx-1"></b-form-input>
          <template #append>
            <b-input-group-text><b-icon-zoom-in></b-icon-zoom-in></b-input-group-text>
          </template>
        </b-input-group>        
        <b-form-select v-model="filter.role" :options="roles" @change="submitFilter" placeholder="Po roli" class="mx-1"></b-form-select>
        <b-form-select v-if="filter.role == 3" v-model="filter.profile" :options="profiles" @change="submitFilter" placeholder="Po profilu" class="mx-1"></b-form-select>
      </div>
      
    </b-form>
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
          <a href="" @click.prevent="deleteUser(data.item.id, data.item.name)" class="mx-1"><i class='mdi mdi-trash-can-outline font-20'></i></a>
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
    <b-modal 
      v-model="deleteDialogVisible" 
      ref="DeleteDialog" 
      header-bg-variant="dark" 
      header-text-variant="light" 
      size="lg" @ok="handleOk">
      <template #modal-title>{{ deleteUserTitle }}</template>
      {{ deleteUserMessage }}
    </b-modal>
  </div>
</template>

<script>
export default {
  name: 'UserManager',
  props: {
    pageSize: { typeof: Number, default: 10 }
  },
  computed: {
    deleteUserMessage() {
      return window.i18n['gui']["delete_user_question"] + " " + this.selectedUserName + "?";
    },
    deleteUserTitle() {
      return window.i18n['gui']["delete_user_title"];
    }
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
        { key: "action", label: "Akcija", sortable: true },
      ],
      filter: {
        name: null,
        email: null,
        role: null,
        profile: null
      },
      rows: [],
      currentPage: 1,
      selectedUserId: 0,
      selectedUserName: '',
      changeUserTitle: "Promeni podatke korisnika",
      modalVisible: false,
      deleteDialogVisible: false,
      roles: [],
      profiles: []
    };
  },

  async mounted() {
    this.getRoles();
    this.getProfiles();
    await this.getData();
  },

  methods: {
    async getData() {
      let formData = new FormData();
      for(let property in this.filter) {
        formData.append(property, this.filter[property]);
      }
      await axios.post('/editusers/filterUsers', formData)
      .then(response => {
        console.log(response.data);
        let users = response.data;
        this.rows = [];
        for(let property in users) {
          this.rows.push(users[property]);
        }
      });
    }, 
    async editUser(id) {
      this.selectedUserId = id;
      // this.modalVisible = true;
      this.$refs.ChangeUserForm.show();
    },
    async addUser() {
      this.selectedUserId = 0;
      this.$refs.ChangeUserForm.show();
    },
    deleteUser(id, name) {
      this.selectedUserId = id;
      this.selectedUserName = name;
      this.deleteDialogVisible = true;
    },
    async handleOk() {
      await axios.get('/users/delete/' + this.selectedUserId)
      .then(response => {
        console.log(response.data);
        this.getData();
      })
    },
    onCancel() {
      this.$refs.ChangeUserForm.hide();
    },
    async onSubmit() {
      await this.getData();
      this.$refs.ChangeUserForm.hide();
      this.selectedUserId = 0;
    },
    async submitFilter() {
      await this.getData();
    },
    getProfiles() {
      axios.get('/profiles/lista')
      .then(response => {
        let profili = response.data;
        this.profiles.push({
          value: null,
          text: "Po profilu"
        })
        for(let property in profili) {
          this.profiles.push({
            value: profili[property].id,
            text: profili[property].name
          });
        }
      });
    },
    getRoles() {
      axios.get('/roles/list')
      .then(response => {
        let role = response.data;
        this.roles.push({
          value: null,
          text: "Po roli"
        });
        for(let property in role) {
          this.roles.push({
            value: role[property].id,
            text: role[property].name
          });
        }
      });
    },
  },
};
</script>