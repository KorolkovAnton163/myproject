<template>
    <div class="filters">
        <h3>
            <div class="menu-button htx ripple-effect" @click="showTags"
                 :class="{'is-active': show}">
                <span>opened</span>
            </div>
        </h3>
        <div v-show="show">
            <label for="years" >Year</label>
            <div class="select-field" v-if="years">
                <select id="years" v-model="currentYear" @change="addYear">
                    <option value="">no choosen</option>
                    <option v-for="year in years" :value="year">{{ year }}</option >
                </select>
            </div>
            <div class="tags-container" v-if="tags" :class="{'open': show}">
                <label class="tag" v-for="tag in tags">
                    <input @click="addTag" class="checkbox" type="checkbox" name="tags"
                           :id="tag.id" :value="tag.id" :checked="tag.checked">{{ tag.name }}
                </label>
            </div>
        </div>
    </div>
</template>
<script>
    module.exports = {
        data () {
            return {
                inputTags: [],
                show: window.innerWidth > 650,
                currentYear: ''
            }
        },
        props: {
            tags: {
                type: Array
            },
            years: {
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
            },
            '$route.query.tags' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.fillData();
                }
            }
        },
        methods: {
            addTag (e) {
                let val = e.target.getAttribute('value'),
                    query = Object.assign({}, this.$route.query);

                query.page = 1;

                if (e.target.checked) {
                    this.inputTags.push(val);
                } else {
                    this.inputTags.splice(this.inputTags.indexOf(val), 1);
                }

                if (this.inputTags.length) {
                    query['tags'] = this.inputTags.join('-tag-');
                } else {
                    delete query['tags'];
                }

                this.$router.push({name: 'posts', query: query});
                this.$root.$emit('changeTags');
            },
            addYear () {
                let query = Object.assign({}, this.$route.query);

                query.page = 1;

                if (this.currentYear) {
                    query['year'] = this.currentYear;
                } else {
                    delete query['year'];
                }

                this.$router.push({name: 'posts', query: query});
                this.$root.$emit('changeYear');
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
                        $('.tags-container').find('input[value="' + tag.id + '"]')
                            .prop('checked', this.inputTags.indexOf(tag.id.toString()) !== -1);
                    });
                } else {
                    this.inputTags = [];
                }
                if (typeof this.$route.query.year !== 'undefined' && this.$route.query.year) {
                    this.currentYear = parseInt(this.$route.query.year);
                } else {
                    this.currentYear = '';
                }
            }
        }
    }
</script>