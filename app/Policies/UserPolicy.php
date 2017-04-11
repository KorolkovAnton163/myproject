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
        return $user->checkPermission($user, 'role.edit');
    }
}