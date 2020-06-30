<template>
  <div class="wrapper" :class="{ 'nav-open': $sidebar.showSidebar }">
    <side-bar
      :background-color="sidebarBackground"
      :logo="'/img/brand/blue.png'"
      short-title="Medic"
      title="Medic"
    >
      <hr class="my-3">
      <h6 class="navbar-heading text-muted">{{$t('sidebar.info')}}</h6>
      <template slot="links">
        <sidebar-item
          :link="{
            name: 'Dashboard',
            icon: 'ni ni-tv-2 text-primary',
            path: '/dashboard'
          }"
        />
        <sidebar-item :link="{name: 'Especialidades', icon: 'ni ni-planet text-blue', path: '/specialties'}"/>
        <sidebar-item :link="{name: 'Médicos', icon: 'ni ni-single-02 text-red', path: '/icons'}"/>
        <sidebar-item :link="{name: 'Pacientes', icon: 'ni ni-satisfied text-info', path: '/icons'}"/>
        <sidebar-item :link="{name: 'Cerrar sesión', icon: 'ni ni-planet text-blue', path: '/icons'}"/>

        <hr class="my-3">
        <h6 class="navbar-heading text-muted">Documentation</h6>
        <sidebar-item :link="{name: 'Frecuencias de citas', icon: 'ni ni-sound-wave text-yellow', path: '/icons'}"/>
        <sidebar-item :link="{name: 'Médicos más activos', icon: 'ni ni-spaceship text-orange', path: '/icons'}"/>

      </template>
    </side-bar>
    <div class="main-content" :data="sidebarBackground">
      <dashboard-navbar></dashboard-navbar>

      <div @click="toggleSidebar">
          <!-- your content here -->
          
        <child />

        <content-footer v-if="!$route.meta.hideFooter"></content-footer>
      </div>
    </div>
  </div>
</template>
<script>
  import DashboardNavbar from './DashboardNavbar.vue';
  import ContentFooter from './ContentFooter.vue';
  import { FadeTransition } from 'vue2-transitions';

  export default {
    name: 'DashboardLayout',
    components: {
      DashboardNavbar,
      ContentFooter,
      FadeTransition
    },
    data() {
      return {
        sidebarBackground: 'blue', //vue|blue|orange|green|red|primary
        appName: 'medi'
      };
    },
    methods: {
      toggleSidebar() {
        if (this.$sidebar.showSidebar) {
          this.$sidebar.displaySidebar(false);
        }
      }
    }
  };
</script>
<style lang="scss">

</style>
