<template>
	<div class="page-container home-page-container">
		<h2>This is Home Page</h2>
		<div>
			<div v-for="field in fields">
				<span>Name:</span>&nbsp;<span>{{ field.name }}</span>
				<a v-on:click="start(field)">start</a>
				<a v-on:click="remove(field)">&times;</a>
				<div class="loading" v-if="field.show">
					<div class="progress" v-bind:style="{ width: '' + field.progress + '%'}"></div>
				</div>
			</div>
			<popup text="Add" :callback="addField"></popup>
		</div>
	</div>
</template>
<script>
	module.exports = {
		data () {
			return {
				fields: []
			}
		},
		methods: {
			start(field) {
				field.show = true;
				field.progress = 1;

				let interval = setInterval(() => {
					if (field.progress == 100) {
						field.show = false;
						field.progress = 0;
						clearInterval(interval);
					} else {
						field.progress++;
					}
				}, 100);
			},
			addField (data) {
				data.show = false;
				data.progress = 0;
				this.fields.push(data);
			},
			remove (field) {
				this.fields.splice(this.fields.indexOf(field), 1);
			}
		},
		components: {
			'popup': require('./bloks/Popup.vue')
		}
	}
</script>