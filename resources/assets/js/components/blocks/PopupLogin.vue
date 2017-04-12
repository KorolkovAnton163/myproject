<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="popup-container">
        <div class="overlay" v-if="show" v-on:click="togglePopup"></div>
        <div class="popup" v-if="show">
            <span class="close" v-on:click="togglePopup">&times;</span>
            <div>Login</div>
            <div class="content">
                <form v-on:submit.prevent="login" novalidate>
                    <fieldset class="field-text">
                        <input v-validate="{ rules:{required: true, email:true}}" v-model="email" type="email"
                               name="email" required>
                        <hr>
                        <label>Email</label>
                    </fieldset>
                    <span class="error" v-show="errors.has('email')">{{ errors.first('email') }}</span>
                    <fieldset class="field-text">
                        <input v-validate="{rules:{required: true}}" v-model="password" type="password" name="password"
                               required>
                        <hr>
                        <label>Password</label>
                    </fieldset>
                    <span class="error" v-show="errors.has('password')">{{ errors.first('password') }}</span>
                    <span class="error" v-if="error">{{ error }}</span>
                    <label class="checkbox-label">
                        <input class="checkbox" type="checkbox" name="remember_token">Remember me
                    </label>
                    <button class="ripple">Login</button>
                </form>
            </div>
        </div>
        <a v-on:click="togglePopup">
            <svg class="svg-icon">
                <use xlink:href="#icon-account"></use>
            </svg>
            login
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
                error: null
            }
        },
        methods: {
            togglePopup () {
                this.show = !this.show;
                if (!this.show) {
                    this.email = null;
                    this.password = null;
                    this.error = null;
                }
            },
            login () {
                let formData = new FormData();

                formData.append('email', this.email);
                formData.append('password', this.password);

                this.$validator.validateAll().then(() => {
                    this.$http.post(location.origin + '/login', formData).then((responce) => {
                        this.$store.dispatch('addUser', responce.data);
                        this.$router.push({name: 'posts'});
                    }, (responce) => {
                        let error = JSON.parse(responce.bodyText);

                        Object.keys(error).forEach((property) => {
                            this.error = error[property];
                        });
                    });
                }).catch(() => {
                    //
                });
            }
        }
    }
</script>