<template xmlns:v-on="http://www.w3.org/1999/xhtml">
	<div class="popup-container">
		<div class="overlay" v-if="show" v-on:click="togglePopup"></div>
		<div class="popup" v-if="show">
			<span class="close" v-on:click="togglePopup">&times;</span>
			<div class="content">
				<fieldset class="field-text">
			        <input v-model="name" type="text" name="name" required>
			        <hr>
			        <label>name</label>
			    </fieldset>
			    <button class="ripple" v-on:click="add">Add</button>
			</div>
		</div>
		<a v-on:click="togglePopup">{{ text }}</a>
	</div>
</template>
<script>
	module.exports = {
		data () {
			return {
				show: false,
				name: null
			}
		},
		props: {
			text: String,
			callback: {
				type: Function,
				required: true
			}
		},
		methods: {
			togglePopup () {
				this.show = !this.show;
				if(!this.show) {
					this.name = null;
				}
			},
			add () {
				this.callback({
					name: this.name
				});
				this.togglePopup();
			}
		}
	}
</script>