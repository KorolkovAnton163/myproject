<template>
    <div>
        <div class="header" v-if="!isAccount">
            <h1 >This is site header</h1>
        </div>
        <account-menu v-else></account-menu>
    </div>
</template>
<script>
    module.exports = {
        computed: {
            isAccount () {
                return this.$route.path.indexOf('account') !== -1;
            }
        },
        components: {
            'account-menu': require('./AccountMenu.vue'),
        }
    }
</script>