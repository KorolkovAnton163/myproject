<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div class="account-menu">
        <div class="menu-button htx ripple-effect" v-on:click="showMenu"
             v-bind:class="{ 'is-active': show }">
            <span>opened</span>
        </div>
        <div class="menu-wrapper" v-show="show">
            <router-link :to="{ name:'profile' }">Profile</router-link>
            <router-link :to="{ name:'bookmarks' }">Bookmarks</router-link>
            <router-link v-if="user && user.canRolesEdit" :to="{ name:'role-edit' }">Roles</router-link>
        </div>
    </div>
</template>
<script>
    module.exports = {
        data () {
            return {
                show: window.innerWidth > 650
            }
        },
        computed: {
            user () {
                return this.$store.getters.user
            }
        },
        mounted() {
            window.addEventListener('resize', () => {
                this.show = window.innerWidth > 650;
            });
        },
        methods: {
            showMenu () {
                if (window.innerWidth < 650) {
                    this.show = !this.show;
                }
            }
        }
    }
</script>