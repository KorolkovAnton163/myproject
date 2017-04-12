<?php

namespace App\Presenters;


use Laracasts\Presenter\Presenter;

class RolePresenter extends Presenter
{
    public function index()
    {
        return [
            'name' => $this->entity->name,
        ];
    }
}