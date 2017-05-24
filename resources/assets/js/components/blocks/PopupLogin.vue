<template>
    <div class="popup-container">
        <div class="overlay" v-if="show" @click="togglePopup"></div>
        <div class="popup" v-if="show">
            <span class="close" @click="togglePopup">&times;</span>
            <div>Вход</div>
            <div class="content">
                <form @submit.prevent="login" novalidate>
                    <fieldset class="field-text">
                        <input v-model="email" type="email" name="email" required>
                        <hr>
                        <label>Почта</label>
                    </fieldset>
                    <span class="error" v-if="error.email">{{ error.email }}</span>
                    <fieldset class="field-text">
                        <input v-model="password" type="password" name="password" required>
                        <hr>
                        <label>Пароль</label>
                    </fieldset>
                    <span class="error" v-if="error.password">{{ error.password }}</span>
                    <div class="checkbox-label">
                        <input class="checkbox" type="checkbox" id="remember" name="remember_token">
                        <label for="remember">Запомнить</label>
                    </div>
                    <button class="ripple">Войти</button>
                </form>
            </div>
        </div>
        <a @click="togglePopup">
            <svg class="svg-icon">
                <use xlink:href="#icon-account"></use>
            </svg>
            вход
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
                error: {
                    email: null,
                    password: null
                }
            }
        },
        watch: {
            'email' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.error.email = null;
                }
            },
            'password' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.error.password = null;
                }
            },
        },
        methods: {
            togglePopup () {
                this.show = !this.show;
                if (!this.show) {
                    this.email = null;
                    this.password = null;
                    this.error.email = null;
                    this.error.password = null;
                }
            },
            login () {
                let formData = new FormData();

                formData.append('email', this.email);
                formData.append('password', this.password);

                this.error.email = null;
                this.error.password = null;

                this.$http.post(location.origin + '/login', formData).then((responce) => {
                    this.$store.dispatch('addUser', responce.data);
                    this.$router.push({name: 'posts'});
                }, (responce) => {
                    let error = JSON.parse(responce.bodyText);

                    Object.keys(error).forEach((property) => {
                        this.error[property] = error[property][0];
                    });
                });
            }
        }
    }
</script>