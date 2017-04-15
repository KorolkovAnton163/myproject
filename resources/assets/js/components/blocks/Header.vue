<template>
    <div class="header-container" :class="{'border': !show && isAccount}">
        <div class="header" v-if="!isAccount">
            <h1 >This is site header</h1>
        </div>
        <account-menu v-else v-show="show"></account-menu>
    </div>
</template>
<script>
    module.exports = {
        data () {
            return {
                show: window.innerWidth > 500
            }
        },
        computed: {
            isAccount () {
                return this.$route.path.indexOf('account') !== -1;
            }
        },
        components: {
            'account-menu': require('./AccountMenu.vue'),
        },
        mounted() {
            window.addEventListener('resize', () => {
                this.show = window.innerWidth > 500;
            });
        }
    }
</script>