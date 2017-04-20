<template>
    <div class="page-container single-post-page-container" v-if="post">
        <h2>{{ post.title }}</h2>
        <post-description :post="post" :button="false"></post-description>
    </div>
    <div class="page-not-found" v-else>
        <cat></cat>
        <p>Post not found</p>
    </div>
</template>

<script>
    module.exports = {
        data () {
            return {
                post: {}
            }
        },
        watch: {
            '$route.params.id' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.getSinglePost(newVal);
                }
            }
        },
        components: {
            'post-description': require('../blocks/PostDescription.vue')
        },
        methods: {
            getSinglePost (postId) {
                this.$http.post(location.origin + '/entries/' + postId + '/show').then((responce) => {
                    this.post = responce.data;
                }, (responce) => {
                    let status = responce.status;
                    if (404 == status) {
                        this.post = null;
                    }
                });
            }
        },
        created () {
            this.getSinglePost(this.$route.params.id);
        }
    }
</script>