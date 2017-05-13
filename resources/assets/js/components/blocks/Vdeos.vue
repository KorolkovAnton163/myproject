<template>
    <div class="videos-container">
        <div class="videos-wrapper">
            <div class="video" v-for="video in entry.videos" v-if="video.active">
                <iframe width="100%" height="390" :src="video.url" frameborder="0" allowfullscreen></iframe>
                <a v-if="user && showNavigation" class="video-bookmark ripple-effect" title="Закладка на видео"
                   :class="{ active : video.bookmark }" @click.prevent="addVideoBookmark(video)">
                    <svg class="svg-icon">
                        <use xlink:href="#icon-bookmark"></use>
                    </svg>
                </a>
            </div>
            <div class="video-loader-container">
                <div class="video-loader">Загрузка...</div>
            </div>
        </div>
        <div class="videos-navigation-wrapper" v-if="showNavigation">
            <a class="navigation-item ripple" v-for="(video, index) in entry.videos"
               :class="{ active : video.active }" @click.prevent="setActiveVideo(video)">
                Эпизод #{{index + 1}}
            </a>
        </div>
    </div>
</template>
<script>
    module.exports = {
        data () {
            return {
                showNavigation: true
            }
        },
        props: {
            entry: {
                type: Object
            }
        },
        computed: {
            user () {
                return this.$store.getters.user
            }
        },
        watch: {
            'entry' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.setActiveVideo();
                }
            }
        },
        methods: {
            setActiveVideo (video) {
                if (!!video) {
                    this.entry.videos.forEach((item) => {
                        item.active = false;
                    });
                    video.active = true;
                } else {
                    let bookmark = this.entry.videos.filter((item) => {
                        return item.bookmark;
                    });
                    if (!bookmark.length) {
                        this.entry.videos[0].active = true;
                    } else {
                        this.entry.videos.forEach((item) => {
                            item.active = item.bookmark;
                        });
                    }
                }
                this.showNavigation = this.entry.videos.length > 1;
            },
            addVideoBookmark (video) {
                this.$http.post(location.origin + '/videos/' + this.entry.id + '/' + video.id + '/bookmark').then((responce) => {
                    this.entry.videos.forEach((item) => {
                        item.bookmark = (item.id == video.id);
                    });
                    this.$root.$emit('success', 'Закладка на видео добавлена.');
                }, (responce) => {
                    this.$root.$emit('fail', responce);
                });
            }
        },
        created () {
            this.setActiveVideo();
        }
    }
</script>