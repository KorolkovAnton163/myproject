<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="popup-container">
        <div class="overlay" v-if="show" v-on:click="togglePopup"></div>
        <div class="popup" v-if="show">
            <span class="close" v-on:click="togglePopup">&times;</span>
            <div>Register</div>
            <div class="content">
                <form v-on:submit.prevent="register" novalidate>
                    <fieldset class="field-text">
                        <input v-validate="{rules:{required: true}}" v-model="name" type="text" name="name" required>
                        <hr>
                        <label>Name</label>
                    </fieldset>
                    <span class="error" v-show="errors.has('name')">{{ errors.first('name') }}</span>
                    <fieldset class="field-text">
                        <input v-validate="{rules:{required:true, email:true}}" v-model="email" type="email"
                               name="email" required>
                        <hr>
                        <label>Email</label>
                    </fieldset>
                    <span class="error" v-show="errors.has('email')">{{ errors.first('email') }}</span>
                    <fieldset class="field-text">
                        <input v-validate="{rules:{required:true}}" v-model="password" type="password" name="password"
                               required>
                        <hr>
                        <label>Password</label>
                    </fieldset>
                    <span class="error" v-show="errors.has('password')">{{ errors.first('password') }}</span>
                    <fieldset class="field-text">
                        <input v-model="confirmedPassword" type="password" name="password_confirmation" required>
                        <hr>
                        <label>Confirm password</label>
                    </fieldset>
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
                name: null,
                email: null,
                password: null,
                confirmedPassword: null
            }
        },
        methods: {
            togglePopup () {
                this.show = !this.show;
                if (!this.show) {
                    this.name = null;
                    this.email = null;
                    this.password = null;
                    this.confirmedPassword = null;
                }
            },
            register () {
                let formData = new FormData();

                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('password', this.password);
                formData.append('password_confirmation', this.confirmedPassword);

                this.$validator.validateAll().then(() => {
                    this.$http.post(location.origin + '/register', formData).then((responce) => {
                        this.$store.dispatch('addUser', responce.data);
                        this.togglePopup();
                    }, (responce) => {
                        //TODO show failed message
                    });
                }).catch(() => {

                });
            }
        }
    }
</script>