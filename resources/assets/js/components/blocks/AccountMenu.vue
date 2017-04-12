<template>
    <div class="account-menu">
        <div class="menu-wrapper" v-if="user">
            <router-link :to="{ name:'profile' }">Profile</router-link>
            <router-link class="bookmark" :to="{ name:'bookmarks' }">Bookmarks</router-link>
            <router-link v-if="user && user.canRolesEdit" :to="{ name:'role-edit' }">Roles</router-link>
        </div>
    </div>
</template>
<script>
    module.exports = {
        computed: {
            user () {
                return this.$store.getters.user
            }
        }
    }
</script>