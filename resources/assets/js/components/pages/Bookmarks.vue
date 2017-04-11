<template>
    <div class="page-container bookmark-page-container">
        <div v-if="user">Bookmark</div>
        <access-denied v-else></access-denied>
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