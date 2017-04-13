<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class EntryPresenter extends Presenter
{
    public function listing()
    {
        return [
            'id' => $this->entity->id,
            'title' => $this->entity->title,
            'description' => $this->entity->description,
        ];
    }

    public function show()
    {
        return [
            'id' => $this->entity->id,
            'title' => $this->entity->title,
            'description' => $this->entity->description,
        ];
    }
}