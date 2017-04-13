<template>
    <div class="description-container">
        <div class="image-block">
            <img src="/images/header.jpg" alt="image">
            <router-link v-if="button" class="read-more ripple" :to="{name:'post', params: {id: post.id}}">show
            </router-link>
        </div>
        <div class="additional-block">
            <div class="description-block">
                <p><strong>info1:</strong> info 1</p>
                <p><strong>info2:</strong> info 2</p>
                <p><strong>info3:</strong> info 3</p>
                <p><strong>Description:</strong> {{ post.description }}</p>
            </div>
            <div class="action-block">
                <bookmark :post="post"></bookmark>
            </div>
        </div>
    </div>
</template>
<script>
    module.exports = {
        props: {
            post: {
                type: Object
            },
            button: {
                type: Boolean,
                default: true
            }
        },
        components: {
            'bookmark': require('../blocks/Bookmark.vue')
        }
    }
</script>