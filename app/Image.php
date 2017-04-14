<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'name', 'path', 'extension'
    ];

    public function entries()
    {
        return $this->belongsToMany(Entry::class);
    }

    public function imagePath()
    {
        $file = implode('/', [url('/'), $this->path, $this->name]) . '.' . $this->extension;

        if (file_exists($file)) {
            return $file;
        }
        return null;
    }
}