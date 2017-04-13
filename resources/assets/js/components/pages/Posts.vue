<template>
    <div class="page-container posts-page-container">
        <div class="posts-container" v-if="posts">
            <div class="post" v-for="post in posts">
                <h2>
                    <router-link class="ripple" :to="{name:'post', params: {id: post.id}}">{{ post.title }}
                    </router-link>
                </h2>
                <post-description :post="post"></post-description>
            </div>
            <pagination :params="params" :callback="getPosts"></pagination>
        </div>
        <div class="posts-container page-not-found" v-else>
            <cat></cat>
            <p>No results</p>
        </div>
        <filters></filters>
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
                    url_params: 'posts'
                }
            }
        },
        mounted () {
            this.$root.$on('search', (query) => {
                // console.log('search: ' + query);
            });
            this.$root.$on('filters', (tags) => {
                // console.log(tags);
            });
        },
        components: {
            'pagination': require('../blocks/Pagination.vue'),
            'filters': require('../blocks/Filters.vue'),
            'post-description': require('../blocks/PostDescription.vue')
        },
        methods: {
            getPosts () {
                let page = this.$route.query.page ? this.$route.query.page : this.params.current_page;

                this.params.current_page = parseInt(page);

                this.$http.post(location.origin + '/entries', {page: page}).then((responce) => {
                    this.posts = responce.data.count ? responce.data.entries : null;
                    this.params.total = parseInt(responce.data.count);
                });
            }
        }
    }
</script>