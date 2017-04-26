<template>
    <div class="page-container users-page-container">
        <div v-if="user && user.canUsersEdit">
            <h2>Пользователи</h2>
            <div class="users-container">
                <div class="user-titles">
                    <span>Имя</span>
                    <span>Почта</span>
                    <span>Роль</span>
                </div>
                <div class="user-item" v-for="user in users">
                    <span>{{ user.name }}</span>
                    <span>{{ user.email }}</span>
                    <span class="select-field">
                        <select v-model="user.role" @change="changeRole(user)">
                            <option v-for="role in roles"
                                    :selected="user.role == role.id"
                                    :value="role.id">{{ role.name }}</option>
                        </select>
                    </span>
                </div>
                <pagination :params="params" :callback="getUsers"></pagination>
            </div>
        </div>
        <access-denied v-else></access-denied>
    </div>
</template>
<script>
    module.exports = {
        data () {
            return {
                users: null,
                roles: null,
                params: {
                    total: 0,
                    on_page: 10,
                    current_page: 1,
                    url_params: 'users'
                }
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
        methods: {
            getUsers() {
                let page = this.$route.query.page ? this.$route.query.page : this.params.current_page;

                this.params.current_page = parseInt(page);

                this.$http.post(location.origin + '/users', {page: page}).then((responce) => {
                    this.users = _.isEmpty(responce.data.count) ? responce.data.users : null;
                    this.roles = responce.data.roles;
                    this.params.total = responce.data.count;
                });
            },
            changeRole (user) {
                this.$http.post(location.origin + '/users/' + user.id + '/update', {role_id: user.role}).then((responce) => {
                    if (this.user.id == user.id) {
                        this.user = responce.data;
                    }
                });
            }
        }
    }
</script>