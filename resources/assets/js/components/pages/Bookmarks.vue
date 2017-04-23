<template>
    <div class="page-container bookmark-page-container">
        <div class="bookmark-container" v-if="user">
            <h2>Bookmark</h2>
            <div class="posts-container" v-if="posts">
                <div class="post" v-for="post in posts" v-if="post.bookmark">
                    <h2>
                        <router-link class="ripple" :to="{name:'entry', params: {alias: post.alias}}">
                            {{ post.title }}
                        </router-link>
                    </h2>
                    <post-description :post="post"></post-description>
                </div>
                <pagination :params="params" :callback="getPosts"></pagination>
            </div>
            <div class="posts-container page-not-found white" v-else>
                <p>No bookmarks</p>
            </div>
        </div>
        <access-denied v-else></access-denied>
    </div>
</template>
<script>
    module.exports = {
        data () {
            return {
                posts: [],
                params: {
                    total: 0,
                    on_page: 10,
                    current_page: 1,
                    url_params: 'bookmarks'
                }
            }
        },
        mounted () {
            this.$root.$on('removeBookmark', () => {
                this.getPosts();
            });
        },
        computed: {
            user () {
                return this.$store.getters.user
            }
        },
        components: {
            'pagination': require('../blocks/Pagination.vue'),
            'post-description': require('../blocks/PostDescription.vue')
        },
        methods: {
            getPosts () {
                let page = this.$route.query.page ? this.$route.query.page : this.params.current_page;

                this.params.current_page = parseInt(page);

                this.$http.post(location.origin + '/bookmarks', {page: page}).then((responce) => {
                    this.posts = responce.data.count ? responce.data.entries : null;
                    this.params.total = parseInt(responce.data.count);
                });
            }
        },
        destroyed () {
            this.$root.$off('removeBookmark');
        }
    }
</script>