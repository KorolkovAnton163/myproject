import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

export let router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    routes: [
        { path: '/', name: 'posts', component: require('./components/pages/Posts.vue') },
        { path: '/post/:id', name: 'post', component: require('./components/pages/Post.vue') },
        { path: '/account', name: 'account', component: require('./components/pages/User.vue') },
        { path: '/bookmarks', name: 'bookmarks', component: require('./components/pages/Bookmarks.vue') },
        { path: '*', component: require('./components/pages/NotFound.vue') }
    ]
});