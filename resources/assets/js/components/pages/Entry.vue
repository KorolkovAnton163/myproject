<template>
    <div class="page-container entry-page-container">
        <div class="entry-container" v-if="user && user.canEntryEdit">
            <form @submit.prevent="save" novalidate>
                <div class="tags-container" v-if="tags">
                    <label class="tag" v-for="tag in tags">
                        <input @click="changeTag" class="checkbox" type="checkbox" name="tags"
                               :value="tag.id" :checked="tag.checked">{{ tag.name }}
                    </label>
                </div>
                <fieldset class="field-text">
                    <input v-validate="{ rules: { required: true } }" type="text" name="title" v-model="entry.title"
                           utocomplete="off" required>
                    <hr>
                    <label>Title</label>
                </fieldset>
                <span class="error" v-show="errors.has('title')">{{ errors.first('title') }}</span>
                <fieldset class="textarea">
                    <textarea v-validate="{ rules: { required: true } }" name="description"
                              v-model="entry.description" id="description" required></textarea>
                    <hr>
                    <label>Description</label>
                </fieldset>
                <span class="error" v-show="errors.has('description')">{{ errors.first('description') }}</span>
                <image-uploader :image="entry.image"></image-uploader>
                <button type="submit" class="ripple">Save</button>
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
                tags: {}
            }
        },
        computed: {
            user () {
                return this.$store.getters.user
            }
        },
        mounted () {
            this.$on('imageUpload', (image) => {
                this.entry['image'] = image;
            });
        },
        watch: {
            '$route.params.id' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.getEntry();
                }
            }
        },
        components: {
            'image-uploader': require('../blocks/ImageUpload.vue')
        },
        methods: {
            getEntry () {
                if (this.$route.params.id !== 'undefined' && this.$route.params.id) {
                    this.$http.post(location.origin + '/entry/' + this.$route.params.id).then((responce) => {
                        this.entry = responce.data.entry;
                        this.tags = responce.data.tags;
                        this.fillTags();
                    }, (responce) => {
                        this.user.canEntryEdit = false;
                    });
                } else {
                    this.$http.post(location.origin + '/entry').then((responce) => {
                        this.entry = {};
                        this.tags = responce.data.tags;
                    }, (responce) => {
                        this.user.canEntryEdit = false;
                    });
                }
            },
            save () {
                this.$validator.validateAll().then(() => {
                    this.$http.post(location.origin + (this.entry.id ? '/entry/' + this.entry.id + '/update' : '/entry/store'), this.entry);
                }).catch(() => {
                    //
                });
            },
            fillTags () {
                this.tags.forEach((item) => {
                    item.checked = (this.entry.tags.indexOf(item.id) !== -1);
                });
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

                this.fillTags();
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