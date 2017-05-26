<template>
    <div class="popup-container">
        <div class="overlay" v-if="show" @click="togglePopup"></div>
        <div class="popup" v-if="show">
            <span class="close" @click="togglePopup">&times;</span>
            <div>Регистрация</div>
            <div class="content">
                <form @submit.prevent="register" novalidate>
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
            </div>
        </div>
        <a @click="togglePopup">
            <svg class="svg-icon">
                <use xlink:href="#icon-account-plus"></use>
            </svg>
            регистрация
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
                confirmedPassword: null,
                error: {
                    name: null,
                    email: null,
                    password: null
                }
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
            togglePopup () {
                this.show = !this.show;
                if (!this.show) {
                    this.name = null;
                    this.email = null;
                    this.password = null;
                    this.confirmedPassword = null;
                    this.error.name = null;
                    this.error.email = null;
                    this.error.password = null;
                }
            },
            register () {
                let formData = new FormData();

                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('password', this.password);
                formData.append('password_confirmation', this.confirmedPassword);

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