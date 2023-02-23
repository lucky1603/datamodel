<template>
    <item-selector
        v-model="value"
        ref="selector"
        :originalitems="originalItems"
        :left_title="_('gui.reminder_all_companies')"
        :right_title="_('gui.reminder_selected_companies')"
        @input="selectionChanged"></item-selector>
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
                    let item = {value: program.id, text: program.profile, selected: false};
                    if(this.value.includes(item.value)) {
                        item.selected = true;
                    }

                    this.originalItems.push(item);
                });

            });



        },
        selectionChanged() {
            this.$emit('input', this.value);
        }
    },
    mounted() {
        // The timeout here is because the child component (item selector)
        // is always loaded before the data of the selected companies is being retrieved.
        // Therefore there is a need to set the timeout so there is enough time for the data
        // to be retrieved before the item selector control is loaded. (S.Ristic 22.02.2023.)
        setTimeout(this.getData, 1500);

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
