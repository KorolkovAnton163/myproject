<?php

namespace App\Presenters;

use App\User;
use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
    public function user()
    {
        return [
            'id' => $this->entity->id,
            'name' => $this->entity->name,
            'email' => $this->entity->email,
            'password' => '',
            'canRolesEdit' => $this->entity->can('rolesEdit', User::class),
            'canUsersEdit' => $this->entity->can('usersEdit', User::class),
            'canEntryEdit' => $this->entity->can('entryEdit', User::class),
        ];
    }

    public function listing()
    {
        return [
            'id' => $this->entity->id,
            'name' => $this->entity->name,
            'email' => $this->entity->email,
            'role' => $this->entity->role->id
        ];
    }
}