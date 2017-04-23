<template>
    <a class="bookmark" @click.prevent="addBookmark" v-if="!post.bookmark">
        <svg class="svg-icon">
            <use xlink:href="#icon-bookmark-plus"></use>
        </svg>
        add to bookmarks
    </a>
    <a class="bookmark remove" @click.prevent="removeBookmark" v-else>
        <svg class="svg-icon">
            <use xlink:href="#icon-bookmark-remove"></use>
        </svg>
        remove bookmark
    </a>
</template>
<script>
    module.exports = {
        props: {
            post: {
                type: Object
            }
        },
        methods: {
            addBookmark () {
                this.$http.post(location.origin + '/bookmarks/' + this.post.id + '/store').then((responce) => {
                    this.post.bookmark = true;
                });
            },
            removeBookmark () {
                this.$http.post(location.origin + '/bookmarks/' + this.post.id + '/destroy').then((responce) => {
                    this.post.bookmark = false;
                    this.$root.$emit('removeBookmark');
                });
            }
        }
    }
</script>