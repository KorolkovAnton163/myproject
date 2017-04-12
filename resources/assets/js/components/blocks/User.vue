<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="user-container">
        <div class="user-section" v-if="user">
            <router-link :to="{name:'account'}">{{ user.name }}</router-link>
            <router-link :to="{name:'bookmarks'}">
                <svg class="svg-icon">
                    <use xlink:href="#icon-bookmark"></use>
                </svg>
                bookmarks
            </router-link>
            <a class="logout" v-on:click.prevent="logout">Logout</a>
        </div>
        <div class="login-section" v-else>
            <login-popup></login-popup>
            <register-popup></register-popup>
        </div>
    </div>
</template>
<script>
    module.exports = {
        computed: {
            user () {
                return this.$store.getters.user
            }
        },
        methods: {
            logout () {
                this.$http.post(location.origin + '/logout').then((responce) => {
                    this.$store.dispatch('removeUser');
                    this.$router.push({name: 'posts'});
                });
            }
        },
        components: {
            'login-popup': require('./PopupLogin.vue'),
            'register-popup': require('./PopupRegister.vue')
        }
    }
</script>