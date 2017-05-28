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
            'alias' => $this->entity->alias,
            'year' => $this->entity->year,
            'bookmark' => !empty($user) ? (bool)$user->entries()->find($this->entity->id) : false,
            'image' => $this->image(),
            'tags' => $this->entity->tags,
            'titles' => $this->entity->titles,
            'episodes' => $this->entity->episodes ? $this->entity->episodes : '??',
            'currentEpisodes' => $this->entity->videos()->count() ? $this->entity->videos()->count() : '??',
        ];
    }

    public function show($user = null)
    {
        return [
            'id' => $this->entity->id,
            'title' => $this->entity->title,
            'description' => $this->entity->description,
            'alias' => $this->entity->alias,
            'year' => $this->entity->year,
            'bookmark' => !empty($user) ? (bool)$user->entries()->find($this->entity->id) : false,
            'image' => $this->image(),
            'tags' => $this->entity->tags,
            'titles' => $this->entity->titles,
            'videos' => $this->entity->videos()->orderBy('id')->get()->map(function ($video) use ($user) {
                return $video->present()->show($user);
            }),
            'videosCount' => $this->entity->videos()->count(),
            'episodes' => $this->entity->episodes ? $this->entity->episodes : '??',
            'currentEpisodes' => $this->entity->videos()->count() ? $this->entity->videos()->count() : '??',
        ];
    }

    public function edit()
    {
        return [
            'id' => $this->entity->id,
            'title' => $this->entity->title,
            'description' => $this->entity->description,
            'year' => $this->entity->year,
            'image' => !empty($this->image()['id']) ? $this->image() : [],
            'tags' => $this->entity->tags->pluck('id'),
            'titles' => $this->entity->titles,
            'episodes' => $this->entity->episodes,
            'videos' => $this->entity->videos()->orderBy('id')->get()->map(function ($video) {
                return $video->present()->edit();
            }),
        ];
    }

    private function image()
    {
        $image = $this->entity->images()->first();

        if (!empty($image) && !empty($image->imagePath())) {
            return [
                'id' => $image->id,
                'path' => $image->imagePath(),
            ];
        }

        return [
            'path' => url('/') . '/images/default.jpg'
        ];
    }
}