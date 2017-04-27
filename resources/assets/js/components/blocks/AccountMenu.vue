<template>
    <div class="account-menu">
        <div class="menu-wrapper" v-if="user">
            <router-link :to="{ name:'profile' }" exact>Профиль</router-link>
            <router-link class="bookmark" :to="{ name:'bookmarks' }">Закладки</router-link>
            <router-link v-if="user && user.canRolesEdit" :to="{ name:'role-edit' }">Роли</router-link>
            <router-link v-if="user && user.canUsersEdit" :to="{ name:'users' }">Пользователи</router-link>
            <router-link v-if="user && user.canEntryEdit" :to="{ name:'entry-edit' }">Записи</router-link>
            <router-link v-if="user && user.canTagsEdit" :to="{ name:'tags' }">Тэги</router-link>
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