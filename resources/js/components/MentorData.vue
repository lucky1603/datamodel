<template>
    <div class="h-100">
        <div class="card shadow h-100">
            <div class="card-header card-header-light-background">
                <div class="d-inline-flex align-items-center">
                    <span class="h4 attribute-label">{{ aboutme.toUpperCase() }}</span>
                </div>
                <b-button v-if="mentor != null && usertype === 'administrator'" variant="primary" class="float-right" title="Promeni podatke" @click="showModal"><i class="dripicons-user"></i></b-button>
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
                    Nije izabran mentor.
                </div>
            </div>
        </div>
        <b-modal id="editMentorModal" ref="editMentorModal" size="lg" header-bg-variant="dark" header-text-variant="light" scrollable>
            <template #modal-title>{{ editmentortitle }}</template>
            <span v-html="formContent"></span>
            <template #modal-footer>
                <b-button variant="primary" @click="onOk">Prihvati</b-button>
                <b-button variant="light" @click="onCancel">Odustani</b-button>
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
        usertype: { typeof: String, default: 'administrator'}
    },
    methods : {
        getData() {
            if(this.mentorId != 0 && this.mentorId != null) {
                axios.get(`/mentors/showdata/${this.mentorId}`)
                    .then(response => {
                         this.mentor = response.data;
                    });
            }
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
            const data = new FormData($('form#myMentorForm')[0]);
            if($('#photo')[0].files.length > 0) {
                data.append('photo', $('#photo')[0].files[0]);
            }

            let editForm = this;

            $.ajax({
                url: '/mentors/edit',
                type: 'POST',
                processData: false,
                contentType: false,
                data: data,
                success: function(data) {
                    console.log('success');
                    console.log(data);
                    $('.error-notification').hide();
                    editForm.$refs['editMentorModal'].hide();
                    editForm.getData();
                },
                error(data) {
                    let errorData = data.responseJSON;
                    $('.error-notification').hide();
                    for(let key in errorData.errors) {
                       let value = errorData.errors[key];
                       $('#' + key + 'Error').show().text(value);
                    }
                }
            })
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
            formContent: null
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
