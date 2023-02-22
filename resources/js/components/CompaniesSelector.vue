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
                console.log('Training candidates');
                console.log(response.data);
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
        console.log("input values");
        console.log(this.value);
        setTimeout(this.getData, 1500);
        // await this.getData();
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
