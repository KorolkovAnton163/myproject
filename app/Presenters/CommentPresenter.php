<?php

namespace App\Presenters;


use Laracasts\Presenter\Presenter;

class CommentPresenter extends Presenter
{
    public function listing()
    {
        return [
            'text' => $this->entity->text,
            'user' => $this->entity->user->name,
            'date' => $this->entity->created_at->format('d.m.Y'),
        ];
    }
}