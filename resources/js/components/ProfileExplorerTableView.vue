<template>
    <div>
        <b-form v-if="show_header" id="filterForm" inline class="w-100 bg-light">
            <b-row id="toolbar" class="row w-100">
                <b-col xl="1" lg="1" class="pt-1">
                    <span class="m-2 position-relative" style="top:12px" >FILTER</span>
                </b-col>
                <b-col xl="2" lg="3" style="display: flex; flex-direction: row; justify-content: left">
                    <b-input-group class="w-100 m-2 mt-3 mt-sm-3 mt-lg-2" size="sm">
                        <b-form-input v-model="form.name" type="search" id="searchName" placeholder="Po nazivu ..." @update="onSubmit"></b-form-input>
                        <template #append>
                            <b-input-group-text><b-icon-zoom-in></b-icon-zoom-in></b-input-group-text>
                        </template>
                    </b-input-group>
                </b-col>
                <b-col xl="2" lg="2" style="display: flex; justify-content: left">
                    <b-form-select size="sm" class="m-2 w-100" v-model="form.profile_state" :options="states" @change="onSubmit"></b-form-select>
                </b-col>
                <b-col xl="2" lg="2" style="display: flex; justify-content: left">
                    <b-form-select size="sm" class="m-2 w-100" v-model="form.is_company" :options="types" @change="onSubmit"></b-form-select>
                </b-col>
                <b-col xl="2" lg="2" style="display: flex; justify-content: left">
                    <b-form-select size="sm" class="m-2 w-100" v-model="form.ntp" :options="ntps" @change="onSubmit"></b-form-select>
                </b-col>

                <b-col xl="3" lg="2" class="d-flex flex-row flex-lg-row-reverse">
                    <a href="/profiles/exportRaisingStarts" role="button" style="top:5px" class="text-secondary m-2 position-relative float-right"><i class="dripicons-export"></i> EXPORT</a>
                </b-col>
            </b-row>
        </b-form>
        <hr/>
        <b-table
            id="profileTable"
            :items="profiles"
            :fields="tableFields"
            head-variant="dark"
            small
            bordered
            class="shadow-sm"
            :per-page="page_size"
            :current-page="currentPage"
            hover
            :busy.sync="isBusy"
            :sort-by.sync="sortBy"
            :sort-desc.sync="sortDesc"
            @row-clicked="rowClicked"
            @context-changed="pageChanged">
            <template #cell(name)="data">
                <img :src="getLogo(data.item.logo)" width="24px" class="mr-2"> {{ data.value }}
            </template>
            <template #cell(stateText)="data">
                <span :class="getStatusClass(data.item.state)">{{ data.value }}</span>
            </template>
            <template #cell(program)="data">
                <span class="text-dark font-weight-bold">{{ data.value }}</span>
            </template>
            <template #cell(website)="data">
                <a :href="data.value" target="_blank">{{ data.value }}</a>
            </template>
<!--            <template #cell(contact_email)="data">-->
<!--                <a :href="'mailto://' + data.value" target="_blank">{{ data.value }}</a>-->
<!--            </template>-->
        </b-table>
        <b-pagination
            v-model="currentPage"
            :total-rows="profiles.length"
            :per-page="page_size"
            aria-controls="profileTable" align="right"
        ></b-pagination>
    </div>
</template>

<script>
export default {
    name: "ProfileExplorerTableView",
    props: {
        page_size: { typeof: Number, default: 10 },
        f_name: { typeof: String, default: ''},
        f_profile_state: { typeof: Number, default: 0},
        f_ntp: {typeof: Number, default: 0},
        f_is_company: { typeof: Number, default: -1},
        f_page: { typeof:Number, default: 1},
        show_header: { typeof: Boolean, default: true },
        source: { typeof: String, default: '/profiles/filterCache'},
        role: { typeof: String, default: 'profile' }
    },
    computed: {
        tableFields() {
            if(this.role == 'profile') {
                return [
                    {
                        key: 'name',
                        label: 'Kompanija',
                        sortable: true
                    },
                    {
                        key: 'website',
                        label: 'Web stranica',
                        tdClass: 'font-14',
                        sortable: false,
                    },
                    // {
                    //     key: 'contact_email',
                    //     label: 'Kontakt',
                    //     tdClass: 'font-14',
                    //     sortable: false
                    // },
                ]
            } else {
                return [
                    {
                        key: 'name',
                        label: 'Kompanija',
                        sortable: true
                    },
                    {
                        key: 'membership_type',
                        label: 'Tip članstva',
                        sortable: true,
                    },
                    {
                        key: 'program',
                        label: 'Program',
                        sortable: false,
                    },
                    {
                        key: 'stateText',
                        label: 'Status',
                        tdClass: 'text-center',
                        thClass: 'text-center',
                        sortable: true,
                    },
                    {
                        key: 'isCompany',
                        label: 'Tip društva',
                        sortable: true
                    },
                    {
                        key: 'ntp',
                        label: 'ntp',
                        sortable: true
                    }
                ]
            }
        }
    },
    methods: {
        async getData() {
            this.isBusy = true;
            let formData = new FormData();
            for(const property in this.form) {
                formData.append(property, this.form[property]);
            }

            await axios.post(this.source, formData)
            .then(response => {
                console.log(response.data);
                this.profiles = [];
                for(const property in response.data) {
                    this.profiles.push(response.data[property])
                }
            });
            this.isBusy = false;
        },
        getCompanyType(value) {
            if(value == true) {
                return 'Kompanija';
            }

            return 'Startap';
        },
        getLogo(logo) {
            if(logo == null || logo.filelink == '')
            {
                return '/images/custom/nophoto2.png';
            }

            return logo;
        },
        getStatusClass(value) {
            let retVal = 'text-center font-weight-bold w-100';
            switch(value) {
                case 1:
                    return retVal + ' text-info';
                case 2:
                    return retVal + ' text-info';
                case 3:
                    return retVal + ' text-danger';
                case 4:
                    return retVal + ' text-warning';
                case 5:
                    return retVal + ' text-primary';
                case 6:
                    return retVal + ' text-success';
                default:
                    return retVal + ' text-dark';
            }
        },
        async onSubmit() {
            await this.getData();
        },
        rowClicked(item, index, event) {
            // alert('Item ' + item.id + ' clicked!');
            $('body').css('cursor', 'progress');
            Dispecer.$emit('profile-clicked', item.id);
        },
        pageChanged(ctx) {
            console.log(`Page changed ${this.currentPage}`);
            let data = new FormData();
            data.append('page', this.currentPage);
            axios.post('/profiles/setSessionVars', data)
                .then(response => {
                    console.log(response.data);
                });
        },
    },
    async mounted() {
        this.form.name = this.f_name;
        this.form.profile_state = this.f_profile_state;
        this.form.ntp = this.f_ntp;
        this.form.is_company = this.f_is_company;

        await this.getData();

        this.currentPage = this.f_page;
    },
    data() {
        return {
            sortBy: 'name',
            sortDesc: false,
            profiles: [],
            currentPage: 0,
            isBusy: false,
            form: {
                name: '',
                profile_state: 0,
                is_company: -1,
                ntp: 0
            },
            fields: [
                {
                    key: 'company',
                    label: 'Kompanija'
                },
                {
                    key: 'membership_type',
                    label: 'Tip članstva'
                },
                {
                    key: 'program',
                    label: 'Program'
                },
                {
                    key: 'stateText',
                    label: 'Status',
                    tdClass: 'text-center',
                    thClass: 'text-center'
                },
                {
                    key: 'tip',
                    label: 'Tip društva'
                },
                {
                    key: 'ntp',
                    label: 'ntp'
                }

            ],
            states : [
                { value: 0, text: "Po stanju"},
                { value: 1, text: 'Nova'},
                { value: 2, text: 'Aktivna'},
                { value: 3, text: 'Alumni'},
                { value: 4, text: 'Suspendovana/odbijena'},
            ],
            ntps: [
                { value: 0, text: "Po NTP"},
                { value: 1, text: "NTP Beograd"},
                { value: 2, text: "NTP Niš"},
                { value: 3, text: "NTP Čačak"}
            ],
            types: [
                { value: -1, text: 'Po tipu'},
                { value: 0, text: 'Startap'},
                { value: 1, text: 'Kompanija'}
            ],
        }
    }
}
</script>

<style scoped>

</style>
