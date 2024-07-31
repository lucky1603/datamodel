<template>
  <div>
    <div class="d-flex align-items-center justify-content-center">
      <b-button 
       variant="primary" 
       class="rounded-circle my-4 d-flex align-items-center justify-content-center" 
       style="width: 30px; height: 30px" 
       @click="addAbility"
       >
        <!-- <b-icon icon="plus" class="font-20"></b-icon> -->
        <i class="mdi mdi-account-plus font-20"></i>
      </b-button>
      <span class="mx-2">{{ _('gui.AddAbility') }}</span>
    </div>
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
          <a href="" @click.prevent="showDelete(data.item.id, data.item.name)" class="mx-1"><i class='mdi mdi-trash-can-outline font-20'></i></a>
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
    <b-modal v-model="showFormDialog" id="formModal" ref="formModal" :title="modalTitle" @ok="alertOk">
      <ability-manager-form :id="selectedId" ref="abilityManagerForm"></ability-manager-form>
    </b-modal>
    <b-modal v-model="showDeleteDialog" id="deleteConfirm" :title="deleteTitle" @ok="alertDelete">
      <p>{{ deleteMessage }}</p>
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
        selectedId: 0,
        showFormDialog: false,
        showDeleteDialog: false,
        deleteTitle: 'Brisanje', 
        deleteMessage: 'Brisanje'

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
      this.showFormDialog = true;
    },

    addAbility() {
      this.selectedId = 0;
      this.modalTitle = "Dodaj novu sposobnost";
      this.showFormDialog = true;
    },

    async alertOk() {
      await this.$refs.abilityManagerForm.send();
      await this.getData();
      this.selectedId = 0;
    }, 

    showDelete(id, name) {
      this.selectedId = id;
      this.deleteMessage = "Da li hoćete da obrišete '" + name + "'?";
      this.showDeleteDialog = true;
    },
    async alertDelete() {
      await axios.get('/abilities/delete/' + this.selectedId);
      await this.getData();
    }
  },
};
</script>