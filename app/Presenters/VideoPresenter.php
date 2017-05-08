<?php

namespace App\Presenters;


use Laracasts\Presenter\Presenter;

class VideoPresenter extends Presenter
{
    public function show($user = null)
    {
        return [
            'id' => $this->entity->id,
            'url' => $this->entity->url,
            'active' => false,
            'bookmark' =>  $user ? (bool)$this->entity->users()->where('users.id', $user->id)->first() : false,
        ];
    }

    public function edit()
    {
        return [
            'id' => $this->entity->id,
            'url' => $this->entity->url,
        ];
    }
}