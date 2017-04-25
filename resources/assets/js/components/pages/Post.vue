<template>
    <div class="page-container single-post-page-container">
        <loader :loading="loading"></loader>
        <div class="post-container" v-if="post">
            <h2>{{ post.title }}</h2>
            <post-description :entry="post" :button="false"></post-description>
        </div>
        <div class="page-not-found" v-else-if="noPost">
            <cat></cat>
            <p>Post not found</p>
        </div>
    </div>
</template>

<script>
    module.exports = {
        data () {
            return {
                post: null,
                noPost: false,
                loading: false,
            }
        },
        watch: {
            '$route.params.alias' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.getSinglePost(newVal);
                }
            }
        },
        components: {
            'post-description': require('../blocks/PostDescription.vue'),
            'loader': require('../blocks/Loader.vue')
        },
        methods: {
            getSinglePost (alias) {
                this.loading = true;
                this.$http.post(location.origin + '/entries/' + alias + '/show').then((responce) => {
                    this.post = responce.data;
                    this.loading = false;
                }, (responce) => {
                    this.noPost = true;
                    this.loading = false;
                });
            }
        },
        created () {
            this.getSinglePost(this.$route.params.alias);
        }
    }
</script>