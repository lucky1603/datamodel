<template>
    <div class="h-100 w-100">
        <div id="toolbar" class="row">
            <b-col lg="10" class="h-100" style="display: flex; justify-content: left; align-items: center;">
                <span>FILTER</span>
                <b-form id="filterForm" style="width: 90%" inline>
                    <b-input-group class="w-25 ml-2" size="sm">
                        <b-form-input v-model="form.name" type="search" id="searchName" placeholder="Po nazivu ..." @update="onSubmit"></b-form-input>
                        <template #append>
                            <b-input-group-text><b-icon-zoom-in></b-icon-zoom-in></b-input-group-text>
                        </template>
                    </b-input-group>
                    <b-form-select size="sm" class="ml-2 w-25" v-model="form.profile_status" :options="statuses" @change="onSubmit"></b-form-select>
                </b-form>
            </b-col>
            <b-col lg="2" class="h-100" style="display: flex; justify-content: right; align-items: center">
               <a href="#" role="button" class="text-secondary" @click="buttonClicked"><i class="dripicons-document-new"></i> NOVI PROFIL</a>
            </b-col>
        </div>
        <div id="items" class="row overflow-auto" style="height: 90%; display: flex; flex-wrap: wrap; flex-direction: row">
            <div v-if="loading == true" style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; flex-direction: column">
                <b-spinner label="busy"></b-spinner>
                <p class="mt-4">Učitava se ...</p>
            </div>
            <profile-item v-for="(item, index) in visibleItems"
                :logo="item.logo != null ? item.logo.filelink : ''"
                :title="item.name"
                :key="item.id"
                :type="item.programType"
                :id="item.id"
                :status="item.status"
                :statustext="item.statusText" style="width: 15%; height: 30%"></profile-item>
        </div>
        <div id="navigator" class="row" style="height: 5%">
            <b-pagination
                v-model="currentPage"
                :total-rows="items != null ? items.length : 0"
                :per-page="this.itemsPerPage"
                aria-controls="my-table" @input="pageChanged"
            ></b-pagination>
        </div>

        <b-modal id="addProfileModal" ref="addProfileModal" size="lg" header-bg-variant="dark" header-text-variant="light">
            <template #modal-title >{{ addprofiletitle }}</template>
<!--            <span v-html="formContent"></span>-->
            <profile-form ref="myProfileForm" action="/profiles/create"></profile-form>
            <template #modal-footer>
                <b-button type="button" variant="primary" @click="onOk">Prihvati</b-button>
                <b-button type="button" variant="light" @click="onCancel">Zatvori</b-button>
            </template>
        </b-modal>
    </div>

</template>

<script>
export default {
    name: "ProfileExplorer",
    props: {
        itemsperpage: { typeof: Number, default: 12 },
        newitemaction: { typeof: String, default: '#'},
        addprofiletitle: { typeof: String, default: 'DODAJ NOVI PROFIL'}
    },
    computed : {
        logoSrc() {

        }
    },
    methods : {
        async getData() {
            console.log('getting data');
            this.loading = true;

            let formData = new FormData();
            for(const property in this.form) {
                formData.append(property, this.form[property]);
            }

            this.items = [];

            await axios.post('/profiles/filter', formData)
            .then(response => {
                console.log('data got');
                for(const property in response.data) {
                    console.log(response.data[property]);
                    this.items.push(response.data[property]);
                }

                console.log(this.items);

            });

            console.log('trying to make pages');
            await this.makePages();
            this.loading = false;
            console.log('pages made');
            // Event.$emit('refresh');
        },
        async shouldRefresh() {
            console.log('got refresh event');
            await this.getData();
            await this.showCurrentPage();
            $('body').css('cursor', 'default');
        },
        async buttonClicked() {
            this.$refs['addProfileModal'].show();
        },
        async onSubmit() {
            await this.shouldRefresh();
        },
        pageChanged() {
            console.log(`Page changed ${this.currentPage}`);
            this.showCurrentPage();
        },
        searchIconClick() {
            console.log('icon clicked!');
        },
        async makePages() {
            this.pages = [];
            if(this.items.length < this.itemsPerPage) {
                let pageItems = [];
                this.items.forEach(item => {
                    pageItems.push(item);
                });

                this.pages.push(pageItems);
            } else {
                for(let i = 0; i < this.items.length - 1; i += this.itemsPerPage) {
                    let pageItems = [];
                    for(let j = i; j < Math.min(i + this.itemsPerPage, this.items.length); j ++) {
                        pageItems.push(this.items[j]);
                    }
                    this.pages.push(pageItems);
                }
            }

            console.log(this.pages);
        },
        async showCurrentPage() {
            this.visibleItems = [];
            this.visibleItems = this.pages[this.currentPage - 1];
        },
        async onOk() {
            $('body').css('cursor', 'progress');
            await Event.$emit('submit', 'createProfile');
            this.$refs['addProfileModal'].hide();
        },
        onCancel() {
            this.$refs['addProfileModal'].hide();
        }
    },
    async mounted() {
        this.itemsPerPage = this.itemsperpage;
        await this.getData();
        await this.showCurrentPage();
        Event.$on('refresh', this.shouldRefresh);
    },
    data() {
        return {
            pages : [],
            items:[],
            visibleItems:[],
            itemsPerPage : { typeof: Number, default: 12 },
            currentPage : 1,
            formContent : null,
            statuses : [
                { value: 0, text: "Po statusu"},
                { value: 1, text: 'Mapiran'},
                { value: 2, text: 'Zainteresovan'},
                { value: 3, text: 'Prijava'},
                { value: 4, text: 'U programu'}
            ],
            status: 0,
            loading: false,
            form: {
                name: '',
                profile_status: 0
            }
        }
    }
}
</script>

<style scoped>

</style>
