<template>
  <div>
    <div class="d-flex align-items-center justify-content-center">
      <b-button 
       variant="primary" 
       class="rounded-circle my-4 d-flex align-items-center justify-content-center" 
       style="width: 30px; height: 30px" 
       @click="addRole"
       >
        <!-- <b-icon icon="plus" class="font-20"></b-icon> -->
        <i class="mdi mdi-account-plus font-20"></i>
      </b-button>
      <span class="mx-2">{{ _('gui.AddRole') }}</span>
    </div>
    <b-table 
        :items="roles"
        :fields="fields"
        :per-page="pageSize"
        :current-page="currentPage"
        head-variant="dark"
        small 
        bordered 
        class="shadow-sm"
        hover
        :key="componentKey"
    >
    <template #cell(action)="data">
        <div class="d-flex align-items-center justify-content-center">
          <a @click.prevent="editRole(data.item.id)" role="button" class="mx-1"><i class='mdi mdi-pencil font-20'></i></a>
          <a href="" @click.prevent="deleteRole(data.item.id, data.item.name)" class="mx-1"><i class='mdi mdi-trash-can-outline font-20'></i></a>
        </div>
      </template>
    </b-table>
    <b-pagination
      v-model="currentPage"
      :total-rows="roles.length"
      :per-page="pageSize"
      aria-controls="profileTable"
      align="center"
    ></b-pagination>
    <b-modal id="formModal" :title="modalTitle" @ok="alertOk" @cancel="alertCancel">
      <role-manager-form :id="selectedId" ref="managerForm" @succeded="succeded"></role-manager-form>
    </b-modal>
    <b-modal v-model="showDeleteDialog" id="deleteConfirm" :title="deleteTitle" @ok="alertDelete" @cancel="alertCancel">
      <p>{{ deleteMessage }}</p>
    </b-modal>
  </div>
</template>

<script>
export default {
  name: 'RoleManager',
  props: {
    pageSize: { typeof: Number, default: 10 }
  },
  data() {
    return {
      roles: [],
      fields: [
        { key: 'id', label: 'ID', sortable: true},
        { key: 'name', label: 'Naziv', sortable: true},
        { key: 'label', label: 'Opis', sortable: true},
        { key: 'action', label: 'Akcije', sortable: true},
      ],
      currentPage: 1,
      modalTitle: 'Naslov',
      selectedId: 0,
      componentKey: 1,
      deleteTitle: "Brisanje",     
      deleteMessage: "Brisanje",
      showDeleteDialog: false
    };
  },

  async mounted() {
    await this.getData();
  },

  methods: {
    async getData() {
        axios.get('/roles/list')
        .then(response => {
            this.roles = response.data;
        });
    },
    editRole(id) {
      this.selectedId = id;
      this.$bvModal.show('formModal');
      this.componentKey ++;
    },

    addRole() {
      this.selectedId = 0;
      this.$bvModal.show('formModal');
    },

    async deleteRole(id, name) {
      this.deleteMessage = "Da li hoćete da obrišete rolu '" + name + "'?";
      this.showDeleteDialog = true;
      this.selectedId = id;
    },
    async alertOk() {
      await this.$refs.managerForm.send();
      await this.getData();
    },
    alertCancel() {
      
    },
    succeded() {
      console.log('uspeh');
      this.componentKey ++;
      this.selectedId = 0;
    },
    async alertDelete() {
      await axios.get('/roles/delete/' + this.selectedId)
      .then(response => {
        console.log(response.data);
      });

      await this.getData();
      this.selectedId = 0;
    }
  },
};
</script>