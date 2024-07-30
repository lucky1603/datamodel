<template>
  <div>
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
    <b-modal id="formModal" :title="modalTitle">
      <role-manager-form :id="selectedId"></role-manager-form>
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
        { key: 'desc', label: 'Opis', sortable: true},
        { key: 'action', label: 'Akcije', sortable: true},
      ],
      currentPage: 1,
      modalTitle: 'Naslov',
      selectedId: 0

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
    },

    deleteRole(id, name) {

    }
  },
};
</script>