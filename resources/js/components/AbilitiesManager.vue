<template>
  <div>
    <b-table
      :items="abilities"
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
          <a @click.prevent="editAbility(data.item.id)" role="button" class="mx-1"><i class='mdi mdi-pencil font-20'></i></a>
          <a href="" @click.prevent="deleteAbility(data.item.id, data.item.name)" class="mx-1"><i class='mdi mdi-trash-can-outline font-20'></i></a>
        </div>
      </template>
    </b-table>
    <b-pagination
      v-model="currentPage"
      :total-rows="abilities.length"
      :per-page="pageSize"
      aria-controls="roleTable"
      align="center"
    ></b-pagination>
    <b-modal id="formModal" ref="formModal" :title="modalTitle">
      <ability-manager-form :id="selectedId"></ability-manager-form>
    </b-modal>
  </div>
</template>

<script>

export default {
  name: 'AbilitiesManager',
  props: {
    pageSize: { typeof: Number, default: 10 }
  },
  data() {
    return {
        abilities: [],
        fields: [
          { key: 'id', label: 'ID', sortable: true },
          { key: 'name', label: 'Naziv', sortable: true },
          { key: 'label', label: 'Opis', sortable: true },
          { key: 'action', label: 'Akcije'}
        ],
        currentPage: 1,
        modalTitle: "Naslov",
        selectedId: 0
    };
  },

  async mounted() {
    await this.getData();
  },

  methods: {
    async getData() {
        await axios.get('/abilities/list')
        .then(response => {
          this.abilities = response.data;
        });
    },
    editAbility(id) {
      this.selectedId = id;
      this.modalTitle = "Promeni postojecu sposobnost";
      this.$bvModal.show('formModal');
    },
    deleteAbility(id,name) {

    },
    addAbility() {
      this.selectedId = 0;
      this.modalTitle = "Dodaj novu sposobnost";
    }
  },
};
</script>