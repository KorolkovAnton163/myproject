<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $fillable = [
        'entry_id', 'name'
    ];

    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }
}