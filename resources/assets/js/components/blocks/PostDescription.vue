<template>
    <div class="description-container">
        <div class="image-block">
            <img :src="entry.image.path" :alt="entry.title">
            <router-link v-if="button" class="read-more ripple" :to="{name:'entry', params: {alias: entry.alias}}">
                show
            </router-link>
        </div>
        <div class="additional-block">
            <div class="description-block">
                <div class="titles">
                    <p class="additional-title" v-for="title in entry.titles">{{ title.name }}</p>
                </div>
                <p v-if="entry.year"><strong>Год:</strong>&nbsp;{{ entry.year }}</p>
                <p class="tags" v-if="entry.tags">
                    <strong>Жанры:</strong>&nbsp;
                    <a v-for="tag in entry.tags" @click="search(tag.id)">{{ tag.name }}</a>
                </p>
                <p class="description"><strong>Описание:</strong> {{ entry.description }}</p>
            </div>
            <div class="action-block">
                <router-link v-if="user && user.canEntryEdit" :to="{name:'entry-edit', params: {id: entry.id}}" class="entry-edit">
                    <svg class="svg-icon">
                        <use xlink:href="#icon-edit"></use>
                    </svg>
                    Edit
                </router-link>
                <bookmark :post="entry" v-if="user"></bookmark>
            </div>
        </div>
    </div>
</template>
<script>
    module.exports = {
        props: {
            entry: {
                type: Object,
                default: null
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
            search (id) {
                this.$router.push({name: 'posts', query: {tags: id.toString()}});
            }
        }
    }
</script>