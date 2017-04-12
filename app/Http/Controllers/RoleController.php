<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;

class RoleController extends Controller
{
    public function index()
    {
        return [
            'roles' => Role::all()->map(function ($role) {
                return $role->present()->index();
            }),
            'permissions' => Permission::all()->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                ];
            }),
        ];
    }
}