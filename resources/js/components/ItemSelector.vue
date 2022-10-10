<template>
    <div class="row">
        <div class="col-lg-5 form-group">
            <p class="attribute-label font-weight-bold text-center">{{ left_title }}</p>
            <b-input-group class="w-100 mb-1" size="sm">
                <b-form-input v-model="searchOriginal" type="search" id="searchOriginal" :placeholder="_('gui.profile_list_filter_name')" @update="onSearchOriginalsUpdate"></b-form-input>
                <template #append>
                    <b-input-group-text><b-icon-zoom-in></b-icon-zoom-in></b-input-group-text>
                </template>
            </b-input-group>
            <b-form-select v-model="originalsSelected" :options="getOriginalItems" :select-size="5" multiple></b-form-select>
        </div>
        <div class="col-lg-2" style="display: flex; flex-direction: column; align-items: center; justify-content: center">
            <b-button variant="primary" class="mb-1 mt-3" size="sm" @click="addAll"  :title="_('gui.reminder_add_all')"><i class="uil-angle-double-right"></i></b-button>
            <b-button variant="outline-primary" class="mb-1" size="sm" @click="addSelected"  :title="_('gui.reminder_add_selected')"><i class="uil-angle-right"></i></b-button>
            <b-button variant="outline-primary" class="mb-1" size="sm" @click="removeSelected"  :title="_('gui.reminder_remove_selected')"><i class="uil-angle-left"></i></b-button>
            <b-button variant="primary" class="mb-1" size="sm" @click="removeAll" :title="_('gui.reminder_remove_all')"><i class="uil-angle-double-left"></i></b-button>
        </div>
        <div class="col-lg-5 form-group">
            <p class="attribute-label font-weight-bold text-center">{{ right_title }}</p>
            <b-input-group class="w-100 mb-1" size="sm">
                <b-form-input v-model="searchSelected" type="search" id="searchSelected" :placeholder="_('gui.profile_list_filter_name')" @update="onSearchOriginalsUpdate"></b-form-input>
                <template #append>
                    <b-input-group-text><b-icon-zoom-in></b-icon-zoom-in></b-input-group-text>
                </template>
            </b-input-group>
            <b-form-select v-model="selectedSelected" :options="getSelectedItems" :select-size="5" multiple></b-form-select>
        </div>
    </div>
</template>

<script>
export default {
    name: "ItemSelector",
    props: {
        originalitems: [],
        value:[],
        left_title: { typeof: String, default:'SVI'},
        right_title: { typeof: String, default: 'IZABRANI'}
    },
    computed: {
        getSelectedItems() {
            if(this.originalItems != null && this.searchSelected.length > 0) {
                return this.originalItems.filter(item => {
                    return (item.text != null && item.text.includes(this.searchSelected) && item.selected);
                });
            }

            return this.originalItems.filter(item => {
                return (item.selected);
            });
        },
        getOriginalItems() {
            if(this.originalItems != null && this.searchOriginal.length > 0) {
                return this.originalItems.filter(item => {
                    return (item.text != null && item.text.includes(this.searchOriginal) && !item.selected);
                });
            }

            return this.originalItems.filter(item => {
                return (!item.selected);
            });
        }
    },
    methods: {
        addAll() {
            console.log('add all clicked');
            this.originalItems.forEach(item => {
                item.selected = true;
            });

            this.$emit('input', this.getSelectedItems.map(item => {
                return item.value;
            }));
        },
        removeAll() {
            console.log('remove all clicked');
            this.originalItems.forEach(item => {
                item.selected = false;
            });

            this.$emit('input', this.getSelectedItems.map(item => {
                return item.value;
            }));
        },
        addSelected() {
            this.originalItems.forEach(item => {
                if(this.originalsSelected.includes(item.value)) {
                    item.selected = true;
                }
            });

            this.$emit('input', this.getSelectedItems.map(item => {
                return item.value;
            }));
        },
        removeSelected() {
            this.originalItems.forEach(item => {
                if(this.selectedSelected.includes(item.value)) {
                    item.selected = false;
                }
            });

            this.$emit('input', this.getSelectedItems.map(item => {
                return item.value;
            }));
        },
        onSearchOriginalsUpdate() {
            console.log(this.searchOriginal);
        },
        onSearchSelectedUpdate() {
            console.log(this.searchSelected);
        }

    },
    data() {
        return {
            originalItems: this.originalitems,
            originalsSelected: [],
            selectedSelected: [],
            filteredItems: [],
            originalFilter: {typeof: String, default: ''},
            selectedFilter: {typeof: String, default: ''},
            searchOriginal: '',
            searchSelected: ''
        }
    }
}
</script>

<style scoped>

</style>
