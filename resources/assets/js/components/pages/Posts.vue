<template>
    <div class="page-container posts-page-container">
        <loader :loading="loading"></loader>
        <span class="clear-search" v-if="$route.query.search">
            Вы искали: <a>{{ this.$route.query.search }}</a>
            <svg class="svg-icon" @click="clearQuery">
                <use xlink:href="#icon-delete"></use>
            </svg>
        </span>
        <div class="posts-container" v-if="posts">
            <div class="post" v-for="post in posts">
                <h2>
                    <router-link class="ripple" :to="{name:'entry', params: {alias: post.alias}}">
                        {{ post.title }}
                    </router-link>
                </h2>
                <post-description :entry="post"></post-description>
            </div>
            <pagination :params="params" :callback="getPosts"></pagination>
        </div>
        <div class="posts-container page-not-found white" v-else>
            <p>Ничего не найдено :(</p>
        </div>
        <filters :years="years" :tags="tags"></filters>
    </div>
</template>
<script>
    module.exports = {
        data () {
            return {
                posts: [],
                tags: [],
                years: [],
                params: {
                    total: 0,
                    on_page: 10,
                    current_page: 1,
                    url_params: 'posts',
                    scroll_to: '.posts-page-container'
                },
                loading: false
            }
        },
        mounted () {
            this.$root.$on('changeTags', () => {
                this.getPosts(true);
            });
            this.$root.$on('changeYear', () => {
                this.getPosts(true);
            });
            this.$root.$on('search', () => {
                this.getPosts(true);
            });
            this.$root.$on('home', () => {
                this.getPosts(false);
            });
        },
        components: {
            'pagination': require('../blocks/Pagination.vue'),
            'filters': require('../blocks/Filters.vue'),
            'post-description': require('../blocks/PostDescription.vue'),
            'loader': require('../blocks/Loader.vue')
        },
        methods: {
            getPosts (scroll) {
                let formData = new FormData(),
                    page = this.$route.query.page ? this.$route.query.page : 1,
                    tags = this.$route.query.tags ? this.$route.query.tags : null,
                    year = this.$route.query.year ? this.$route.query.year : null,
                    searchQuery = this.$route.query.search ? this.$route.query.search : null;

                formData.append('page', page);
                !!searchQuery && formData.append('search', searchQuery);
                !!tags && formData.append('tags', tags.split('-tag-'));
                !!year && formData.append('year', year);
                this.params.current_page = parseInt(page);
                this.loading = true;

                this.$http.post(location.origin + '/entries', formData).then((responce) => {
                    this.posts = !_.isEmpty(responce.data.entries) ? responce.data.entries : null;
                    this.params.total = parseInt(responce.data.count);
                    this.tags = responce.data.tags;
                    this.years = responce.data.years;
                    this.loading = false;
                    !!scroll && this.scrollTo();
                }, (responce) => {
                    this.$root.$emit('fail', responce);
                    this.loading = false;
                });
            },
            clearQuery () {
                this.$root.$emit('clearSearch');
                this.$router.push({name: 'posts'});
                this.getPosts(true);
            },
            scrollTo () {
                $('html, body').animate({
                    scrollTop: $('.posts-page-container').offset().top - 50
                }, 1000);
            }
        },
        destroyed () {
            this.$root.$off('changeTags');
            this.$root.$off('changeYear');
            this.$root.$off('search');
            this.$root.$off('home');
        }
    }
</script>