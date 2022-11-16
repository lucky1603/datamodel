<template>
    <div>
        <div class="card shadow" style="height: 98%;">
            <div class="card-header bg-primary text-light" style="height: 40px">
                {{ _('gui.activities').toUpperCase() }}
            </div>
            <div class="card-body" style="height: 90%; overflow: auto">
                <div class="timeline-alt pb-0" >

                        <div v-for="(situation, index) in situations" class="timeline-item" :key="index">
                            <i v-if="index == 0" class="mdi mdi-circle bg-primary-lighten text-primary timeline-icon"></i>
                            <i v-else class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
                            <div class="timeline-item-info pb-3">
                                <h5 class="mt-0 mb-1">{{ situation.name }}</h5>
                                <p class="font-12 attribute-label font-weight-bold">{{ situation.occured_at }}</p>
                                <p class="text-muted mt-2 mb-0 pb-3">
                                    {{ situation.description }}
                                </p>

                                <div v-for="(attribute, attindex) in situationAttributes(situation)"
                                    :key="attindex"
                                    :class="index == situations.length - 1 ? 'font-11 mt-0 mb-2' : 'font-11 my-0'">
                                    <span class="attribute-label font-weight-semibold">{{ attribute.label }}:</span>
                                    <br v-if="attribute.type == 'text'"/>
                                    <span v-if="attribute.type != 'file'" :class="attribute.type == 'text' ? 'ml-2 text-muted' : 'text-muted'">{{ attribute.value }}</span>
                                    <a v-else :href="attribute.value.filelink" class="btn-link ml-2 font-weight-semibold">{{ attribute.value.filename }}</a>
                                </div>

                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ActivityFlow',
    props: {
        profile_id: { typeof: Number, default: 0}
    },

    data() {
        return {
            situations: []
        };
    },

    async mounted() {
        await this.getData();
    },

    methods: {
        async getData() {
            await axios.get('/profiles/situations/' + this.profile_id)
            .then(response => {
                console.log(response.data);
                this.situations.length = 0;
                if(response.data.code == 0) {
                    this.situations = response.data.value;
                }
            })
        },
        situationAttributes(situation) {
            return situation.displayAttributes.filter(att => {
                return att != 'description';
            });
        }
    },
};
</script>

<style lang="scss" scoped>

</style>
