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

    public function images()
    {
        return $this->belongsToMany(Image::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}