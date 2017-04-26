<template>
    <div class="popup-container">
        <div class="overlay" v-if="show" @click="togglePopup"></div>
        <div class="popup" v-if="show">
            <span class="close" @click="togglePopup">&times;</span>
            <div>Добавть роль</div>
            <div class="content">
                <form @submit.prevent="create" novalidate>
                    <fieldset class="field-text">
                        <input v-validate="{rules:{required: true}}" v-model="name" type="text" name="name"
                               required>
                        <hr>
                        <label>Название</label>
                    </fieldset>
                    <span class="error" v-show="errors.has('name')">{{ errors.first('name') }}</span>
                    <span class="error" v-if="error">{{ error }}</span>
                    <button class="ripple">Добавить</button>
                </form>
            </div>
        </div>
        <a @click="togglePopup">
            <svg class="svg-icon">
                <use xlink:href="#icon-plus"></use>
            </svg>
            добавть роль
        </a>
    </div>
</template>
<script>
    module.exports = {
        data () {
            return {
                show: false,
                name: null,
                error: null
            }
        },
        props: {
            callback: {
                type: Function,
                required: true
            }
        },
        methods: {
            togglePopup () {
                this.show = !this.show;
                if (!this.show) {
                    this.name = null;
                    this.error = null;
                }
            },
            create () {
                let formData = new FormData();

                formData.append('name', this.name);

                this.$validator.validateAll().then(() => {
                    this.$http.post(location.origin + '/roles/store', formData).then((responce) => {
                        this.callback(responce.data);
                        this.togglePopup();
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