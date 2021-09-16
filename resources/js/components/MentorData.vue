<template>
    <div class="card h-100 w-100 shadow">
        <div class="card-header">
            <span class="h5 attribute-label">{{ aboutme.toUpperCase() }}</span>
            <b-button variant="success" class="float-right" title="Promeni podatke"><i class="dripicons-user"></i></b-button>
        </div>
        <div class="card-body pt-0 pb-0">
            <div class="row h-100">
                <div class="col-lg-4 h-100 p-1">
                    <div class="h-100 w-100 overflow-hidden">
                        <img v-if="mentor != null && mentor.photo != null && mentor.photo.value.length > 0" :src="mentor.photo.value" class="h-100"/>
                        <img v-if="mentor == null || mentor.photo == null || mentor.photo.value.length == 0" src="/images/custom/nophoto2.png" class="h-100"/>
                    </div>

                </div>
                <div class="col-lg-8 h-100 overflow-auto pt-1">
                    <table class="table table-sm table-borderless table-striped">
                        <tbody class="font-12 text-dark">
                            <tr v-for="(value, name) in mentor" v-if="!['photo', 'remark'].includes(name)">
                                <td style="width: 20%" class="text-dark"><strong>{{ value.label }}</strong></td>
                                <td>{{ value.value }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "MentorData",
    props: {
        mentorid: 0,
        aboutme: {typeof: String, default: 'About Me'}
    },
    methods : {
        getData() {
            if(this.mentorid != 0) {
                axios.get(`/mentors/showdata/${this.mentorid}`)
                    .then(response => {
                         this.mentor = response.data;
                    });
            }
        }
    },
    data() {
        return {
            mentor: null,
            keys: [],
            values: []
        }
    },
    mounted() {
        this.getData();
    }

}
</script>

<style scoped>

</style>
