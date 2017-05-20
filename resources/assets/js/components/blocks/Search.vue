<template>
    <div class="block-search">
        <div class="toggle-search-button tgs-button ripple-effect" @click="showSearchForm">
            <svg class="svg-icon">
                <use xlink:href="#icon-search"></use>
            </svg>
        </div>
        <form class="search-form" @submit.prevent="search" v-show="show" novalidate>
            <fieldset class="field-text">
                <input id="search-input" v-model="searchQuery" type="text" name="query" required>
                <hr>
                <label>Поиск:</label>
            </fieldset>
            <button type="submit" class="ripple-effect">
                <svg class="svg-icon">
                    <use xlink:href="#icon-triangle"></use>
                </svg>
            </button>
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
                this.show = !this.show;
            }
        },
        created () {
            this.searchQuery = this.$route.query.search ? this.$route.query.search : null;
        }
    }
</script>