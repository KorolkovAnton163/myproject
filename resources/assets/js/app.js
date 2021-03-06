require('./bootstrap');

import Vue from 'vue'
import VueResource from 'vue-resource'
import VeeValidate from 'vee-validate'
import VueTouch from 'vue-touch'
import { router } from './router.js'
import { store } from './storage.js'

Vue.use(VueResource);
Vue.use(VeeValidate);
Vue.use(VueTouch);

Vue.http.headers.common['X-CSRF-TOKEN'] = Laravel.csrfToken;

Vue.component('cat', require('./components/blocks/Cat.vue'));
Vue.component('message-box', require('./components/blocks/MessageBox.vue'));
Vue.component('access-denied', require('./components/pages/AccessDenied.vue'));

new Vue({
    el: '#app',
    store,
    router: router,
    components: {
        'top-nav-menu': require('./components/blocks/TopNavMenu.vue'),
        'app-header': require('./components/blocks/Header.vue'),
        'app-footer': require('./components/blocks/Footer.vue')
    },
    created () {
        this.$store.dispatch('addUser', user);
    }
});