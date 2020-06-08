<template>
<div class="row">
    <div class="col-lg-8 m-auto">
        <card :title="$t('reset_password')">
            <form @submit.prevent="send" @keydown="form.onKeydown($event)">
                <alert-success :form="form" :message="status" />

                <!-- Email -->
                <div class="form-group">
                    <div class="input-group input-group-alternative mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                        </div>
                        <basic-input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" :label="$t('email')" id="email" class="form-control" type="email" name="email" />
                        <has-error :form="form" field="email" />
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group row">
                    <div class="col-md-9 ml-md-auto">
                        <v-button :loading="form.busy">
                            {{ $t('send_password_reset_link') }}
                        </v-button>
                    </div>
                </div>
            </form>
        </card>
    </div>
</div>
</template>

<script>
import Form from 'vform'

export default {
    middleware: 'guest',

    metaInfo() {
        return {
            title: this.$t('reset_password')
        }
    },

    data: () => ({
        status: '',
        form: new Form({
            email: ''
        })
    }),

    methods: {
        async send() {
            const {
                data
            } = await this.form.post('/api/password/email')

            this.status = data.status

            this.form.reset()
        }
    }
}
</script>
