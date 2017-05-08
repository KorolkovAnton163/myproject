<template>
    <div class="page-container single-post-page-container">
        <loader :loading="loading"></loader>
        <div class="post-container" v-if="post">
            <h2>{{ post.title }}</h2>
            <post-description :entry="post" :button="false"></post-description>
            <div class="videos-container" v-if="post.videos">
                <div class="videos-wrapper">
                    <div class="video" v-for="video in post.videos" v-if="video.active">
                        <iframe width="100%" height="390" :src="video.url" frameborder="0" allowfullscreen></iframe>
                        <a v-if="user" class="video-bookmark" title="Закладка на видео" @click.prevent="addVideoBookmark(video)">
                            <svg class="svg-icon">
                                <use xlink:href="#icon-bookmark"></use>
                            </svg>
                        </a>
                    </div>
                    <div class="video-loader-container">
                        <div class="video-loader">Loading...</div>
                    </div>
                </div>
                <div class="videos-navigation-wrapper">
                    <a class="navigation-item ripple" v-for="(video, index) in post.videos"
                         :class="{ active : video.active }" @click.prevent="setActiveVideo(video)">
                        Эпизод #{{index + 1}}
                    </a>
                </div>
            </div>
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
            'loader': require('../blocks/Loader.vue')
        },
        methods: {
            getSinglePost (alias) {
                this.loading = true;
                this.$http.post(location.origin + '/entries/' + alias + '/show').then((responce) => {
                    this.post = responce.data;
                    this.setActiveVideo();
                    this.loading = false;
                }, (responce) => {
                    this.noPost = true;
                    this.loading = false;
                });
            },
            setActiveVideo (video) {
                if (this.post.videos.length) {
                    if (!!video) {
                        this.post.videos.forEach((item) => {
                            item.active = false;
                        });
                        video.active = true;
                    } else {
                        this.post.videos[0].active = true;
                    }
                }
            },
            addVideoBookmark (video) {
                console.log(video.id)
            }
        },
        created () {
            this.getSinglePost(this.$route.params.alias);
        }
    }
</script>