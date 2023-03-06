<template>
    <div class="w-100 h-100">
        <b-form id="filterForm" inline class="w-100 bg-light">
            <b-row id="toolbar" class="row w-100">
                <b-col xl="1" lg="1" class="pt-1">
                    <span class="m-2 position-relative" style="top:12px" >FILTER</span>
                </b-col>
                <b-col xl="2" :lg="show_year ? 3 : 4" style="display: flex; flex-direction: row; justify-content: left">
                    <b-input-group class="w-100 m-2 mt-3 mt-sm-3 mt-lg-2" size="sm">
                        <b-form-input v-model="form.name" type="search" id="searchName" placeholder="Po nazivu ..." @update="onSubmit"></b-form-input>
                        <template #append>
                            <b-input-group-text><b-icon-zoom-in></b-icon-zoom-in></b-input-group-text>
                        </template>
                    </b-input-group>
                </b-col>
                <b-col xl="2" :lg="show_year ? 3 : 4" style="display: flex; justify-content: left">
                    <b-form-select size="sm" class="m-2 w-100" v-model="form.eventType" :options="eventTypes" @change="onSubmit"></b-form-select>
                </b-col>
                <b-col v-if="show_year" xl="2" lg="3" style="display: flex; justify-content: left">
                    <b-form-select size="sm" class="m-2 w-100" v-model="form.year" :options="years" @change="onSubmit"></b-form-select>
                </b-col>
                <b-col v-if="can_create" xl="2" lg="2" :offset-xl="show_year ? 3 : 5" class="d-flex flex-row flex-lg-row-reverse" >
                    <a :href="createlink" role="button" class="text-secondary m-2 position-relative"><i class="dripicons-document-new"></i> NOVI DOGAĐAJ</a>
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

        <table class="table table-borderless text-center container">
            <tr v-for="(row,i) in rows" >
                <td v-for="(item, j) in row">
                    <event-item
                        :status="item.status"
                        :type="item.type"
                        :title="item.name"
                        :date="item.date"
                        :id="item.id"
                        :key="item.id"
                        :is_client="is_client"
                        :attendance="item.attendance"
                        width="300"
                        :where="item.location"
                        :time="item.time"
                        :duration="item.duration"
                        :description="item.description"
                        :height="item_height"
                        :duration-unit="item.durationUnit" @event-clicked="onEventClicked"></event-item>
                </td>
            </tr>
        </table>
    </div>

</template>

<script>
export default {
    name: "EventExplorer",
    props: {
        can_create: true,
        createlink: {typeof: String, default: '/trainings/create'},
        source: {typeof: String, default: '/trainings/filter'},
        is_client: { typeof: Boolean, default: false },
        program_id: { typeof: Number, default: 0 },
        item_height: { typeof: Number, default: 225 },
        row_count : { typeof: Number, default: 2},
        col_count : { typeof: Number, default: 4},
        show_year: { typeof: Boolean, default: true },
        default_year : { typeof: Number, default: 0 }
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
        onEventClicked(eventId) {
            if(this.program_id != 0) {
                window.location.href = `/programs/training/${this.program_id}/${eventId}`;
            } else {
                window.location.href = '/trainings/' + eventId;
            }

        },
        async onSubmit() {
            console.log('submitted');
            await this.getData();
            this.showCurrentPage();
        },
    },

    async mounted() {
        this.itemsPerPage = this.itemsperpage;
        this.form.year = this.default_year;
        await this.getData();
        await this.showCurrentPage();
        Dispecer.$on('refresh', this.shouldRefresh);
    },
    data() {
        return {
            items: [],
            pages: [],
            visibleItems: [],
            currentPage: 1,
            eventTypes: [
                { value: 0, text: 'Po vrsti događaja'},
                { value: 1, text: 'Radionica'},
                { value: 2, text: 'Sesija'},
                { value: 3, text: 'Meetup'}
            ],
            years: [
                { value: 0, text: "Po godini"},
                { value: 2022, text: "2022"},
                { value: 2023, text: "2023"},
            ],
            form: {
                name: '',
                eventType: 0,
                year: 2023
            },
            rows: []
        }
    }
}
</script>

<style scoped>

</style>
