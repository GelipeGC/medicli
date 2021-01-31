<template>
<div class="main-content bg-default">
    <navbar />

    <div class="container mt-4">
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
    /* computed: {
        title() {
            return (this.$route.name == "login") ? this.$t('login') : this.$t('register');
        },
        titleInfo() {
            return (this.$route.name == "login") ? this.$t('login_info') : this.$t('register_info');
        }
    }, */
}
</script>
