<template>
    <div class="card h-100 w-100">
        <div class="card-header">
            <span class="h4">KREIRAJ DOGAĐAJ - <span class="attribute-label">{{ getEventType}}</span></span>
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
                <div class="form-group mt-3">
                    <label for="training_name" class="attribute-label">Naziv događaja</label>
                    <input type="text" id="training_name" name="training_name" class="form-control form-control-sm">
                </div>
                <div class="row">
                    <div class="col-lg-4 form-group">
                        <label for="training_start_date" class="attribute-label">Datum početka*</label>
                        <input type="date" id="training_start_date" name="training_start_date" class="form-control form-control-sm">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="training_start_time" class="attribute-label">Počinje u*</label>
                        <input type="time" class="form-control form-control-sm" id="training_start_time" name="training_start_time">

                    </div>
                    <div class="col-lg-4 form-group">
                        <div class="form-group">
                            <label>Trajanje*</label>
                            <div style="display: flex; width: 100%">
                                <input type="text" id="training_duration" class="form-control form-control-sm" name="training_duration" style="flex-grow: 1; width: 50%">
                                <select id="training_duration_unit" name="training_duration_unit" class="ml-1 form-control form-control-sm" style="flex-grow: 1; width:50%" >
                                    <option value="1">min</option>
                                    <option value="2">h</option>
                                    <option value="3">d</option>
                                </select>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <label for="location" class="attribute-label">Lokacija*</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text form-control-sm"><i class="dripicons-location"></i></span>
                        </div>
                        <input type="text" id="location" name="location" class="form-control form-control-sm" placeholder="Soba, zgrada, adresa itd.">
                    </div>
                </div>

                <div class="form-group">
                    <label for="training_host" class="attribute-label">Domaćin događaja*</label>
                    <input type="text" id="training_host" name="training_host" class="form-control">
                </div>

                <div class="form-group">
                    <label for="training_name" class="attribute-label">Kratka beleška</label>
                    <input type="text" id="training_short_note" name="training_short_note" class="form-control" placeholder="Kratka beleška o treningu ...">
                </div>

                <div class="form-group">
                    <label for="training_description" class="attribute-label">
                        Agenda
                    </label>
                    <div id="sinisa"></div>
                    <textarea id="training_description" name="training_description" hidden></textarea>
                </div>

                <b-form-file
                    v-model="file1"
                    :state="Boolean(file1)"
                    placeholder="Izaberite datoteke ili ih prevucite ovde..."
                    drop-placeholder="Prevucite datoteke ovde..." multiple
                ></b-form-file>

                <div class="text-center">
                    <b-button variant="primary" size="sm" @click="buttonClicked">Ok</b-button>
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
        },
        initTextArea() {
            $('#sinisa').summernote({
                height: 150,
                callbacks: {
                    onUpdate : function () {
                        alert('updated!');
                    }
                }
            });
        },
        buttonClicked() {
            let files = $('input[type="file"].custom-file-input')[0].files;
            files.forEach(file => {
                console.log(file);
            });

        }
    },
    data() {
        return {
            event: { typeof: Number, default: 1},
            file1: []
        }
    },
    mounted() {
        this.selectEventType(1);
        this.initTextArea();
    },
}
</script>

<style scoped>

</style>
