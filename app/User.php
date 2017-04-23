<?php

namespace App;

use App\Presenters\UserPresenter;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laracasts\Presenter\PresentableTrait;

class User extends Authenticatable
{
    protected $presenter = UserPresenter::class;

    use Notifiable, PresentableTrait;

    protected $fillable = [
        'name', 'email', 'password', 'role_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function entries()
    {
        return $this->belongsToMany(Entry::class);
    }

    public function checkPermission($user, $permission)
    {
        return (bool) $user->role->permissions->where('name', $permission)->first();
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
