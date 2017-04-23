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
        $file = implode('/', [url('/'), $this->path, $this->name]);

        if (file_exists(public_path(implode('/', [$this->path, $this->name])))) {
            return $file;
        }
        return null;
    }
}