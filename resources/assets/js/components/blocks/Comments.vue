<template>
    <div class="comments-container">
        <h3>Комментарии</h3>
        <div class="comments-wrapper">
            <div class="comment" v-for="comment in entry.comments">
                <div class="comment-header">{{ comment.user }} <span>#{{ comment.date }}</span></div>
                <div class="comment-text">{{ comment.text }}</div>
            </div>
        </div>
        <form v-if="user" @submit.prevent="save">
            <fieldset class="textarea">
                <textarea v-validate="{ rules: { required: true } }" v-model="comment"
                          name="text" id="text" required></textarea>
                <hr>
                <label>Комментарий</label>
            </fieldset>
            <span class="error" v-show="errors.has('text')">{{ errors.first('text') }}</span>
            <button type="submit" class="ripple">Отправить</button>
        </form>
        <h3 v-else>Только зарегистрированные пользователи могут оставлять комментарии.</h3>
    </div>
</template>
<script>
    module.exports = {
        data () {
            return {
                comment: null,
            }
        },
        props: {
            entry: {
                type: Object
            }
        },
        computed: {
            user () {
                return this.$store.getters.user
            }
        },
        methods: {
            save () {
                this.$validator.validateAll().then(() => {
                    let formData = new FormData();
                    formData.append('text', this.comment);

                    this.$http.post(location.origin + '/comments/' + this.entry.id + '/' + user.id + '/store', formData).then((responce) => {
                        this.comment = null;
                        this.entry.comments.unshift(responce.data);
                        this.$root.$emit('success', 'Комментарий добавлен.');
                    }, (responce) => {
                        this.$root.$emit('fail', responce);
                    });
                }).catch(() => {
                    //
                });
            }
        }
    }
</script>