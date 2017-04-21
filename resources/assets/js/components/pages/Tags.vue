<template>
    <div class="page-container tags-page-container">
        <div class="tags-container" v-if="user && user.canTagsEdit">
            <form novalidate>
                <div class="tag" v-for="tag in tags">
                    <span>{{ tag.name }}</span><span>delete</span>
                </div>
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
                tags: []
            }
        },
        computed: {
            user () {
                return this.$store.getters.user
            }
        },
        methods: {
            getTags () {
                this.$http.post(location.origin + '/tags').then((responce) => {
                    this.tags = responce.data;
                });
            }
        },
        created () {
            this.getTags()
        }
    }
</script>