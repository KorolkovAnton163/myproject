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
            'image' => $this->image(),
        ];
    }

    public function show($user)
    {
        return [
            'id' => $this->entity->id,
            'title' => $this->entity->title,
            'description' => $this->entity->description,
            'bookmark' => !empty($user) ? (bool) $user->entries()->find($this->entity->id) : false,
            'image' => $this->image(),
        ];
    }

    private function image()
    {
        $image = $this->entity->images()->first();

        if (!empty($image) && !empty($image->imagePath())) {
            return $image->imagePath();
        }

        return url('/') . '/images/default.jpg';
    }
}