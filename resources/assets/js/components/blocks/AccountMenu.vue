<template>
    <div class="account-menu">
        <router-link :to="{ name:'profile' }">Profile</router-link>
        <router-link :to="{ name:'bookmarks' }">Bookmarks</router-link>
        <router-link v-if="user && user.canRolesEdit" :to="{ name:'role-edit' }">Profile</router-link>
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