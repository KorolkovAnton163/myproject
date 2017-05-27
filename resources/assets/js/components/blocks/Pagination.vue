<template>
    <ul class="pagination" v-if="params.pages > 1">
        <li>
            <a class="prev" v-if="params.current_page > 1" @click.prevent="showPrevious()">
                <svg class="svg-icon">
                    <use xlink:href="#icon-arrow-left"></use>
                </svg>
            </a>
        </li>
        <li v-for="num in array" :class="{ 'active': num === params.current_page }">
            <a @click.prevent="changePage(num)">{{ num }}</a>
        </li>
        <li>
            <a class="next" v-if="params.current_page < params.pages" @click.prevent="showNext()">
                <svg class="svg-icon">
                    <use xlink:href="#icon-arrow-left"></use>
                </svg>
            </a>
        </li>
    </ul>
</template>
<script>
    module.exports = {
        props: {
            params: {
                type: Object,
                required: true
            },
            callback: {
                type: Function,
                required: true
            }
        },
        computed: {
            array () {
                if (this.params.pages <= 0) return [];

                let from = this.params.current_page - this.config.offset;
                if (from < 1) {
                    from = 1;
                }

                let to = from + (this.config.offset * 2);
                if (to >= this.params.pages) {
                    to = this.params.pages;
                }

                let arr = [];
                while (from <= to) {
                    arr.push(from);
                    from++;
                }

                return arr;
            },
            config () {
                return Object.assign({
                    offset: 3
                }, this.options);
            }
        },
        watch: {
            'params.total' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.calculatePage();
                }
            }
        },
        methods: {
            showPrevious () {
                if (this.params.current_page > 1) {
                    this.$set(this.params, 'current_page', this.params.current_page - 1);
                    this.changePage(this.params.current_page);
                    this.callback();
                    this.scrollTo();
                }
            },
            showNext () {
                if (this.params.current_page < this.params.pages) {
                    this.$set(this.params, 'current_page', this.params.current_page + 1);
                    this.changePage(this.params.current_page);
                    this.callback();
                    this.scrollTo();
                }
            },
            changePage (page) {
                this.$set(this.params, 'current_page', page);

                if (this.params.url_params) {
                    let query = Object.assign({}, this.$route.query);

                    query['page'] = page;
                    this.$router.push({name: this.params.url_params, query: query});
                }
                this.callback();
                this.scrollTo();
            },
            calculatePage () {
                this.$set(this.params, 'pages', Math.ceil(this.params.total / this.params.on_page));
            },
            scrollTo () {
                if (!!this.params.scroll_to) {
                    $('html, body').animate({
                        scrollTop: $(this.params.scroll_to).offset().top - 50
                    }, 1000);
                }
            },
        },
        created () {
            this.callback();
        }
    }
</script>