<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="popup-container">
        <div class="overlay" v-if="show" v-on:click="togglePopup"></div>
        <div class="popup" v-if="show">
            <span class="close" v-on:click="togglePopup">&times;</span>
            <div>Create Role</div>
            <div class="content">
                <form v-on:submit.prevent="create" novalidate>
                    <fieldset class="field-text">
                        <input v-validate="{rules:{required: true}}" v-model="name" type="text" name="name"
                               required>
                        <hr>
                        <label>Name</label>
                    </fieldset>
                    <span class="error" v-show="errors.has('name')">{{ errors.first('name') }}</span>
                    <span class="error" v-if="error">{{ error }}</span>
                    <button class="ripple">Add</button>
                </form>
            </div>
        </div>
        <a v-on:click="togglePopup">
            add role
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