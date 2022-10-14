<template>
    <div>
        <b-form id="filterForm" inline class="w-100 bg-light">
            <b-row id="toolbar" class="row w-100">
                <b-col xl="1" lg="1" class="pt-1">
                    <span class="m-2 position-relative" style="top:12px" >FILTER</span>
                </b-col>
                <b-col xl="2" lg="4" style="display: flex; flex-direction: row; justify-content: left">
                    <b-input-group class="w-100 m-2 mt-3 mt-sm-3 mt-lg-2" size="sm">
                        <b-form-input v-model="form.name" type="search" id="searchName" :placeholder="_('gui.profile_list_filter_name')" @update="onSubmit"></b-form-input>
                        <template #append>
                            <b-input-group-text><b-icon-zoom-in></b-icon-zoom-in></b-input-group-text>
                        </template>
                    </b-input-group>
                </b-col>
                <b-col xl="2" lg="4" style="display: flex; justify-content: left">
                    <b-form-select size="sm" class="m-2 w-100" v-model="form.mentorType" :options="mentorTypes" @change="onSubmit"></b-form-select>
                </b-col>
                <b-col xl="2" lg="3" offset-xl="5" class="d-flex flex-row flex-lg-row-reverse" >
                    <a :href="createlink" role="button" class="text-secondary m-2 position-relative" style="top:5px" ><i class="dripicons-document-new mr-2"></i>{{ _('gui.mentor_explorer_new_mentor') }}</a>
                </b-col>
            </b-row>
        </b-form>
        <hr />
        <div id="navigator" class="d-flex justify-content-center align-items-center mt-2" style="height: 5%">
            <b-pagination
                v-model="currentPage"
                :total-rows="items != null ? items.length : 0"
                :per-page="this.itemsPerPage"
                aria-controls="my-table" @input="pageChanged"
            ></b-pagination>
        </div>
        <table class="table table-borderless text-center container">
            <tr v-for="(row,i) in rows" >
                <td v-for="(item, j) in row" >
                    <mentor-item
                        :key="item.id"
                        :id="item.id"
                        :title="item.name"
                        :imagelink="item.photo.filelink"
                        :email="item.email"
                        :phone="item.phone" :type="item.mentorType"></mentor-item>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
export default {
    name: "MentorExplorer",
    props: {
        source: {typeof: String, default: '/mentors/filter'},
        createlink: {typeof: String, default: '/mentors/create'},
        col_count : { typeof: Number, default: 5 },
        row_count : { typeof: Number, default: 3 }
    },
    computed: {
        itemsPerPage() {
            return this.col_count * this.row_count;
        }
    },
    methods: {
        async getData() {
            let data = new FormData();
            for(const property in this.form) {
                data.append(property, this.form[property]);
            }

            await axios.post(this.source, data)
            .then(response => {
                this.items = response.data;
            });

            await this.makePages();

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
            this.rows.length = 0;
            let cols = null;
            for(let i = 0; i < this.visibleItems.length; i++) {
                if(i % this.col_count == 0) {
                    cols = [];
                }

                cols[i % this.col_count] = this.visibleItems[i];

                if(i % this.col_count == this.col_count - 1 || i == this.visibleItems.length - 1) {
                    this.rows.push(cols);
                    cols = null;
                }
            }
        },
        pageChanged() {
            console.log(`Page changed ${this.currentPage}`);
            this.showCurrentPage();
        },
        async shouldRefresh() {
            await this.getData();
            await this.showCurrentPage();
            // $('body').css('cursor', 'default');
        },
        async onSubmit() {
            console.log('emitted');
            await this.shouldRefresh();
        },
    },
    data() {
        return {
            items: [],
            pages: [],
            visibleItems: [],
            currentPage: 1,
            formContent: null,
            loading: false,
            mentorTypes: [
                { value: 0, text: window.i18n.gui.mentor_explorer_by_type },
                { value: 1, text: window.i18n.gui.mentor_explorer_business },
                { value: 2, text: window.i18n.gui.mentor_explorer_tech },
                { value: 3, text: window.i18n.gui.mentor_explorer_specialist }
            ],
            form: {
                name : '',
                mentorType: 0
            },
            rows: []

        }
    },
    async mounted() {
        this.itemsPerPage = this.itemsperpage;
        await this.getData();
        await this.showCurrentPage();
        Dispecer.$on('refresh', this.shouldRefresh);
    }
}
</script>

<style scoped>

</style>
