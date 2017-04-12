<?php

namespace App\Http\Controllers;

use App\Role;

class RoleController extends Controller
{
    public function index()
    {
        return Role::all()->map(function ($role) {
            return $role->present()->index();
        });
    }
}