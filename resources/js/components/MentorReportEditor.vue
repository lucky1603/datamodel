<template>
    <div class="card">
        <div class="card-header bg-dark text-light">
            <span class="h4">{{ report.name }}</span>
        </div>
        <div class="card-body">
            <p><strong>{{ _('gui.mentor_report_due_date') }}: </strong>{{ report.dueDate }}</p>
            <div class="d-flex flex-column justify-content-center align-items-center shadow-sm">
                <p class="text-center h5 attribute-label mb-2">{{ _('gui.mentor_report_attached_documents')}}</p>

                <file-group-viewer
                    v-for="(fileGroup, index) in report.file_groups"
                    :file_group="fileGroup"
                    :index="index + 1" :key="index" class="m-2 shadow" style="width: 50vw"></file-group-viewer>
                <button type="button" class="btn btn-success rounded-circle mt-4 mb-2" :title="_('gui.mentor_report_append_document')" @click="add">+</button>
            </div>

            <div class="d-flex align-items-center justify-content-center mt-4">
                <b-button variant="primary" type="button" @click="close">{{ _('gui.close') }}</b-button>
            </div>
        </div>
        <b-modal id="addReportModal" ref="addReportModal" header-bg-variant="dark" header-text-variant="light" >
            <template #modal-title>{{ _('gui.mentor_report_append_document') }}</template>
            <file-group-editor
                ref="fed"
               :show_buttons="false"
               :token="token"
               :report_id="report_id"
                action="/mentor-reports/addFileGroup"
                :title="_('gui.report')"
            ></file-group-editor>
            <template #modal-footer>
                <b-button type="button" variant="primary" @click="onOk">{{ _('gui.accept') }}</b-button>
                <b-button type="button" variant="danger" @click="onCancel">{{ _('gui.cancel') }}</b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
export default {
    name: "MentorReportEditor",
    props: {
        report_id: { typeof: Number, default: 0 },
        backroute: { typeof: String, default: ''},
        token : { typeof: String, default: ''}
    },
    methods: {
        add() {
            this.$refs['addReportModal'].show();
        },
        async onOk() {
            await this.$refs.fed.onSubmit();
            this.$refs['addReportModal'].hide();
            location.reload();
        },
        onCancel() {
            this.$refs['addReportModal'].hide();
        },
        close() {
            location.href = this.backroute;
        },
        async getData() {
            await axios.get('/mentor-reports/get/'+this.report_id)
            .then(response => {
                console.log(response.data);
                this.report = response.data;
            });
        }
    },
    async mounted() {
        await this.getData();
    },
    data() {
        return {
            filesSent: false,
            report : null
        }
    }
}
</script>

<style scoped>

</style>
