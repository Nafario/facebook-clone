import Vue from 'vue'
import VueRouter from 'vue-router'
import newsFeed from './views/newsFeed.vue';
import userShow from './views/users/show.vue';
Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',

    routes: [
        {
            path: '/', component: newsFeed, name:'home', meta: {title: 'NewsFeed'}
        },
        {
            path: '/users/:id', component: userShow , name:'user.show', meta: {title: 'Profile'}
        }
    ]
})