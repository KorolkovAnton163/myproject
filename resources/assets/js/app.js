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
    methods: {
        getUser () {
            this.$http.post(location.origin + '/api/user/get').then((responce) => {
                this.$store.dispatch('addUser', !_.isEmpty(responce.data) ? responce.data : null);
            });
        }
    },
    created () {
        this.getUser();
    }
});
