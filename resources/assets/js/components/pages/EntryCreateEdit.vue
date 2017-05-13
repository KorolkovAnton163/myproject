<template>
    <div class="page-container entry-page-container">
        <div class="entry-container" v-if="user && user.canEntryEdit">
            <form @submit.prevent="save" novalidate>
                <div class="tags-container" v-if="tags">
                    <label class="tag" v-for="tag in tags">
                        <input v-validate="{ rules: { required: true } }" @click="changeTag" class="checkbox"
                               type="checkbox" name="tags" :value="tag.id" :checked="tag.checked">{{ tag.name }}
                    </label>
                </div>
                <span class="error" v-show="errors.has('tags')">{{ errors.first('tags') }}</span>
                <label for="year">Год</label>
                <fieldset class="select-field">
                    <select id="year" v-validate="{ rules: { required: true } }" name="year" v-model="entry.year">
                        <option v-for="year in years" :value="year">{{ year }}</option>
                    </select>
                </fieldset>
                <span class="error" v-show="errors.has('year')">{{ errors.first('year') }}</span>
                <fieldset class="field-text">
                    <input v-validate="{ rules: { required: true } }" type="text" name="title" v-model="entry.title"
                           autocomplete="off" required>
                    <hr>
                    <label>Заголовок</label>
                </fieldset>
                <span class="error" v-show="errors.has('title')">{{ errors.first('title') }}</span>
                <div class="titles">
                    <span>Дополнительные заголовки</span>
                    <a class="button-add" @click.prevent="addTitle">
                        <svg class="svg-icon">
                            <use xlink:href="#icon-plus"></use>
                        </svg>
                        добавить
                    </a>
                    <div class="title-container" v-for="title in titles">
                        <fieldset class="field-text">
                            <input type="text" name="title" v-model="title.name" autocomplete="off" required>
                            <hr>
                            <label>Название</label>
                        </fieldset>
                        <a class="delete" @click.prevent="removeTitle(title)">
                             <svg class="svg-icon">
                                <use xlink:href="#icon-delete"></use>
                            </svg>
                        </a>
                    </div>
                </div>
                <fieldset class="textarea">
                    <textarea v-validate="{ rules: { required: true } }" name="description"
                              v-model="entry.description" id="description" required></textarea>
                    <hr>
                    <label>Краткое описание</label>
                </fieldset>
                <span class="error" v-show="errors.has('description')">{{ errors.first('description') }}</span>
                <image-uploader :image="image"></image-uploader>
                <input v-validate="{ rules: { required: true } }" type="hidden" name="image" v-model="image.id">
                <span class="error" v-show="errors.has('image')">{{ errors.first('image') }}</span>
                <div class="videos">
                    <span>Видео</span>
                    <a class="button-add" @click.prevent="addVideo">
                        <svg class="svg-icon">
                            <use xlink:href="#icon-plus"></use>
                        </svg>
                        добавить
                    </a>
                    <div class="video-container" v-for="video in videos">
                        <fieldset class="field-text">
                            <input type="text" name="title" v-model="video.url" autocomplete="off" required>
                            <hr>
                            <label>Ссылка на видео</label>
                        </fieldset>
                        <a class="delete" @click.prevent="removeVideo(video)">
                            <svg class="svg-icon">
                                <use xlink:href="#icon-delete"></use>
                            </svg>
                        </a>
                    </div>
                </div>
                <button type="submit" class="ripple">Сохранить</button>
            </form>
        </div>
        <access-denied v-else></access-denied>
    </div>
</template>
<script>
    module.exports = {
        data () {
            return {
                entry: {},
                tags: {},
                image: {},
                titles: [],
                years: [],
                videos: [],
                removedVideos: []
            }
        },
        computed: {
            user () {
                return this.$store.getters.user
            }
        },
        watch: {
            '$route.params.id' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.getEntry();
                }
            }
        },
        mounted () {
            this.$on('imageUpload', (image) => {
                this.image = image;
                this.entry['image'] = image;
            });
        },
        components: {
            'image-uploader': require('../blocks/ImageUpload.vue')
        },
        methods: {
            getEntry () {
                if (this.$route.params.id !== 'undefined' && this.$route.params.id) {
                    this.$http.post(location.origin + '/entry/' + this.$route.params.id).then((responce) => {
                        this.fillData(responce.data);
                    }, (responce) => {
                        this.user.canEntryEdit = false;
                    });
                } else {
                    this.$http.post(location.origin + '/entry').then((responce) => {
                        this.clearData();
                        this.tags = responce.data.tags;
                        this.years = responce.data.years;
                    }, (responce) => {
                        this.user.canEntryEdit = false;
                    });
                }
            },
            save () {
                // TODO Send Form Data
                this.$validator.validateAll().then(() => {
                    this.entry['titles'] = this.titles;
                    this.entry['videos'] = this.videos;
                    this.entry['removedVideos'] = this.removedVideos;
                    this.$http.post(location.origin + (this.entry.id ? '/entry/' + this.entry.id + '/update' : '/entry/store'), this.entry).then((responce) => {
                        if (typeof this.entry.id == 'undefined') {
                            this.clearData();
                            this.clearTags();
                        }
                        this.$root.$emit('success', 'Запись сохранена.');
                    }, (responce) => {
                        this.$root.$emit('fail', responce);
                    });
                }).catch(() => {
                    //
                });
            },
            fillData (data) {
                this.entry = data.entry;
                this.tags = data.tags;
                this.years = data.years;
                this.titles = data.entry.titles;
                this.videos = data.entry.videos;
                this.image = !_.isEmpty(data.entry.image) ? data.entry.image : {};

                this.tags.forEach((item) => {
                    item.checked = (this.entry.tags.indexOf(item.id) !== -1);
                });
            },
            clearData () {
                this.entry = {};
                this.image = {};
                this.titles = [];
                this.videos = [];
            },
            changeTag (e) {
                let val = parseInt(e.target.getAttribute('value'));

                if (_.isEmpty(this.entry.tags)) {
                    this.entry['tags'] = [];
                }

                if (e.target.checked) {
                    this.entry.tags.push(val);
                } else {
                    this.entry.tags.splice(this.entry.tags.indexOf(val), 1);
                }

                this.fillData();
            },
            clearTags () {
                this.tags.forEach((item) => {
                    item.checked = false;
                });
            },
            removeTitle (title) {
                this.titles.splice(this.titles.indexOf(title), 1);
            },
            addTitle () {
                this.titles.push({name: ''});
            },
            addVideo () {
                this.videos.push({url: ''})
            },
            removeVideo (video) {
                this.removedVideos.push(video);
                this.videos.splice(this.videos.indexOf(video), 1);
            }
        },
        created () {
            this.getEntry();
        },
        destroyed () {
            this.$off('imageUpload');
        }
    }
</script>