<template>
    <div class="page-container single-post-page-container" v-if="post">
        <h2>{{ post.title }}</h2>
        <post-description :entry="post" :button="false"></post-description>
    </div>
    <div class="page-not-found" v-else-if="noPost">
        <cat></cat>
        <p>Post not found</p>
    </div>
</template>

<script>
    module.exports = {
        data () {
            return {
                post: null,
                noPost: false
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
            'post-description': require('../blocks/PostDescription.vue')
        },
        methods: {
            getSinglePost (alias) {
                this.$http.post(location.origin + '/entries/' + alias + '/show').then((responce) => {
                    this.post = responce.data;
                }, (responce) => {
                    this.noPost = true
                });
            }
        },
        created () {
            this.getSinglePost(this.$route.params.alias);
        }
    }
</script>