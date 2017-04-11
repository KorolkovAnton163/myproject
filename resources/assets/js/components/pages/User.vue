<template xmlns:v-on="http://www.w3.org/1999/xhtml">
	<div class="page-container user-page-container">
		<form v-on:submit.prevent="update" v-if="user" novalidate>
		    <fieldset class="field-text">
		        <input v-validate="{ rules: { required: true } }" type="text" name="name" v-model="user.name" utocomplete="off" required>
		        <hr>
		        <label>Name</label>
		    </fieldset>
		    <span class="error" v-show="errors.has('name')">{{ errors.first('name') }}</span>
		    <fieldset class="field-text">
		        <input v-validate="{ rules: { required: true, email: true } }" type="email" name="email" v-model="user.email" utocomplete="off" required>
		        <hr>
		        <label>Email</label>
		    </fieldset>
		    <span class="error" v-show="errors.has('email')">{{ errors.first('email') }}</span>
		    <fieldset class="field-text">
		        <input v-validate="{ rules: { required: true } }" type="password" name="password" autocomplete="off" required>
		        <hr>
		        <label>Password</label>
		    </fieldset>
		    <span class="error" v-show="errors.has('password')">{{ errors.first('password') }}</span>
			<button class="ripple" type="submit">Save</button>
		</form>
		<access-denied v-else></access-denied>
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
			update () {
				this.$validator.validateAll().then(() => {

				}).catch(() => {

				});
			}
		}
	}
</script>