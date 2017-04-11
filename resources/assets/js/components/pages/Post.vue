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
        components: {
            'post-description': require('../blocks/PostDescription.vue')
        },
        computed: {
            resource () {
                return this.$resource('https://jsonplaceholder.typicode.com/posts{/id}');
            }
        },
        methods: {
            getSinglePost (postId) {
                this.resource.get({id: postId}).then((responce) => {
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