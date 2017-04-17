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
                entry: []
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
        methods: {
            getEntry () {
                if (this.$route.params.id !== 'undefined' && this.$route.params.id) {
                    this.$http.post(location.origin + '/entry/' + this.$route.params.id).then((responce) => {
                        this.entry = responce.data;
                    });
                } else {
                    this.entry = [];
                }
            },
            save () {
                this.$validator.validateAll().then(() => {
                    //
                }).catch(() => {
                    //
                });
            }
        },
        created () {
            this.getEntry();
        }
    }
</script>