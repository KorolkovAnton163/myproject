<template>
    <div class="block-search">
        <div class="toggle-search-button tgs-button ripple-effect" @click="showSearchForm">
            <svg class="svg-icon">
                <use xlink:href="#icon-search"></use>
            </svg>
        </div>
        <form class="search-form" :class="{ show: show}" @submit.prevent="search" novalidate>
            <fieldset class="field-text">
                <input id="search-input" v-model="searchQuery" type="text" name="query" required>
                <hr>
                <label>Поиск:</label>
            </fieldset>
        </form>
    </div>
</template>
<script>
    module.exports = {
        data () {
            return {
                searchQuery: null,
                show: false
            }
        },
        mounted () {
            window.addEventListener('click', (e) => {
                if (!e.target.matches('.tgs-button, .tgs-button *, .search-form, .search-form *')) {
                    this.show = false;
                }
            });
            this.$root.$on('clearSearch', () => {
                this.searchQuery = null;
            });
        },
        methods: {
            search () {
                let query = this.searchQuery ? {search: this.searchQuery} : null;
                this.$router.push({name: 'posts', query: query});
                this.$root.$emit('search');
            },
            showSearchForm () {
                this.show && this.searchQuery && this.search();
                this.show = !this.show;
            }
        },
        created () {
            this.searchQuery = this.$route.query.search ? this.$route.query.search : null;
        }
    }
</script>