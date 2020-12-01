import Vue from 'vue'
import VueRouter from 'vue-router'
import newsFeed from './views/newsFeed.vue';
Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',

    routes: [
        {
            path: '/', component: newsFeed, name:'home'
        }
    ]
})