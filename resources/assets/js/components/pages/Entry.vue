<template>
    <div class="page-container entry-page-container">
        <div class="entry-container" v-if="user && user.canEntryEdit">
            <form @submit.prevent="save" novalidate>
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
                entry: {}
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
                        this.entry = responce.data;
                    });
                } else {
                    this.entry = {};
                }
            },
            save () {
                this.$validator.validateAll().then(() => {
                    if (this.entry.id) {
                        this.$http.post(location.origin + '/entry/' + this.entry.id + '/update', this.entry).then((responce) => {

                        });
                    } else {

                    }
                }).catch(() => {
                    //
                });
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