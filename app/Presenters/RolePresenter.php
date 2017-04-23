<?php

namespace App\Presenters;


use Laracasts\Presenter\Presenter;

class RolePresenter extends Presenter
{
    public function index()
    {
        return [
            'id' => $this->entity->id,
            'name' => $this->entity->name,
            'permissions' => $this->entity->permissions->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                ];
            })
        ];
    }
}