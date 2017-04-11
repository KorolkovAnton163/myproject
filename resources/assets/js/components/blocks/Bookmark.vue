<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <a class="bookmark" v-on:click.prevent="addBookmark">
        <svg class="svg-icon">
            <use xlink:href="#icon-bookmark-plus"></use>
        </svg>
        add to bookmarks
    </a>
</template>
<script>
    module.exports = {
        props: {
            id: {
                type: Number
            }
        },
        methods: {
            addBookmark () {
                console.log(this.id);
            }
        }
    }
</script>