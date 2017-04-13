<?php

namespace App;

use App\Presenters\EntryPresenter;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Entry extends Model
{
    protected $presenter = EntryPresenter::class;

    use PresentableTrait;

    protected $fillable = [
        'title', 'description'
    ];
}