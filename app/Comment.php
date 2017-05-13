<?php

namespace App;


use App\Presenters\CommentPresenter;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Comment extends Model
{
    use PresentableTrait;

    protected $presenter = CommentPresenter::class;

    protected $fillable = [
        'text', 'user_id', 'entry_id',
    ];

    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}