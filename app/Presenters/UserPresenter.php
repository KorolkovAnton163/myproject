<?php

namespace App\Presenters;

use App\User;
use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
    public function user()
    {
        return [
            'name' => $this->entity->name,
            'email' => $this->entity->email,
            'canRolesEdit' => $this->entity->can('rolesEdit', User::class),
        ];
    }
}