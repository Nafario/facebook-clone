<template>
  <div class="flex flex-1 h-screen flex-col">
    <app-nav></app-nav>
    <div class="flex overflow-y-hidden flex-1">
      <app-sidebar></app-sidebar>
      <div class="w-3/5 overflow-y-scroll hide-scroll-bar px-4">
        <router-view></router-view>
      </div>
      <div class="w-1/4"></div>
    </div>
  </div>
</template>

<script>
import appNav from './nav.vue';
import appSidebar from './sidebar.vue';
    export default {
        name: 'app',
        components: {
            appNav,
            appSidebar
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