<template>
    <div class="page-container tags-page-container">
        <div class="tags-container" v-if="user && user.canTagsEdit">
            <form @submit.prevent="create" class="new-tag" novalidate>
                <fieldset class="field-text">
                    <input v-validate="{ rules: { required: true } }" type="text" name="name" v-model="newTag.name"
                           autocomplete="off" required>
                    <hr>
                    <label>Название</label>
                </fieldset>
                <span class="error" v-show="errors.has('name')">{{ errors.first('name') }}</span>
                <button type="submit" class="ripple">добавить тег</button>
            </form>
            <form @submit.prevent="update" novalidate v-if="tags">
                <div class="tag" v-for="tag in tags">
                    <fieldset class="field-text">
                        <input v-validate="{ rules: { required: true } }" type="text" name="name" v-model="tag.name"
                               autocomplete="off" required>
                        <hr>
                        <label>Название</label>
                    </fieldset>
                    <span class="delete" @click="destroy(tag.id)">
                        <svg class="svg-icon">
                            <use xlink:href="#icon-delete"></use>
                        </svg>
                    </span>
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
                newTag: {},
                tags: []
            }
        },
        computed: {
            user () {
                return this.$store.getters.user
            }
        },
        methods: {
            index () {
                this.$http.post(location.origin + '/tags').then((responce) => {
                    this.tags = responce.data;
                });
            },
            create () {
                let formData = new FormData();

                this.$validator.validateAll().then(() => {
                    formData.append('name', this.newTag.name);

                    this.$http.post(location.origin + '/tags/store', formData).then((responce) => {
                        this.tags.push(responce.data);
                        this.newTag = {};
                    });
                }).catch(() => {
                    //
                });
            },
            destroy (id) {
                this.$http.delete(location.origin + '/tags/' + id + '/destroy').then((responce) => {
                    this.tags = responce.data;
                });
            },
            update () {
                this.$http.put(location.origin + '/tags/update', this.tags);
            }
        },
        created () {
            this.index()
        }
    }
</script>