<template>
    <div>
        <b-table
            :items="programs"
            :fields="fields"
            head-variant="dark"
            small
            bordered
            class="shadow-sm"
            hover
            @row-clicked="rowClicked"
        >
            <template #cell(company)="data">
                <img :src="data.item.logo" width="24px" class="mr-2"> {{ data.value }}
            </template>
            <template #cell(type)="data">
                <strong>{{ data.item.typeText.toUpperCase() }}</strong>
            </template>
            <template #cell(status)="data">
                <span :class="getStatusClass(data.value)">{{ data.item.statusText.toUpperCase() }}</span>
            </template>
        </b-table>
    </div>
</template>

<script>
export default {
    name: "ProgramExplorerTableView",
    props: {
        source: { typeof: String, default: '/programs'}
    },
    methods: {
        async getData() {
            let data = new FormData();
            await axios.post(this.source, data)
            .then(response => {
                console.log(response.data);
                this.programs = [];
                for(const property in response.data) {
                    this.programs.push(response.data[property])
                }
            });
        },
        rowClicked(item, index, event) {
            console.log('clicked on ' + item.id);
            window.location.href = '/programs/' + item.id;
        },

        getLogo(logo) {
            if(logo == null || logo === '')
            {
                return '/images/custom/nophoto2.png';
            }

            return logo;
        },
        getStatusClass(status) {
            let retval = "mr-2";
            switch(status) {
                case -3:
                    retval += ' text-dark';
                    break;
                case -2:
                    retval += ' text-danger';
                    break;
                case -1:
                    retval += ' text-success';
                    break;
                case 0:
                    retval += ' text-second';
                default:
                    retval += ' text-primary';
            }

            return retval;
        }


    },
    async mounted() {
        await this.getData();
    },
    data() {
        return {
            programs: [],
            fields: [
                {
                    key: 'company',
                    label: 'Kompanija',
                    sortable: true
                },
                {
                    key: 'type',
                    label: 'Program',
                    sortable: true
                },
                {
                    key: 'status',
                    label: 'Status',
                    sortable: true
                }
            ],
        }
    }
}
</script>

<style scoped>

</style>
