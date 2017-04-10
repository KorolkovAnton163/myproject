<template>
	<nav class="nav-menu">
		<div class="menu-button htx ripple-effect" v-bind:class="{ 'is-active': show }" v-on:click="toggleMenu">
			<span>opened</span>
		</div>	
		<div class="nav-wrapper" v-bind:class="{ open: show }">
			<div class="site-name"><router-link :to="{ name:'posts' }">Site Name</router-link></div>
			<nav-menu></nav-menu>
			<search></search>
			<user></user>
		</div>
		<v-touch tag="div" class="menu-overlay" v-bind:class="{ open: show }" v-on:swiperight="openMenu" v-on:swipeleft="hideMenu"></v-touch>
	</nav>
</template>
<script>
	module.exports = {
		data () {
			return {
				show: false
			}
		},
		mounted() {
			let $menu = document.querySelector('.nav-menu'),
				$menuButton = document.querySelector('.menu-button'),
				$menuWrapper = document.querySelector('.nav-wrapper');

	    	window.addEventListener('resize', () => {
    			if (window.innerWidth > 440) {
					$menuWrapper.removeAttribute("style");
					$menuButton.classList.remove('is-active');
					this.show = false;
    			}
	    	});

	    	window.addEventListener('scroll', () => {
	    		if (window.pageYOffset) {
	    			$menu.classList.add('shadow');
	    		} else {
	    			$menu.classList.remove('shadow');
	    		}
	    	});
		},
		watch: {
	        '$route' (newVal, oldVal) {
	        	if (+newVal !== +oldVal) {
	        		this.show = false;
	            }
	        }
	    },
		components: {
			'nav-menu': require('./NavMenu.vue'),
			'search': require('./Search.vue'),
			'user': require('./User.vue')
		},
		methods: {
			toggleMenu () {
				this.show = !this.show;
			},
			openMenu () {
				this.show = true;
			},
			hideMenu () {
				this.show = false;
			}
		}
	}
</script>