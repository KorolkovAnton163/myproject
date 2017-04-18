<template>
    <div class="description-container">
        <div class="image-block">
            <img :src="post.image" :alt="post.title">
            <router-link v-if="button" class="read-more ripple" :to="{name:'post', params: {id: post.id}}">
                show
            </router-link>
        </div>
        <div class="additional-block">
            <div class="description-block">
                <p><strong>info1:</strong>&nbsp;info 1</p>
                <p><strong>info2:</strong>&nbsp;info 2</p>
                <p class="tags">
                    <strong>Tags:</strong>&nbsp;
                    <a v-for="tag in post.tags" @click="addTag(tag.id)">{{ tag.name }}</a>
                </p>
                <p><strong>Description:</strong> {{ post.description }}</p>
            </div>
            <div class="action-block">
                <router-link v-if="user && user.canEntryEdit" :to="{name:'entry', params: {id: post.id}}" class="entry-edit">
                    <svg class="svg-icon">
                        <use xlink:href="#icon-edit"></use>
                    </svg>
                    Edit
                </router-link>
                <bookmark :post="post" v-if="user"></bookmark>
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
        computed: {
            user () {
                return this.$store.getters.user
            }
        },
        components: {
            'bookmark': require('../blocks/Bookmark.vue')
        },
        methods: {
            addTag (id) {
                this.$router.push({name: 'posts', query: {tags: id.toString()}});
            }
        }
    }
</script>