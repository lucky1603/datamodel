<template>
    <div class="h-100">
        <div class="card shadow h-100">
            <div class="card-header card-header-light-background">
                <div class="d-inline-flex align-items-center">
                    <span class="h4 attribute-label">{{ aboutme.toUpperCase() }}</span>
                </div>
                <b-button v-if="mentor != null && usertype === 'administrator'" variant="primary" class="float-right" :title="editmentortitle" @click="showModal1"><i class="dripicons-user"></i></b-button>
            </div>
            <div class="card-body pt-0 pb-0 h-100 ">
                <div v-if="mentor != null" class="row h-100">
                    <div class="col-lg-4 h-100 p-1">
                        <div class="h-100 w-100 overflow-hidden">
                            <img v-if="mentor != null && mentor.photo != null && mentor.photo.value.length > 0" :src="mentor.photo.value"  style="width: 100%"/>
                            <img v-if="mentor == null || mentor.photo == null || mentor.photo.value.length == 0" src="/images/custom/nophoto2.png" class="h-100"/>
                        </div>
                    </div>
                    <div class="col-lg-8 h-100 overflow-auto pt-1">
                        <table class="table table-sm table-borderless table-striped">
                            <tbody class="font-12 text-dark">
                            <tr v-for="(value, name) in mentor" v-if="!['photo', 'remark'].includes(name)">
                                <td style="width: 20%" class="text-dark"><strong>{{ value.label }}</strong></td>
                                <td v-if="value.label === 'Email'"><a  :href="'mailto://' + value.value" target="_blank">{{ value.value }}</a></td>
                                <td v-else>{{ value.value }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div v-if="mentor == null">
                    {{ _('gui.mentor_data_no_mentor') }}
                </div>
            </div>
        </div>
        <b-modal id="editMentorModal" ref="editMentorModal" size="lg" header-bg-variant="dark" header-text-variant="light" scrollable>
            <template #modal-title>{{ editmentortitle }}</template>
            <mentor-form
                ref="mentorEditForm"
                :mentor_id="mentorid"
                :token="token"
                action="/mentors/edit"
                returnLocation="/mentors/edit" :showButtons="false"></mentor-form>
            <template #modal-footer>
                <b-button variant="primary" id="okButton" @click="onOk">{{ _('gui.accept')}}</b-button>
                <b-button variant="light" @click="onCancel">{{ _('gui.cancel') }}</b-button>
            </template>
        </b-modal>
    </div>

</template>

<script>
export default {
    name: "MentorData",
    props: {
        mentorid: 0,
        aboutme: {typeof: String, default: 'About Me'},
        editmentortitle: { type: String, default: 'Edit Mentor Data'},
        usertype: { typeof: String, default: 'administrator'},
        token: { typeof: String, default: ''}
    },
    methods : {
        getData() {
            if(this.mentorId != 0 && this.mentorId != null) {
                axios.get(`/mentors/showdata/${this.mentorId}`)
                    .then(response => {
                        console.log(response.data);
                         this.mentor = response.data;
                         var specArray = [];
                         for(let i in this.mentor.specialities.value) {
                            specArray.push(this.specialities[this.mentor.specialities.value[i]]);
                         }

                         var strval = "";
                         for(let i = 0; i < specArray.length; i++) {
                            if(i != 0) {
                                strval += " ; ";
                            }
                            strval += specArray[i];
                         }

                         this.mentor.specialities.value = strval;

                    });
            }
        },
        showModal1() {
            this.$refs['editMentorModal'].show();
        },
        async showModal() {
            await axios.get(`/mentors/edit/${this.mentorid}`)
            .then(async (response) =>  {
                this.formContent = $(response.data).find('form#myMentorForm').first().parent().html();
                await this.$refs['editMentorModal'].show();
            });

            $('#textBtn').click(function() {
                $('#photo').trigger('click');
            });

            $('#photo').on('change', function (evt) {
                let el = evt.currentTarget;
                console.log(el);
                console.log($(el)[0].files[0]);
                var fileReader = new FileReader();
                fileReader.onload = function () {
                    var data = fileReader.result;  // data <-- in this var you have the file data in Base64 format
                    $('#photoPreview').attr('src', data);
                };
                fileReader.readAsDataURL($(el)[0].files[0]);
            });
        },
        onOk() {
            $('#okButton').attr('disabled', true);
            this.$refs.mentorEditForm.onSubmit()
            .then(response => {
                $('#okButton').attr('disabled', false);
                console.log(response.data);
                this.getData();
                this.$refs.editMentorModal.hide();
            });
        },
        onCancel() {
            this.$refs['editMentorModal'].hide();
        },
        mentorSelected(mentorid) {
            this.mentorId = mentorid;
            this.getData();
        }
    },
    data() {
        return {
            mentor: null,
            mentorId: 0,
            keys: [],
            values: [],
            formContent: null,
            specialities: [
                window.i18n['gui-select']["BB-Select"],
                window.i18n['gui-select']["BB-IOT"],
                window.i18n['gui-select']["BB-EnEff"],
                window.i18n['gui-select']["BB-AI"],
                window.i18n['gui-select']["BB-NewMat"],
                window.i18n['gui-select']["BB-Civic"],
                window.i18n['gui-select']["BB-TechSport"],
                window.i18n['gui-select']["BB-Finance"],
                window.i18n['gui-select']["BB-Marketing"],
                window.i18n['gui-select']["BB-EcoTrans"],
                window.i18n['gui-select']["BB-RoboAuto"],
                window.i18n['gui-select']["BB-Tourism"],
                window.i18n['gui-select']["BB-Education"],
                window.i18n['gui-select']["BB-MediaGaming"],
                window.i18n['gui-select']["BB-MedTech"],
                window.i18n['gui-select']["BB-Agriculture"],
                window.i18n['gui-select']["BB-Other"],
            ]
        }
    },
    mounted() {
        this.mentorId = this.mentorid;
        this.getData();
        Dispecer.$on('mentor-selected', this.mentorSelected)

    },


}
</script>

<style scoped>

</style>
