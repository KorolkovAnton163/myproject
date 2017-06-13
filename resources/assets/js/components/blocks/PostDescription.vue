<template>
    <div class="description-container">
        <div class="image-block">
            <img :src="entry.image.path" :alt="entry.title">
            <router-link v-if="button" class="read-more ripple" :to="{name:'entry', params: {alias: entry.alias}}">
                Смотреть
            </router-link>
        </div>
        <div class="additional-block">
            <div class="description-block">
                <div class="titles">
                    <p class="additional-title" v-for="title in entry.titles">{{ title.name }}</p>
                </div>
                <p v-if="entry.year"><strong>Год:</strong>&nbsp;{{ entry.year }}</p>
                <p class="episodes" v-if="entry.tags">
                    <strong>Серий:</strong>&nbsp;{{ entry.currentEpisodes }} из {{ entry.episodes }}
                </p>
                <p class="tags" v-if="entry.tags">
                    <strong>Жанры:</strong>&nbsp;
                    <a v-for="tag in entry.tags" @click="search(tag.id)">{{ tag.name }}</a>
                </p>
                <p class="description"><strong>Описание:</strong> {{ entry.description }}</p>
            </div>
            <div class="status" v-if="user">
                <label for="status">Статус:</label>
                <div class="select-field">
                    <select id="status" v-model="currentStatus" @change="changeStatus">
                        <option v-for="(status, index) in entry.statuses" :value="index">{{ status }}</option >
                    </select>
                </div>
            </div>
            <div class="action-block">
                <router-link v-if="user && user.canEntryEdit" :to="{name:'entry-edit', params: {id: entry.id}}" class="entry-edit">
                    <svg class="svg-icon">
                        <use xlink:href="#icon-edit"></use>
                    </svg>
                    редактировать
                </router-link>
                <bookmark :post="entry" v-if="user"></bookmark>
            </div>
        </div>
    </div>
</template>
<script>
    module.exports = {
        data () {
            return {
                currentStatus: null,
            }
        },
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
                this.$root.$emit('changeTags');
            },
            changeStatus () {
                let formData = new FormData();

                formData.append('status', this.currentStatus);

                this.$http.post(location.origin + '/entry-statuses/' + this.entry.id + (this.entry.currentStatus ? '/update' : '/store'), formData).then((responce) => {
                    this.$root.$emit('success', 'Статус обновлен.');
                }, (responce) => {
                    this.$root.$emit('fail', responce);
                });
            }
        },
        created () {
            this.currentStatus = !!this.entry.currentStatus ? this.entry.currentStatus.status : null;
        }
    }
</script>