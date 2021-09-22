<template>
    <div class="card h-100 w-100">
        <div class="card-header">
            <span class="h4">KREIRAJ DOGADJAJ - <span class="attribute-label">{{ getEventType}}</span></span>
        </div>
        <div class="card-body">
            <form
                id="createEventForm"
                ref="createEventForm"
                method="POST"
                enctype="multipart/form-data"
                action="#">
                <input type="hidden" name="_token" :value="token">
                <input type="hidden" name="eventType" ref="eventType" :value="event">
                <div class="row" style="height: 160px">
                    <div class="offset-2 col-8 h-100">
                        <div class="card h-100 shadow">
                            <div class="card-body h-100 p-1" style="display: flex; justify-content: center">
                                <tile-item
                                    :id="1"
                                    role="button"
                                    photo="/images/custom/workshop1.png"
                                    title="RADIONICA"
                                    :padding="2"
                                    :width="120"
                                    @tile-clicked="tileClicked"></tile-item>
                                <div class="h-100 ml-2 mr-2" style="display: flex; flex-direction: column; justify-content: center">
                                    <div class="border rounded-circle" style="width: 30px; height: 30px; display:flex; justify-content: center; align-items: center">ili</div>
                                </div>
                                <tile-item
                                    :id="2"
                                    role="button"
                                    photo="/images/custom/training.png"
                                    title="TRENING"
                                    :padding="2"
                                    :width="120"
                                    @tile-clicked="tileClicked"></tile-item>
                                <div class="h-100 ml-2 mr-2" style="display: flex; flex-direction: column; justify-content: center">
                                    <div class="border rounded-circle" style="width: 30px; height: 30px; display:flex; justify-content: center; align-items: center">ili</div>
                                </div>
                                <tile-item
                                    :id="3"
                                    role="button"
                                    photo="/images/custom/meeting.png"
                                    title="DEŠAVANJE"
                                    :padding="2"
                                    :width="120"
                                    @tile-clicked="tileClicked"></tile-item>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "EventGenerator",
    props: {
        token: { typeof: String, default: ''},
    },
    computed: {
        getEventType() {
            switch (this.event) {
                case 1:
                    return 'RADIONICA';
                case 2:
                    return 'TRENING';
                default:
                    return 'DEŠAVANJE';
            }
        }
    },
    methods: {
        tileClicked(id) {
            console.log(`Tile ${id} clicked!`);
            this.selectEventType(id);
        },
        selectEventType(id) {
            if(id < 1 || id > 3)
                id = 1;
            this.event = id;
            this.$refs['eventType'].value = this.event.toString();
            Event.$emit('tile-selected', this.event);
        }
    },
    data() {
        return {
            event: { typeof: Number, default: 1}
        }
    },
    mounted() {
        this.selectEventType(1);
    },
}
</script>

<style scoped>

</style>
