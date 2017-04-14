<?php

namespace App;

use App\Presenters\RolePresenter;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Role extends Model
{
    protected $presenter = RolePresenter::class;

    use PresentableTrait;

    protected $fillable = [
        'name',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}