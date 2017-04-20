<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class EntryPresenter extends Presenter
{
    public function listing($user = null)
    {
        return [
            'id' => $this->entity->id,
            'title' => $this->entity->title,
            'description' => $this->entity->description,
            'bookmark' => !empty($user) ? (bool) $user->entries()->find($this->entity->id) : false,
            'image' => $this->image(),
            'tags' => $this->entity->tags
        ];
    }

    public function show($user = null)
    {
        return [
            'id' => $this->entity->id,
            'title' => $this->entity->title,
            'description' => $this->entity->description,
            'bookmark' => !empty($user) ? (bool) $user->entries()->find($this->entity->id) : false,
            'image' => $this->image(),
            'tags' => $this->entity->tags
        ];
    }

    public function edit()
    {
        return [
            'id' => $this->entity->id,
            'title' => $this->entity->title,
            'description' => $this->entity->description,
            'tags' => $this->entity->tags
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