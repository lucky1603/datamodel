<template>
    <item-selector v-model="value" ref="selector" :originalitems="originalItems" @input="selectionChanged"></item-selector>
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
            await axios.get(this.source)
            .then(response => {
                this.originalItems.length = 0;
                let programs = response.data;
                programs.forEach(program => {
                    this.originalItems.push({value: program.id, text: program.profile, selected: false });
                });

            });

        },
        selectionChanged() {
            this.$emit('input', this.value);
        }
    },
    async mounted() {
        await this.getData();
    },
    data() {
        return {
            originalItems: [],
        }
    }
}
</script>

<style scoped>

</style>
