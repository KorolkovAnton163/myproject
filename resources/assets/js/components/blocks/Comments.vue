<template>
	<div class="comments">
		
	</div>
</template>
<script>
	module.exports = {
		data () {
			return {
				comments: {}
			}
		},
		props: {
			id: {
				type: Number
			}
		},
		computed: {
		    resource () {
		      return this.$resource('https://jsonplaceholder.typicode.com/comments{/id}');
		    }
	  	}
	}
</script>