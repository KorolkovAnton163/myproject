import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

export let router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    routes: [
        { path: '/', name: 'posts', component: require('./components/pages/Posts.vue') },
        { path: '/entry/:alias', name: 'entry', component: require('./components/pages/Post.vue') },
        { path: '/account', name: 'account', redirect: { name: 'profile' } },
        { path: '/account/profile', name: 'profile', component: require('./components/pages/Profile.vue') },
        { path: '/account/role-edit', name: 'role-edit', component: require('./components/pages/RoleEdit.vue') },
        { path: '/account/users', name: 'users', component: require('./components/pages/Users.vue') },
        { path: '/account/bookmarks', name: 'bookmarks', component: require('./components/pages/Bookmarks.vue') },
        { path: '/account/entry/:id?', name: 'entry-edit', component: require('./components/pages/Entry.vue') },
        { path: '/account/tags', name: 'tags', component: require('./components/pages/Tags.vue') },
        { path: '*', component: require('./components/pages/NotFound.vue') }
    ]
});