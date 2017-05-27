<template>
    <div class="user-container">
        <div class="user-section" v-if="user">
            <router-link :to="{name:'account'}">{{ user.name }}</router-link>
            <router-link :to="{name:'bookmarks'}">
                <svg class="svg-icon">
                    <use xlink:href="#icon-bookmark"></use>
                </svg>
                закладки
            </router-link>
            <a class="logout" href="/logout">Выход</a>
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
    }
</script>