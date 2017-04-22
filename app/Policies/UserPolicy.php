<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function rolesEdit(User $user)
    {
        return $user->checkPermission($user, 'roles.edit');
    }

    public function usersEdit(User $user)
    {
        return $user->checkPermission($user, 'users.edit');
    }

    public function entriesEdit(User $user)
    {
        return $user->checkPermission($user, 'entries.edit');
    }

    public function tagsEdit(User $user)
    {
        return $user->checkPermission($user, 'tags.edit');
    }
}
