<template>
    <div class="h-100 w-100">
        <div id="toolbar" class="row border border-primary" style="height: 5%">

        </div>
        <div id="items" class="row border border-danger" style="height: 90%;">
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
        <div id="navigator" class="row border border-success" style="height: 5%">

        </div>
    </div>

</template>

<script>
export default {
    name: "ProfileExplorer",
    props: {
        itemsperpage: { typeof: Number, default: 12 }
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
        }
    },
    async mounted() {
        this.itemsPerPage = this.itemsperpage;
        await this.getData();
        this.setPage(this.currentPage);
    },
    data() {
        return {
            visibleItems : [],
            items:[],
            rows:[],
            columns:[],
            itemsPerPage : { typeof: Number, default: 12 },
            currentPage : 0
        }
    }
}
</script>

<style scoped>

</style>
