<template xmlns:v-bind="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="filters">
        <h3>
            Filters
            <div class="menu-button htx ripple-effect" v-on:click="showTags"
                 v-bind:class="{ 'is-active': show }">
                <span>opened</span>
            </div>
        </h3>
        <div class="select-field" v-show="show">
            <select>
                <option value="" selected>Year</option>
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
            </select>
        </div>
        <div class="tags-container" v-if="tags" v-show="show" v-bind:class="{ 'open': show }">
            <label class="tag" v-for="tag in tags">
                <input v-on:click="addTag" class="checkbox" type="checkbox" name="tags" :value="tag.id"
                       :checked="tag.checked">{{ tag.name }}
            </label>
        </div>
    </div>
</template>
<script>
    module.exports = {
        data () {
            return {
                inputTags: [],
                show: window.innerWidth > 650
            }
        },
        props: {
            tags: {
                type: Array
            }
        },
        mounted() {
            window.addEventListener('resize', () => {
                this.show = window.innerWidth > 650;
            });
        },
        watch: {
            'tags' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.fillData();
                }
            }
        },
        methods: {
            addTag (e) {
                let val = e.target.getAttribute('value'),
                    query = Object.assign({}, this.$route.query);

                if (query.page) {
                    delete query.page;
                }

                if (e.target.checked) {
                    this.inputTags.push(val);
                } else {
                    this.inputTags.splice(this.tags.indexOf(val), 1);
                }

                if (this.inputTags.length) {
                    query['tags'] = this.inputTags.join('-tag-');
                } else {
                    delete query['tags'];
                }

                this.$router.push({name: 'posts', query: query});
            },
            showTags () {
                if (window.innerWidth < 650) {
                    this.show = !this.show;
                }
            },
            fillData () {
                if (typeof this.$route.query.tags !== 'undefined' && this.$route.query.tags) {
                    this.inputTags = this.$route.query.tags.split('-tag-');

                    this.tags.forEach((tag) => {
                        tag.checked = (this.inputTags.indexOf(tag.id.toString()) !== -1);
                    });
                }
            }
        }
    }
</script>