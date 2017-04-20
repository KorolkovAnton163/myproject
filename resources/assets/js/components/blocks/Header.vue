<template>
    <div class="header-container" :class="{'border': !show && isAccount}">
        <div class="header" v-if="!isAccount">
            <div class="header-inner">
                <router-link v-if="entries" v-for="entry in entries"
                             :to="{name:'post', params: {id: entry.id}}"
                             :style="{backgroundImage: 'url(' + entry.image + ')'}">
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
        mounted () {
            window.addEventListener('resize', () => {
                this.show = window.innerWidth > 500;
            });
        },
        methods: {
            getNew () {
                this.$http.post(location.origin + '/entries/new').then((responce) => {
                    this.entries = responce.data;
                });
            }
        },
        created () {
            this.getNew();
        }
    }
</script>