<template>
    <div class="card h-100 w-100">
        <div class="card-header" id="test">
            <span class="h4">UREDI DOGAĐAJ - <span class="attribute-label">{{ getEventType}}</span></span>
        </div>
        <div class="card-body">
            <form
                :id="formid"
                :ref="formid"
                method="POST"
                enctype="multipart/form-data"
                action="#" @submit="submitForm">
                <input type="hidden" name="_token" :value="token">
                <input type="hidden" name="training_type" ref="eventType" :value="form.training_type">
                <div class="row" style="height: 160px">
                    <div class="offset-2 col-8 h-100">
                        <div class="card h-100 shadow">
                            <div class="card-body h-100 p-1" style="display: flex; justify-content: center">
                                <tile-item
                                    :id="1"
                                    role="button"
                                    photo="/images/custom/radionice.png"
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
                                    photo="/images/custom/sesije.png"
                                    title="SESIJA"
                                    :padding="2"
                                    :width="120"
                                    @tile-clicked="tileClicked"></tile-item>
                                <div class="h-100 ml-2 mr-2" style="display: flex; flex-direction: column; justify-content: center">
                                    <div class="border rounded-circle" style="width: 30px; height: 30px; display:flex; justify-content: center; align-items: center">ili</div>
                                </div>
                                <tile-item
                                    :id="3"
                                    role="button"
                                    photo="/images/custom/meetup.png"
                                    title="MEETUP"
                                    :padding="2"
                                    :width="120"
                                    @tile-clicked="tileClicked"></tile-item>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="training_name" class="attribute-label">Naziv događaja *</label>
                    <b-form-input id="training_name" v-model="form.training_name"></b-form-input>
                    <span class="text-danger error-notification" id="training_nameError" style="display: none"></span>
                </div>
                <div class="row">
                    <div class="col-lg-4 form-group">
                        <label for="training_start_date" class="attribute-label">Datum početka *</label>
                        <b-form-input type="date" v-model="form.training_start_date"></b-form-input>
                        <span class="text-danger error-notification" id="training_start_dateError" style="display: none"></span>
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="training_start_time" class="attribute-label">Počinje u *</label>
                        <b-form-input type="time" v-model="form.training_start_time"></b-form-input>
                        <span class="text-danger error-notification" id="training_start_timeError" style="display: none"></span>
                    </div>
                    <div class="col-lg-4 form-group">
                        <label class="attribute-label">Trajanje *</label>
                        <b-form-row>
                            <b-col :col="true">
                                <b-form-input v-model="form.training_duration"></b-form-input>
                                <span class="text-danger error-notification" id="training_durationError" style="display: none"></span>
                            </b-col>
                            <b-col :col="true">
                                <b-form-select
                                    v-model="form.training_duration_unit"
                                    :options="[{ value: 1, text: 'm'}, { value: 2, text: 'h'}, {value: 2, text: 'd'}]">
                                </b-form-select>
                            </b-col>
                        </b-form-row>
                    </div>

                </div>
                <div class="form-group">
                    <label for="location" class="attribute-label">Lokacija *</label>
                    <b-input-group size="sm">
                        <template #append>
                            <span class="input-group-text form-control-sm"><i class="dripicons-location"></i></span>
                        </template>
                        <b-form-input v-model="form.location" placeholder="Soba, zgrada, adresa itd."></b-form-input>
                    </b-input-group>
                    <span class="text-danger error-notification" id="locationError" style="display: none"></span>
                </div>

                <div class="form-group">
                    <label for="training_host" class="attribute-label">Organizator *</label>
                    <b-form-input v-model="form.training_host"></b-form-input>
                    <span class="text-danger error-notification" id="training_hostError" style="display: none"></span>
                </div>

                <div class="form-group">
                    <label for="training_short_note" class="attribute-label">Kratka beleška</label>
                    <b-form-input v-model="form.training_short_note"></b-form-input>
                </div>

                <div class="form-group">
                    <label for="training_description" class="attribute-label">
                        Agenda
                    </label>
                    <div ref="sinisa" id="sinisa"></div>
                    <b-form-textarea ref="trainingDescription" id="training_description" hidden v-model="form.training_description"></b-form-textarea>
                </div>

                <div class="form-group">
                    <label class="attribute-label">Priložite datoteke</label>
                    <b-form-file
                        ref="fileInput"
                        v-model="form.files"
                        :state="null"
                        placeholder="Izaberite datoteke ili ih prevucite ovde..."
                        drop-placeholder="Prevucite datoteke ovde..." multiple
                    ></b-form-file>
                </div>
                <div v-if="form.links.length > 0" style="display: flex; flex-wrap: wrap; margin-top:10px;">
                    <a v-for="link in form.links" class="mr-1" :href="link.filelink" target="_blank">{{ link.filename }}</a>
                </div>

                <div class="text-center mt-4">
                    <h4 class="attribute-label">DODAJTE UČESNIKE</h4>
                </div>

                <div class="form-group mt-4">
                    <companies-selector v-model="form.candidate" source="/profiles/trainingCandidates"></companies-selector>
                    <span class="text-danger error-notification text-center" id="candidateError" style="display: none"></span>
                </div>

                <div class="text-center">
                    <b-button ref="sendButton" id="sendButton" type="submit" class="mt-3" variant="primary" size="sm">
                        <span id="okSpinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Sačuvaj
                    </b-button>
                    <b-button
                        ref="cancelButton"
                        id="cancelButton"
                        type="button"
                        class="mt-3"
                        variant="outline-primary"
                        size="sm" @click="onCancel">Otkaži</b-button>
                </div>
            </form>

        </div>
    </div>
</template>

<script>
export default {
    name: "EventModifier",
    props: {
        token: { typeof: String, default: ''},
        formid: { typeof: String, default: 'modifyEventForm'},
        event_id: {typeof: Number, default: 0}
    },
    computed: {
        getEventType() {
            switch (this.eventType) {
                case 1:
                    return 'RADIONICA';
                case 2:
                    return 'SESIJA';
                default:
                    return 'MEETUP';
            }
        }
    },
    methods: {
        tileClicked(id) {
            this.selectEventType(id);
        },
        selectEventType(id) {
            if(id < 1 || id > 3)
                id = 1;
            this.eventType = id;
            this.$refs['eventType'].value = this.eventType.toString();
            Dispecer.$emit('tile-selected', this.eventType);
        },
        initTextArea() {
            $('#sinisa').summernote({
                height: 250,
                colorButton: {
                    foreColor: '#000000',
                    backColor: 'transparent'
                },
            });

            $('#sinisa').summernote('code', this.form.training_description);

        },
        submitForm(event) {
            event.preventDefault();
            $('#okSpinner').show();
            let button = this.$refs.sendButton;
            button.disabled = true;

            let description = $('#sinisa').summernote('code');
            // $('#training_description').text(description);
            this.form.training_description = description;

            let data = new FormData();
            for(let property in this.form) {
                if(property === 'files' && this.form.files.length > 0) {
                    if(this.$refs.fileInput.files.length > 0) {
                        for(let i = 0; i < this.$refs.fileInput.files.length; i++) {
                            data.append('files[]', this.$refs.fileInput.files[i]);
                        }
                    }
                } else if(property === 'candidate') {
                    for(let id in this.form.candidate) {
                        data.append('candidate[]', this.form.candidate[id]);
                    }
                } else {
                    data.append(property, this.form[property]);
                }
            }

            data.append('_token', this.token);
            data.append('training_description', this.form.training_description);

            let event_id = this.event_id;

            $.ajax({
                url: '/trainings/update/' + this.form.id,
                method: 'POST',
                data: data,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRFToken': this.token
                },
                success: function(data) {
                    console.log(data);
                    button.disabled = false;
                    $('#okSpinner').hide();
                    location.href = '/trainings/' + event_id;
                },
                error: function(data) {
                    let errorData = data.responseJSON;
                    $('.error-notification').hide();
                    for(let key in errorData.errors) {
                        let value = errorData.errors[key];
                        $('#' + key + 'Error').show().text(value);
                    }

                    $('#okSpinner').hide();
                    button.disabled = false;
                }
            })

        },
        async getData() {
            await axios.get(`/trainings/fetch/${this.event_id}`)
            .then(response => {
                console.log(response.data);
                let items = response.data.attributes;
                for(let property in this.form) {
                    this.form[property] = items[property];
                }

                this.form.links = response.data.attributes.files;
                this.form.candidate = response.data.attendances;

            });
        },
        onCancel() {
            history.go(-1);
        }
    },
    data() {
        return {
            eventType: { typeof: Number, default: 1},
            file1: [],
            selected : [],
            description : null,
            selectedCompanies: [],
            form: {
                id: 0,
                training_type: 1,
                training_name: '',
                training_start_date: '',
                training_start_time: '',
                training_duration: '',
                training_duration_unit: 1,
                location: '',
                training_host: '',
                training_short_note: '',
                training_description: '',
                files: [],
                links: ['abc'],
                candidate: [],
                token: this.token
            }
        }
    },
    async mounted() {
        this.form.token = this.token;
        $('#okSpinner').hide();
        await this.getData();
        this.selectEventType(this.form.training_type);
        setTimeout(this.initTextArea, 1000);
    },
}
</script>

<style scoped>

</style>
