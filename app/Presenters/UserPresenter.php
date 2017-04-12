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
        ];
    }
}