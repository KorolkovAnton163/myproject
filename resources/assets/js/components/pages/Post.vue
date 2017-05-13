<template>
    <div class="page-container single-post-page-container">
        <loader :loading="loading"></loader>
        <div class="post-container" v-if="post">
            <h2>{{ post.title }}</h2>
            <post-description :entry="post" :button="false"></post-description>
            <post-videos v-if="isVideos" :entry="post"></post-videos>
            <comments :entry="post"></comments>
        </div>
        <div class="page-not-found" v-else-if="noPost">
            <cat></cat>
            <p>Запись не найдена :(</p>
        </div>
    </div>
</template>

<script>
    module.exports = {
        data () {
            return {
                post: null,
                noPost: false,
                isVideos: false,
                loading: false
            }
        },
        watch: {
            '$route.params.alias' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.getSinglePost(newVal);
                }
            }
        },
        computed: {
            user () {
                return this.$store.getters.user
            }
        },
        components: {
            'post-description': require('../blocks/PostDescription.vue'),
            'post-videos': require('../blocks/Vdeos.vue'),
            'loader': require('../blocks/Loader.vue'),
            'comments': require('../blocks/Comments.vue')
        },
        methods: {
            getSinglePost (alias) {
                this.loading = true;
                this.$http.post(location.origin + '/entries/' + alias + '/show').then((responce) => {
                    this.post = responce.data;
                    this.isVideos = !!responce.data.videos.length;
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