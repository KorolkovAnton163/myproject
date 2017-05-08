<?php

namespace App;

use App\Presenters\VideoPresenter;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Video extends Model
{
    use PresentableTrait;

    protected $presenter = VideoPresenter::class;

    protected $fillable = [
        'url',
    ];

    public function entries()
    {
        return $this->belongsToMany(Entry::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}