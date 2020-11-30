import Vue from 'vue'
import VueRouter from 'vue-router'
import Start from './views/start.vue';
Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',

    routes: [
        {
            path: '/', component: Start, name:'home'
        }
    ]
})