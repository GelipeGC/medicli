<template>
<div class="row justify-content-center">
    <div class="col-lg-5 col-md-7">
        <div class="card bg-secondary shadow border-0">
            <div class="card-body px-lg-5 py-lg-5">

                <form @submit.prevent="login" @keydown="form.onKeydown($event)">
                    <!-- Email -->
                    <div class="form-group mb-3">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                            </div>
                            <basic-input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" :label="$t('email')" id="email" type="emailaddress" name="email" />
                            <has-error :form="form" field="email" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                            </div>
                            <basic-input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" :label="$t('password')" id="password" type="password" name="password" />
                            <has-error :form="form" field="password" />
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <base-checkbox v-model="remember" class="custom-control-alternative">
                        <span class="text-muted"> {{ $t('remember_me') }}</span>
                    </base-checkbox>
                    <div class="text-center">
                        <!-- Submit Button -->
                        <v-button :loading="form.busy" class="my-4">
                            {{ $t('login') }}
                        </v-button>
                    </div>

                </form>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-6">
                <router-link :to="{ name: 'password.request' }" class="text-light">
                    <small>{{$t('forgot_password')}}</small>
                </router-link>
            </div>
            <div class="col-6 text-right">
                <router-link to="/register" class="text-light"><small>{{$t('crate_account')}}</small></router-link>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import Form from 'vform'
import LoginWithGithub from '~/components/LoginWithGithub'
import LoginWithFacebook from '~/components/LoginWithFacebook'
import LoginWithTwitter from '~/components/LoginWithTwitter'

export default {
    middleware: 'guest',

    components: {
        LoginWithGithub,
        LoginWithFacebook,
        LoginWithTwitter
    },

    metaInfo() {
        return {
            title: this.$t('login')
        }
    },

    data: () => ({
        form: new Form({
            email: '',
            password: ''
        }),
        remember: false
    }),

    methods: {
        async login() {
            // Submit the form.
            const {
                data
            } = await this.form.post('/api/login')

            // Save the token.
            this.$store.dispatch('auth/saveToken', {
                token: data.token,
                remember: this.remember
            })

            // Fetch the user.
            await this.$store.dispatch('auth/fetchUser')
            this.form.reset();
            // Redirect home.
            this.$router.push({
                name: 'home'
            })
        }
    }
}
</script>
