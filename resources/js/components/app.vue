<template>
  <div class="flex flex-1 h-screen flex-col" v-if="authUser">
    <app-nav></app-nav>
    <div class="flex overflow-y-hidden flex-1">
      <app-sidebar></app-sidebar>
      <div class="w-3/5 overflow-y-scroll hide-scroll-bar px-4">
        <router-view :key="$route.fullPath"></router-view>
      </div>
      <div class="w-1/4"></div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import appNav from './nav.vue';
import appSidebar from './sidebar.vue';
    export default {
        name: 'app',
        components: {
            appNav,
            appSidebar
        },
        created() {
          this.$store.dispatch('setPageTitle', this.$route.meta.title)
          
        },
      mounted() {
        this.$store.dispatch('fetchAuthUser')
      },
      computed: {
        ...mapGetters({
          authUser: 'authUser'
        })
      },
      watch: {
        $route(to){
          this.$store.dispatch('setPageTitle', to.meta.title)
        }
      }
    }
</script>
<style scoped>
.hide-scroll-bar::-webkit-scrollbar {
  display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.hide-scroll-bar {
  -ms-overflow-style: none; /* IE and Edge */
  scrollbar-width: none; /* Firefox */
}
</style>