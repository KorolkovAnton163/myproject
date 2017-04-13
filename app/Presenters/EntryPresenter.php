<?php

namespace App\Presenters;

use App\User;
use Laracasts\Presenter\Presenter;

class EntryPresenter extends Presenter
{
    public function listing(User $user)
    {
        return [
            'id' => $this->entity->id,
            'title' => $this->entity->title,
            'description' => $this->entity->description,
            'bookmark' => (bool) $user->entries()->find($this->entity->id),
        ];
    }

    public function show($user)
    {
        return [
            'id' => $this->entity->id,
            'title' => $this->entity->title,
            'description' => $this->entity->description,
            'bookmark' => (bool) $user->entries()->find($this->entity->id),
        ];
    }
}