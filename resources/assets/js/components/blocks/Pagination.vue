<template xmlns:v-on="http://www.w3.org/1999/xhtml">
	<ul class="pagination" v-if="params.pages > 1">
		<li>
			<a class="prev" v-if="params.current_page > 1" v-on:click.prevent="showPrevious()">
				<svg class="svg-icon">
            		<use xlink:href="#icon-arrow-left"></use>
      			</svg> 
			</a>
		</li>
		<li v-for="num in array" :class="{ 'active': num === params.current_page }">
			<a v-on:click.prevent="changePage(num)">{{ num }}</a>
		</li>
		<li>
			<a class="next" v-if="params.current_page < params.pages" v-on:click.prevent="showNext()">
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
	            while (from <=to) {
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
	        },
	        '$route.query.page' (newVal, oldVal) {
	        	if (+newVal !== +oldVal) {
	        		if (typeof newVal == 'undefined') {
	            		this.$set(this.params, 'current_page', 1);
	            	}
	                this.callback();
	            }
	        }
	    },
		methods: {
			showPrevious () {
				if (this.params.current_page > 1) {
					this.$set(this.params, 'current_page', this.params.current_page - 1);
					this.changePage(this.params.current_page);
				}
	        },
	        showNext () {
	        	if (this.params.current_page < this.params.pages) {
		        	this.$set(this.params, 'current_page', this.params.current_page + 1);
					this.changePage(this.params.current_page);
	        	}
	        },
	        changePage (page) {
	        	let query = Object.assign({}, this.$route.query);

        		query['page'] = page;

	        	this.$set(this.params, 'current_page', page);
	            this.$router.push({ name: this.params.url_params, query: query });
	        },
	        calculatePage () {
	        	this.$set(this.params, 'pages', this.params.total / this.params.on_page);
	        }
		},
		created () {
          	this.callback();
      	}
	}
</script>