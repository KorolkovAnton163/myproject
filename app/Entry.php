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
        'title', 'description', 'alias', 'year', 'episodes'
    ];

    public function images()
    {
        return $this->belongsToMany(Image::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function titles()
    {
        return $this->hasMany(Title::class);
    }

    // TODO Rewrite relation on hasMany
    public function videos()
    {
        return $this->belongsToMany(Video::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function setAliasAttribute($value)
    {
        $this->attributes['alias'] = str_slug($value);
    }
}