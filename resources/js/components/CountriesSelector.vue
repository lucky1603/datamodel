<template>
   <item-selector
       v-model="value"
       ref="selector"
       :originalitems="originalItems"
       left_title="SVE ZEMLJE"
       right_title="IZABRANE ZEMLJE"
       @input="selectionChanged"></item-selector>
</template>

<script>
export default {
    name: "CountriesSelector",
    props: {
        value: [],
        source: { typeof: String, default: '/analytics/countries' }
    },
    methods: {
        async getData() {
            let countries = [];
            await axios.get(this.source)
            .then(response => {
                this.originalItems.length = 0;
                countries = response.data;

                countries.forEach(country => {
                    let item = {value: country.id, text: country.name, selected: false};
                    if(this.value != null && this.value.includes(item.value)) {
                        item.selected = true;
                    }
                    this.originalItems.push(item);
                });
            });

        },
        selectionChanged() {
            console.log('selection changed!!!!');
            this.$emit('input', this.value);
        }
    },
    mounted() {
        setTimeout(this.getData, 1000);
    },
    data() {
        return {
            originalItems: [],
            selectedItems: this.value
        }
    }
}
</script>
