<template>
<div class="row justify-content-center">
    <div class="col-lg-5">
        <card :urlImg="'/img/medi_logo.png'" :redirection="{ name: 'login' }" :customStyles="'bg-primary pb-3 pt-3 text-center'" :titleStyle="'text-center mt-0 font-weight-bold'">
            <form @submit.prevent="login" @keydown="form.onKeydown($event)" slot="card-body">

                <div class="text-center w-75 m-auto">
                    <h4 class="text-dark-50 text-center mt-0 font-weight-bold">{{ $t('login') }}</h4>
                    <p class="text-muted mb-4">{{ $t('login_info')}}</p>
                </div>
                <alert :type="'warning'" :form="form" :message="user_inactive" :show="show" />

                <!-- Email -->
                <div class="form-group">
                    <label>{{ $t('email') }}</label>
                    <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
                    <has-error :form="form" field="email" />
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label>{{ $t('password') }}</label>
                    <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
                    <has-error :form="form" field="password" />
                </div>

                <!-- Remember Me -->
                <div class="form-group row">
                    <div class="col-md-3" />
                    <div class="col-md-7 d-flex">
                        <checkbox v-model="remember" name="remember">
                            {{ $t('remember_me') }}
                        </checkbox>

                        <router-link :to="{ name: 'password.request' }" class="small ml-auto my-auto">
                            {{ $t('forgot_password') }}
                        </router-link>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-9 offset-md-3 d-flex">
                        <!-- Submit Button -->
                        <v-button :loading="form.busy">
                            {{ $t('login') }}
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
import LoginWithGithub from '~/components/LoginWithGithub'
import LoginWithFacebook from '~/components/LoginWithFacebook'
import LoginWithTwitter from '~/components/LoginWithTwitter'

export default {
    middleware: 'guest',
    layout: 'authentication',
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

            // Redirect home.
            this.$router.push({
                name: 'home'
            })
        }
    }
}
</script>
