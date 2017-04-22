<template>
    <div class="header-container"  :class="{'border': !show && isAccount}">
        <div class="header" v-if="!isAccount">
            <div class="header-inner">
                <router-link v-if="entries" v-for="entry in entries"
                             :to="{name:'post', params: {alias: entry.alias}}"
                             :style="{backgroundImage: 'url(' + entry.image.path + ')'}">
                    <span class="title">{{ entry.title }}</span>
                </router-link>
            </div>
        </div>
        <account-menu v-else v-show="show"></account-menu>
    </div>
</template>
<script>
    module.exports = {
        data () {
            return {
                entries: [],
                isAccount: false,
                show: window.innerWidth > 500
            }
        },
        watch: {
            '$route' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.checkIsAccount();
                    this.getNew();
                }
            }
        },
        components: {
            'account-menu': require('./AccountMenu.vue')
        },
        mounted () {
            window.addEventListener('resize', () => {
                this.show = window.innerWidth > 500;
            });
        },
        methods: {
            getNew () {
                if (!this.isAccount) {
                    this.$http.post(location.origin + '/entries/new').then((responce) => {
                        this.entries = responce.data;
                    });
                }
            },
            checkIsAccount () {
                this.isAccount = (this.$route.path.indexOf('account') !== -1);
            }
        },
        created () {
            this.checkIsAccount();
            this.getNew();
        }
    }
</script>