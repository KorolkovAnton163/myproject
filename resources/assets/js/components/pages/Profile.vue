<template>
    <div class="page-container user-page-container">
        <form @submit.prevent="update" v-if="user" novalidate>
            <fieldset class="field-text">
                <input v-validate="{ rules: { required: true } }" type="text" name="name" v-model="user.name"
                       autocomplete="off" required>
                <hr>
                <label>Имя</label>
            </fieldset>
            <span class="error" v-show="errors.has('name')">{{ errors.first('name') }}</span>
            <fieldset class="field-text">
                <input v-validate="{ rules: { required: true, email: true } }" type="email" name="email"
                       v-model="user.email" autocomplete="off" required>
                <hr>
                <label>Почта</label>
            </fieldset>
            <span class="error" v-show="errors.has('email')">{{ errors.first('email') }}</span>
            <fieldset class="field-text">
                <input type="password" name="password" v-model="user.password" autocomplete="off"
                       required>
                <hr>
                <label>Пароль</label>
            </fieldset>
            <button class="ripple" type="submit">Сохранить</button>
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
                    this.$http.post(location.origin + '/users/' + this.user.id + '/update', this.user).then((responce) => {
                        this.user = responce.data;
                    });
                }).catch(() => {
                    //
                });
            }
        }
    }
</script>