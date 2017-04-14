<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class EntryPresenter extends Presenter
{
    public function listing($user)
    {
        return [
            'id' => $this->entity->id,
            'title' => $this->entity->title,
            'description' => $this->entity->description,
            'bookmark' => !empty($user) ? (bool) $user->entries()->find($this->entity->id) : false,
        ];
    }

    public function show($user)
    {
        return [
            'id' => $this->entity->id,
            'title' => $this->entity->title,
            'description' => $this->entity->description,
            'bookmark' => !empty($user) ? (bool) $user->entries()->find($this->entity->id) : false,
        ];
    }
}