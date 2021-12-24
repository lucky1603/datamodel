<template>
    <div class="h-100 w-100">
        <b-form id="filterForm" inline class="w-100 bg-light">
            <b-row id="toolbar" class="row w-100">
                <b-col xl="1" lg="1" class="pt-1">
                    <span class="m-2 position-relative" style="top:12px" >FILTER</span>
                </b-col>
                <b-col xl="2" lg="4" style="display: flex; flex-direction: row; justify-content: left">
                    <b-input-group class="w-100 m-2 mt-3 mt-sm-3 mt-lg-2" size="sm">
                        <b-form-input v-model="form.name" type="search" id="searchName" placeholder="Po nazivu ..." @update="onSubmit"></b-form-input>
                        <template #append>
                            <b-input-group-text><b-icon-zoom-in></b-icon-zoom-in></b-input-group-text>
                        </template>
                    </b-input-group>
                </b-col>
                <b-col xl="2" lg="3" style="display: flex; justify-content: left">
                    <b-form-select size="sm" class="m-2 w-100" v-model="form.profile_state" :options="states" @change="onSubmit"></b-form-select>
                </b-col>
                <b-col xl="3" lg="2" offset-xl="2" class="d-flex flex-row flex-lg-row-reverse" >
                    <a :href="notify_link" role="button" class="text-secondary m-2 position-relative" style="top:5px" ><i class="dripicons-message"></i> POŠALJI PODSETNIK</a>
                </b-col>
                <b-col xl="2" lg="2" class="d-flex flex-row flex-lg-row-reverse" >
                   <a :href="createlink" role="button" class="text-secondary m-2 position-relative" style="top:5px" ><i class="dripicons-document-new"></i> NOVI PROFIL</a>
                </b-col>
            </b-row>
        </b-form>
        <hr/>
        <div id="navigator" class="d-flex justify-content-center align-items-center mt-2" style="height: 5%">
            <b-pagination
                v-model="currentPage"
                :total-rows="items != null ? items.length : 0"
                :per-page="this.itemsPerPage"
                aria-controls="my-table" @input="pageChanged"
            ></b-pagination>
        </div>
        <div id="items" class="row overflow-auto p-4" style="height: 90%; display: flex; flex-wrap: wrap; flex-direction: row">
            <div v-if="loading == true" style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; flex-direction: column">
                <b-spinner label="busy"></b-spinner>
                <p class="mt-4">Učitava se ...</p>
            </div>
            <profile-item v-for="(item, index) in visibleItems"
                :logo="item.logo != null ? item.logo.filelink : ''"
                :background="item.background != null ? item.background.filelink : ''"
                :title="item.name"
                :key="item.id"
                type="2"
                :id="item.id"
                :status="item.state"
                :statustext="item.stateText"></profile-item>
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
        addprofiletitle: { typeof: String, default: 'DODAJ NOVI PROFIL'},
        createlink: { typeof: String, default: '/profiles/create'},
        notify_link: { typeof: String, default: '/profiles/bulkMail'}
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
                for(const property in response.data) {
                    console.log(response.data[property]);
                    this.items.push(response.data[property]);
                }
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
                for(let i = 0; i < this.items.length; i += this.itemsPerPage) {
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
            states : [
                { value: 0, text: "Po stanju"},
                { value: 1, text: 'Zainteresovan'},
                { value: 2, text: 'Prijava'},
                { value: 3, text: 'Poslato'},
                { value: 4, text: 'Selekcija'},
                { value: 5, text: 'Ugovor'},
                { value: 6, text: 'U programu'},
                { value: 7, text: 'Odbijen'}
            ],
            ntps: [
                { value: 0, text: "Po NTP"},
                { value: 1, text: "NTP Beograd"},
                { value: 2, text: "NTP Niš"},
                { value: 3, text: "NTP Čačak"}
            ],
            state: 0,
            loading: false,
            form: {
                name: '',
                profile_state: 0,
            }
        }
    }
}
</script>

<style scoped>

</style>
