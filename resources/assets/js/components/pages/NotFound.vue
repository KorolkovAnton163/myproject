<template>
	<div class="page-not-found">
		<cat></cat>
		<p>404 Page not found :(</p>
	</div>
</template>
<script>
	module.exports = {
		components: {
			cat: require('../blocks/Cat.vue'),
		}
	}
</script>
<style lang="sass">
	.page-not-found
		display: flex;
		align-items: center;
		justify-content: center;
		flex-direction: column;
		background: #161616;
		padding: 20% 0;
		flex: 1 0 auto;
		box-sizing: border-box;
		min-width: 320px;
		p
			color: #fff;
</style>	