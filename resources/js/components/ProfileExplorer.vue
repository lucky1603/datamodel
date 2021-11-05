<template>
    <div class="h-100 w-100">
        <div id="toolbar" class="row" style="height: 5%">
           <b-col lg="2" offset="10" class="h-100" style="display: flex; justify-content: right; align-items: center">
               <a href="#" role="button" class="text-secondary" @click="buttonClicked"><i class="dripicons-document-new"></i> NOVI PROFIL</a>
           </b-col>
        </div>
        <div id="items" class="row overflow-auto" style="height: 90%; display: flex; flex-wrap: wrap; flex-direction: row">


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
                :total-rows="items.length"
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
            await axios.get('/profiles/list')
            .then(response => {
                this.items = response.data;
                console.log(this.items);

            });

            await this.makePages();
            Event.$emit('refresh');
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
        pageChanged() {
            console.log(`Page changed ${this.currentPage}`);
            this.showCurrentPage();
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
        }
    }
}
</script>

<style scoped>

</style>
