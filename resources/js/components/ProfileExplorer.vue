<template>
    <div class="h-100 w-100">
        <div id="toolbar" class="row" style="height: 5%">
           <b-col lg="2" offset="10" class="h-100" style="display: flex; justify-content: right; align-items: center">
               <a href="#" role="button" class="text-secondary" @click="buttonClicked"><i class="dripicons-document-new"></i> NOVI PROFIL</a>
           </b-col>
        </div>
        <div id="items" class="row" style="height: 90%;">
            <div class="col-lg-12 h-100">
                <div v-for="(row, index) in rows" class="row" style="height: 30%">
                    <div v-for="(item, idx) in row" class="col-lg-3 h-100 p-2">
                        <profile-item
                            :logo="item.logo != null ? item.logo.filelink : ''"
                            :title="item.name"
                            :type="item.programType"
                            :id="item.id"
                            :status="item.status"
                            :statustext="item.statusText"></profile-item>
                    </div>
                </div>
            </div>
        </div>
        <div id="navigator" class="row" style="height: 5%">

        </div>

        <b-modal id="addProfileModal" ref="addProfileModal" size="lg" header-bg-variant="dark" header-text-variant="light">
            <template #modal-title >{{ addprofiletitle }}</template>
<!--            <span v-html="formContent"></span>-->
            <profile-form v-model="form" ref="myProfileForm" action="/profiles/create"></profile-form>
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
        },
        async shouldRefresh() {
            console.log('got refresh event');
            await this.getData();
            this.setPage(this.currentPage);
            $('body').css('cursor', 'default');

        },
        async buttonClicked() {
            this.$refs['addProfileModal'].show();
        },
        setPage(pageNumber) {
            if(pageNumber * this.itemsPerPage < this.items.length && pageNumber >= 0) {
                this.currentPage = pageNumber;
                let start = this.currentPage * this.itemsPerPage;
                let end = start;
                if(this.items.length < (start + this.itemsPerPage)) {
                    end = this.items.length;
                } else {
                    end = start + this.itemsPerPage;
                }

                console.log(`start is ${start}, end is ${end}`);

                this.visibleItems = [];
                this.rows = [];
                let row = [];
                for(let i = start; i < end; i++) {
                    if(i % 4 == 0) {
                        if(i > 0) {
                            this.rows.push(row);
                        }
                        row = [];
                    }

                    this.visibleItems.push(this.items[i]);
                    row.push(this.items[i]);
                }

                if(row.length > 0)
                    this.rows.push(row);

            }
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
        this.setPage(this.currentPage);
        Event.$on('refresh', this.shouldRefresh);
    },
    data() {
        return {
            visibleItems : [],
            items:[],
            rows:[],
            columns:[],
            itemsPerPage : { typeof: Number, default: 12 },
            currentPage : 0,
            formContent : null,
        }
    }
}
</script>

<style scoped>

</style>
