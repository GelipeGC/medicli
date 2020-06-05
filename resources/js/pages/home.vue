<template>
<base-header type="gray-200 " class="pb-6 pb-8 pt-5 pt-md-8">
    <!-- Card stats -->
    <div class="row">
        {{ $t('you_are_logged_in')}}
    </div>
</base-header>
</template>

<script>
export default {
    middleware: 'auth',
    layout: 'DashboardLayout',
    metaInfo() {
        return {
            title: this.$t('home')
        }
    }
}
</script>
