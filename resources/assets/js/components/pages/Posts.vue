<template>
    <div class="page-container posts-page-container">
        <div class="posts-container" v-if="posts">
            <div class="post" v-for="post in posts">
                <h2>
                    <router-link class="ripple" :to="{name:'entry', params: {alias: post.alias}}">{{ post.title }}
                    </router-link>
                </h2>
                <post-description :post="post"></post-description>
            </div>
            <pagination :params="params" :callback="getPosts"></pagination>
        </div>
        <div class="posts-container page-not-found white" v-else>
            <p>No results</p>
        </div>
        <filters :tags="tags"></filters>
    </div>
</template>
<script>
    module.exports = {
        data () {
            return {
                posts: [],
                tags: [],
                params: {
                    total: 0,
                    on_page: 10,
                    current_page: 1,
                    url_params: 'posts'
                }
            }
        },
        watch: {
            '$route.query.tags' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.getPosts();
                }
            },
            '$route.query.search' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.getPosts();
                }
            }
        },
        components: {
            'pagination': require('../blocks/Pagination.vue'),
            'filters': require('../blocks/Filters.vue'),
            'post-description': require('../blocks/PostDescription.vue')
        },
        methods: {
            getPosts () {
                let formData = new FormData(),
                    page = this.$route.query.page ? this.$route.query.page : this.params.current_page,
                    tags = this.$route.query.tags ? this.$route.query.tags : null,
                    searchQuery = this.$route.query.search ? this.$route.query.search : null;

                formData.append('page', page);

                if (searchQuery) {
                    formData.append('search', searchQuery);
                }

                if (tags) {
                    formData.append('tags', tags.split('-tag-'));
                }

                this.params.current_page = parseInt(page);

                this.$http.post(location.origin + '/entries', formData).then((responce) => {
                    this.posts = !_.isEmpty(responce.data.entries) ? responce.data.entries : null;
                    this.params.total = parseInt(responce.data.count);
                    if (_.isEmpty(this.tags)) {
                        this.tags = responce.data.tags;
                    }
                });
            }
        }
    }
</script>