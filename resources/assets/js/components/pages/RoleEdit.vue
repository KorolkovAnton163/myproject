<template>
    <div class="page-container role-edit-page-container">
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
        methods: {
            getRoles () {
                this.$http.post(location.origin + '/roles').then((responce) => {
                    console.log(responce.data);
                });
            }
        },
        created () {
            this.getRoles();
        }
    }
</script>