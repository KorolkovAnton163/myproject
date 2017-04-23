<template>
    <div class="page-container role-edit-page-container">
        <div v-if="user && user.canRolesEdit">
            <h2>Roles</h2>
            <popup-role-create :callback="add"></popup-role-create>
            <div class="role-container">
                <table>
                    <thead>
                    <tr>
                        <td v-for="role in roles">{{ role.name }}</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="permission in permissions">
                        <td v-for="role in roles">
                            <label class="checkbox-label">
                                <input class="checkbox" type="checkbox" name="permissions"
                                       @click="setPermission(role, permission)"
                                       :checked="isActive(role, permission)">
                                {{ permission.name }}
                            </label>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <button class="ripple" @click="update">Save</button>
            </div>
        </div>
        <access-denied v-else></access-denied>
    </div>
</template>
<script>
    module.exports = {
        data () {
            return {
                roles: [],
                permissions: []
            }
        },
        computed: {
            user () {
                return this.$store.getters.user
            }
        },
        components: {
            'popup-role-create': require('../blocks/PopupRoleCreate.vue'),
        },
        methods: {
            getRoles () {
                this.$http.post(location.origin + '/roles').then((responce) => {
                    this.roles = responce.data.roles;
                    this.permissions = responce.data.permissions;
                });
            },
            isActive (role, permission) {
                return role.permissions.filter((item) => {
                    return item.id == permission.id
                }).length;
            },
            setPermission (role, permission) {
                if (this.isActive(role, permission)) {
                    role.permissions.splice(role.permissions.indexOf(permission), 1);
                } else {
                    role.permissions.push(permission);
                }
            },
            add (data) {
                this.roles = data.roles;
            },
            update () {
                this.$http.post(location.origin + '/roles/update', {roles: this.roles}).then((responce) => {
                    //
                });
            }
        },
        created () {
            this.getRoles();
        }
    }
</script>