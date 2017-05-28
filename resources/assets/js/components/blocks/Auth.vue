<template>
    <div class="auth-block-container">
        <div class="login-container" :class="{ hide: !show  }" v-if="!user">
            <h3>Вход</h3>
            <form @submit.prevent="login" novalidate>
                <fieldset class="field-text" :class="{ error: error.email }">
                    <input v-model="email" type="email" name="email" required>
                    <hr>
                    <label>Почта</label>
                </fieldset>
                <span class="error-message" v-if="error.email">{{ error.email }}</span>
                <fieldset class="field-text" :class="{ error: error.password }">
                    <input v-model="password" type="password" name="password" required>
                    <hr>
                    <label>Пароль</label>
                </fieldset>
                <span class="error-message" v-if="error.password">{{ error.password }}</span>
                <div class="checkbox-label">
                    <input class="checkbox" type="checkbox" id="remember" name="remember_token">
                    <label for="remember">Запомнить</label>
                </div>
                <button type="submit" class="ripple">Войти</button>
            </form>
            <a @click="toggleForm">Регистрация ></a>
        </div>
        <div class="registered-container" :class="{ hide: show }" v-if="!user">
            <h3>Регистрация</h3>
            <form @submit.prevent="registered" novalidate>
                <fieldset class="field-text" :class="{ error: error.name }">
                    <input v-model="name" type="text" name="name" required>
                    <hr>
                    <label>Имя</label>
                </fieldset>
                <span class="error-message" v-if="error.name">{{ error.name }}</span>
                <fieldset class="field-text" :class="{ error: error.email }">
                    <input v-model="email" type="email" name="email" required>
                    <hr>
                    <label>Почта</label>
                </fieldset>
                <span class="error-message" v-if="error.email">{{ error.email }}</span>
                <fieldset class="field-text" :class="{ error: error.password }">
                    <input v-model="password" type="password" name="password" required>
                    <hr>
                    <label>Пароль</label>
                </fieldset>
                <span class="error-message" v-if="error.password">{{ error.password }}</span>
                <fieldset class="field-text">
                    <input v-model="confirmedPassword" type="password" name="password_confirmation" required>
                    <hr>
                    <label>Подтвердите пароль</label>
                </fieldset>
                <button type="submit" class="ripple">Зарегистрироваться</button>
            </form>
            <a @click="toggleForm">< Вход</a>
        </div>
    </div>
</template>
<script>
    module.exports = {
        data () {
            return {
                show: true,
                name: null,
                email: null,
                password: null,
                confirmedPassword: null,
                error: {
                    name: null,
                    email: null,
                    password: null
                }
            }
        },
        computed: {
            user () {
                return this.$store.getters.user
            }
        },
        watch: {
            'name' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.error.name = null;
                }
            },
            'email' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.error.email = null;
                }
            },
            'password' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.error.password = null;
                }
            }
        },
        methods: {
            toggleForm () {
                this.error.name = null;
                this.error.email = null;
                this.error.password = null;
                this.name = null;
                this.email = null;
                this.password = null;
                this.confirmedPassword = null;
                this.show = !this.show;
            },
            login () {
                let formData = new FormData();

                this.email && formData.append('email', this.email);
                this.password && formData.append('password', this.password);

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
            },
            registered () {
                let formData = new FormData();

                this.name && formData.append('name', this.name);
                this.email && formData.append('email', this.email);
                this.password && formData.append('password', this.password);
                this.confirmedPassword && formData.append('password_confirmation', this.confirmedPassword);

                this.error.name = null;
                this.error.email = null;
                this.error.password = null;

                this.$http.post(location.origin + '/register', formData).then((responce) => {
                    this.$store.dispatch('addUser', responce.data);
                    this.togglePopup();
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