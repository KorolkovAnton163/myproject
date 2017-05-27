<template>
    <div class="header-container"  :class="{'border': !show && isAccount}">
        <div class="header" v-if="!isAccount">
            <div class="introduction-outer-container">
                <div class="introduction-inner-container">
                    <h1>MyAniList</h1>
                    <auth></auth>
                </div>
            </div>
            <div class="previews-outer-container">
                <span class="more-button" @click="scrollTo">
                    <svg class="svg-icon">
                        <use xlink:href="#icon-arrow"></use>
                    </svg>
                </span>
                <div class="previews-inner-container">
                    <div class="previews-wrapper">
                        <router-link v-if="entries" v-for="entry in entries"
                                     :to="{name:'entry', params: {alias: entry.alias}}"
                                     :style="{backgroundImage: 'url(' + entry.image.path + ')'}">
                            <span class="title">{{ entry.title }}</span>
                        </router-link>
                    </div>
                </div>
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
            'account-menu': require('./AccountMenu.vue'),
            'auth': require('./Auth.vue')
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
                this.isAccount = (this.$route.path.indexOf('profile') !== -1) ||
                    (this.$route.path.indexOf('admin') !== -1);
            },
            scrollTo () {
                $('html, body').animate({
                    scrollTop: $('.previews-inner-container').offset().top - 50
                }, 1000);
            }
        },
        created () {
            this.checkIsAccount();
            this.getNew();
        }
    }
</script>