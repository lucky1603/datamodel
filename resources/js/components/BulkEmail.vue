<template>
  <div class="card w-100 h-100">
<!--      <div class="card-header" id="test">-->
<!--          <span class="h4">POŠALJI GRUPNI E-MAIL</span>-->
<!--      </div>-->
      <div class="card-body">
          <form method="POST" enctype="multipart/form-data" action="#" @submit.prevent="onSubmit">
              <input type="hidden" name="_token" :value="token">
              <div class="text-center">
                  <h4 class="attribute-label">{{ _('gui.reminder_title') }}</h4>
              </div>
              <div class="form-group mt-4">
                  <companies-selector v-model="form.recipients" :source="items_source"></companies-selector>
              </div>
              <div class="form-group">
                  <b-form-textarea v-model="form.content" ref="content" hidden>
                    <slot></slot>
                  </b-form-textarea>
                  <div id="sinisa" ref="sinisa"></div>
              </div>
              <div v-if="!hideButtons" class="text-center">
                  <b-button ref="sendButton" id="sendButton" type="submit" class="mt-3" variant="primary" size="sm" :disabled="form.recipients.length == 0">
                      <b-spinner v-if="showSpinner" small class="ml-2"></b-spinner>
                      {{ _('gui.send')}}
                  </b-button>
                  <b-button
                      ref="cancelButton"
                      id="cancelButton"
                      type="button"
                      class="mt-3"
                      variant="outline-primary"
                      size="sm" @click="onCancel">{{ _('gui.cancel')}}</b-button>
              </div>
          </form>
      </div>
  </div>
</template>

<script>
export default {
    name: "BulkEmail",
    props: {
        token: '',
        content: '',
        items_source: {typeof: String, default:'/profiles/mailClients'},
        recipients: {typeof: Array, default: []},
        hideButtons: {typeof: Boolean, default: false},
        sendAction: {typeof: String, default: '/profiles/bulkMail'}
    },
    methods: {
        initTextArea() {
            $('#sinisa').summernote({
                height: 250,
                colorButton: {
                    foreColor: '#000000',
                    backColor: 'transparent'
                },
                onChange: function() {
                    console.log($(this).summernote('code'));
                }
            });

            $('#sinisa').summernote('code', this.content);
        },
        async onSubmit() {
            this.form.content = $('#sinisa').summernote('code');
            this.showSpinner = true;
            let data = new FormData();
            for(let i = 0; i < this.form.recipients.length; i++) {
                data.append('recipients[]', this.form.recipients[i].value);
            }

            data.append('content', this.form.content);
            data.append('_token', this.token);

            await axios.post(this.sendAction, data)
            .then(response => {
                console.log(response.data);
                this.showSpinner = false;
                // location.href='/profiles';
            });

        },
        onCancel() {
            history.back();
        }
    },
    mounted() {
        setTimeout(this.initTextArea, 1000);
    },
    data() {
        return {
            form: {
                recipients: this.recipients,
                content: this.content
            },
            showSpinner: false
        }
    }
}
</script>

<style scoped>

</style>
