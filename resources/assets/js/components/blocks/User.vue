<template xmlns:v-on="http://www.w3.org/1999/xhtml">
	<div class="user-container">
		<div class="user-section" v-if="user">
			<router-link :to="{name:'account'}">{{ user.name }}</router-link>
			<a>
				<svg class="svg-icon">
        			<use xlink:href="#icon-heart"></use>
      			</svg> 
				favorites
			</a>
			<a class="logout" v-on:click.prevent="logout">Logout</a>
		</div>
		<div class="login-section" v-else>
			<login-popup></login-popup>
			<register-popup></register-popup>
		</div>
	</div>
</template>
<script>
	module.exports = {
	  	computed: {
          	user () {
				return this.$store.getters.user
          	}
      	},
		methods: {
			logout () {
				this.$store.dispatch('removeUser');
				this.$router.push({ name: 'posts' });
			}
		},
		components: {
			'login-popup': require('./LoginPopup.vue'),
			'register-popup': require('./RegisterPopup.vue')
		}
	}
</script>