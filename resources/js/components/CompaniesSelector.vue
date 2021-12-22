<template>
    <item-selector v-model="selectedItems" ref="selector" :originalitems="originalItems" @input="selectionChanged"></item-selector>
</template>

<script>
export default {
    name: "CompaniesSelector",
    props: {
        value: [],
        source: '/profiles/trainingCandidates'
    },
    methods: {
        async getData() {
            await axios.get('/profiles/trainingCandidates')
            .then(response => {
                console.log(response.data);
                this.originalItems.length = 0;
                let programs = response.data;
                programs.forEach(program => {
                    this.originalItems.push({value: program.id, text: program.profile, selected: false });
                });

            });

        },
        selectionChanged() {
            this.$emit('input', this.selectedItems);
        }
    },
    async mounted() {
        await this.getData();
    },
    data() {
        return {
            originalItems: [],
            selectedItems: this.value,
        }
    }
}
</script>

<style scoped>

</style>
