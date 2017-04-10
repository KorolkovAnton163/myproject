<template xmlns:v-on="http://www.w3.org/1999/xhtml">
	<div class="popup-container">
		<div class="overlay" v-if="show" v-on:click="togglePopup"></div>
		<div class="popup" v-if="show">
			<span class="close" v-on:click="togglePopup">&times;</span>
			<div>Register</div>
			<div class="content">
				<form v-on:submit.prevent="register" novalidate>
					<fieldset class="field-text">
				        <input v-validate="{ rules: { required: true, email: true } }" v-model="email" type="text" name="email" required>
				        <hr>
				        <label>Email</label>
				    </fieldset>
				    <span class="error" v-show="errors.has('email')">{{ errors.first('email') }}</span>
				    <fieldset class="field-text">
				        <input v-validate="{ rules: { required: true } }" v-model="password" type="password" name="password" required>
				        <hr>
				        <label>Password</label>
				    </fieldset>
				    <span class="error" v-show="errors.has('password')">{{ errors.first('password') }}</span>
				    <fieldset class="field-text">
				        <input v-validate="{ rules: { required: true, confirmed: { password } } }" v-model="comfirnPassword" type="password" name="comfirn_password" required>
				        <hr>
				        <label>Confirm password</label>
				    </fieldset>
				    <span class="error" v-show="errors.has('comfirn_password')">{{ errors.first('comfirn_password') }}</span>
				    <button class="ripple">Register</button>
				</form>
			</div>
		</div>
		<a v-on:click="togglePopup">
			<svg class="svg-icon">
                <use xlink:href="#icon-account-plus"></use>
          	</svg> 
			register
		</a>
	</div>
</template>
<script>
	module.exports = {
		data () {
			return {
				show: false,
				email: null,
				password: null,
				comfirnPassword: null
			}
		},
		methods: {
			togglePopup () {
				this.show = !this.show;
				if(!this.show) {
					this.email = null;
					this.password = null;
					this.comfirnPassword = null;
				}
			},
			register () {
				this.$validator.validateAll().then(() => {
					let params = { email: this.email, password: this.password },
						options = { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } };

              		this.$http.post('http://localhost:8000/users/', params, options).then((responce) => {
      					this.$store.dispatch('addUser', responce.data);
      					this.togglePopup();
          			});
				}).catch(() => {

				});
			}
		}
	}
</script>