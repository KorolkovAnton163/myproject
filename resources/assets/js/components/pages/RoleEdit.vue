<template>
    <div class="page-container admin-page-container">
        <div v-if="user && user.canRolesEdit">Role Edit</div>
        <access-denied v-else></access-denied>
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