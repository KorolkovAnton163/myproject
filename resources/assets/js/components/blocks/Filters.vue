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
				<option value="" selected>Choose</option>
				<option value="1">Option 1</option>
				<option value="2">Option 2</option>
				<option value="3">Option 3</option>
			</select>
		</div>
		<div class="tags-container" v-show="show" v-bind:class="{ 'open': show }">
			<label class="tag" v-for="tag in fakeTags">
				<input v-on:click="addTag" class="checkbox" type="checkbox" name="tags" :value="tag.id" :checked="tag.checked">{{ tag.name }}
			</label>
		</div>
	</div>
</template>
<script>
	module.exports = {
		data () {
			return {
				fakeTags: [
					{ 'id': 1, 'name': 'Tag text 1' },
					{ 'id': 2, 'name': 'Tag text 2' },
					{ 'id': 3, 'name': 'Tag text 3' },
					{ 'id': 4, 'name': 'Tag text 4' },
					{ 'id': 5, 'name': 'Tag text 5' },
					{ 'id': 6, 'name': 'Tag text 6' },
					{ 'id': 7, 'name': 'Tag text 7' }
				],
				tags: [],
				show: window.innerWidth > 650
			}
		},
		mounted() {
	    	window.addEventListener('resize', () => {
				this.show = window.innerWidth > 650;
	    	});
		},
		methods: {
			addTag (e) {
				let val = e.target.getAttribute('value'),
					query = Object.assign({}, this.$route.query);

				if(e.target.checked) {
					this.tags.push(val);
				} else {
					this.tags.splice(this.tags.indexOf(val), 1);
				}

				if (this.tags.length) {
					query['tags'] = this.tags.join('-tag-');					
				} else {
					delete query['tags'];
				}

				this.$router.push({ name: 'posts', query: query });
				this.$root.$emit('filters', this.tags);
			},
			showTags () {
				if (window.innerWidth < 650) {
					this.show = !this.show;
				}
			},
			fillData () {
				if (typeof this.$route.query.tags !== 'undefined' && this.$route.query.tags) {
					let queryTasg = this.$route.query.tags.split('-tag-');

					this.tags = queryTasg;
					this.fakeTags.forEach((tag) => {
						tag.checked = (queryTasg.indexOf(tag.id.toString()) !== -1);
					});
				}
			}
		},
		created () {
			this.fillData();
		}
	}
</script>