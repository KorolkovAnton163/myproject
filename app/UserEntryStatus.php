<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEntryStatus extends  Model
{
    protected $fillable = [
        'user_id', 'entry_id', 'status',
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