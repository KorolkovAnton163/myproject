<template>
    <div class="comments-container">
        <h3>Комментарии</h3>
        <form v-if="user" @submit.prevent="save">
            <fieldset class="textarea">
                <textarea v-validate="{ rules: { required: true } }" v-model="comment"
                          name="text" id="text" required></textarea>
                <hr>
                <label>Ваш комментарий</label>
            </fieldset>
            <span class="error" v-show="errors.has('text')">{{ errors.first('text') }}</span>
            <button type="submit" class="ripple">Отправить</button>
        </form>
        <h3 v-else>Только зарегистрированные пользователи могут оставлять комментарии.</h3>
        <div class="comments-wrapper">
            <div class="comment" v-for="comment in comments">
                <div class="comment-header">{{ comment.user }} <span>#{{ comment.date }}</span></div>
                <div class="comment-text">{{ comment.text }}</div>
            </div>
        </div>
        <pagination :params="params" :callback="getComments"></pagination>
    </div>
</template>
<script>
    module.exports = {
        data () {
            return {
                comment: null,
                comments: [],
                params: {
                    total: 0,
                    on_page: 10,
                    current_page: 1,
                    url_params: null
                }
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
        components: {
            'pagination': require('../blocks/Pagination.vue'),
        },
        watch: {
            'entry' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.params.current_page = 1;
                    this.getComments();
                }
            }
        },
        methods: {
            getComments () {
                let formData = new FormData();
                formData.append('page', this.params.current_page);

                this.$http.post(location.origin + '/comments/' + this.entry.id + '/show', formData).then((responce) => {
                    this.comments = responce.data.comments;
                    this.params.total = parseInt(responce.data.count);
                });
            },
            save () {
                this.$validator.validateAll().then(() => {
                    let formData = new FormData();
                    formData.append('text', this.comment);

                    this.$http.post(location.origin + '/comments/' + this.entry.id + '/' + this.user.id + '/store', formData).then((responce) => {
                        this.comment = null;
                        this.params.current_page = 1;
                        this.comments = responce.data.comments;
                        this.params.total = parseInt(responce.data.count);
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