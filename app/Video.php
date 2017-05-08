<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
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