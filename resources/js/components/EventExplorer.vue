<template>
    <div class="w-100 h-100">
        <b-form id="filterForm" inline class="w-100 bg-light">
            <b-row id="toolbar" class="row w-100">
                <b-col xl="1" lg="1" class="pt-1">
                    <span class="m-2 position-relative" style="top:12px" >FILTER</span>
                </b-col>
                <b-col xl="2" lg="4" style="display: flex; flex-direction: row; justify-content: left">
<!--                    <b-input-group class="w-100 m-2 mt-3 mt-sm-3 mt-lg-2" size="sm">-->
<!--                        <b-form-input v-model="form.name" type="search" id="searchName" placeholder="Po nazivu ..." @update="onSubmit"></b-form-input>-->
<!--                        <template #append>-->
<!--                            <b-input-group-text><b-icon-zoom-in></b-icon-zoom-in></b-input-group-text>-->
<!--                        </template>-->
<!--                    </b-input-group>-->
                </b-col>
                <b-col xl="2" lg="4" style="display: flex; justify-content: left">
<!--                    <b-form-select size="sm" class="m-2 w-100" v-model="form.profile_state" :options="states" @change="onSubmit"></b-form-select>-->
                </b-col>
                <b-col xl="2" lg="3" offset-xl="5" class="d-flex flex-row flex-lg-row-reverse" >
                    <a :href="createlink" role="button" class="text-secondary m-2 position-relative"><i class="dripicons-document-new"></i> NOVI DOGAĐAJ</a>
                </b-col>
            </b-row>
        </b-form>
        <div style="display: flex; flex-wrap: wrap">
            <event-item
                v-for="item in items"
                :status="item.status"
                :type="item.type"
                :title="item.name"
                :date="item.date"
                :id="item.id"
                :key="item.id"
                width="300"
                :where="item.location" @event-clicked="onEventClicked"></event-item>
        </div>
    </div>

</template>

<script>
export default {
    name: "EventExplorer",
    props: {
        createlink: {typeof: String, default: '/trainings/create'}
    },
    methods: {
        async getData() {
            let data = {};
            await axios.post('/trainings/filter', data)
            .then(response => {
                this.items = response.data;
            });
        },
        onEventClicked(eventId) {
            window.location.href = '/trainings/' + eventId;
        }
    },
    async mounted() {
        await this.getData();
    },
    data() {
        return {
            items: [],
            pages: [],
            visibleItems: [],
            currentPage: 1,
        }
    }
}
</script>

<style scoped>

</style>
