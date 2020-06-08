<template>
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="card bg-secondary shadow border-0">
            <div class="card-body px-lg-5 py-lg-5">

                <form @submit.prevent="register" @keydown="form.onKeydown($event)">
                    <div class="form-group mb-3">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                            </div>
                            <basic-input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" :label="$t('name')" id="name" type="text" name="name" />
                            <has-error :form="form" field="name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-alternative mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                            </div>
                            <basic-input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" :label="$t('email')" id="email" class="form-control" type="email" name="email" />
                            <has-error :form="form" field="email" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                            </div>
                            <basic-input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" :label="$t('password')" class="form-control" type="password" name="password" />
                            <has-error :form="form" field="password" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                            </div>
                            <basic-input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" :label="$t('confirm_password')" class="form-control" type="password" name="password_confirmation" />
                            <has-error :form="form" field="password_confirmation" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-7 offset-md-3 d-flex">
                            <!-- Submit Button -->
                            <v-button :loading="form.busy">
                                {{ $t('register') }}
                            </v-button>

                            <!-- GitHub Register Button -->
                            <login-with-github />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import Form from 'vform'
import LoginWithGithub from '~/components/LoginWithGithub'

export default {
    middleware: 'guest',

    components: {
        LoginWithGithub
    },

    metaInfo() {
        return {
            title: this.$t('register')
        }
    },

    data: () => ({
        form: new Form({
            name: '',
            email: '',
            password: '',
            password_confirmation: ''
        })
    }),

    methods: {
        async register() {
            // Register the user.
            const {
                data
            } = await this.form.post('/api/register')

            // Log in the user.
            const {
                data: {
                    token
                }
            } = await this.form.post('/api/login')

            // Save the token.
            this.$store.dispatch('auth/saveToken', {
                token
            })

            // Update the user.
            await this.$store.dispatch('auth/updateUser', {
                user: data
            })

            // Redirect home.
            this.$router.push({
                name: 'home'
            })
        }
    }
}
</script>
