<template>
<div class="main-content bg-default">
    <navbar />
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ title }}</h1>
                        <p class="text-lead text-white">{{ titleInfo}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>
    <div class="container mt--8 pb-5">
        <child />
    </div>
</div>
</template>

<script>
import Navbar from '~/components/Navbar'
export default {
    name: 'MainLayout',

    components: {
        Navbar
    },
    computed: {
        title() {
            return (this.$route.name == "login") ? this.$t('login') : this.$t('register');
        },
        titleInfo() {
            return (this.$route.name == "login") ? this.$t('login_info') : this.$t('register_info');
        }
    },
}
</script>
