<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestRoleEdit;
use App\Http\Requests\RequestRoleStore;
use App\Http\Requests\RequestRoleUpdate;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index(RequestRoleEdit $request)
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

    public function store(RequestRoleStore $request)
    {
        DB::transaction(function () use ($request) {
            $role = new Role($request->except('_token'));
            $role->save();
        });

        return [
            'roles' => Role::all()->map(function ($role) {
                return $role->present()->index();
            })
        ];
    }

    public function update(RequestRoleUpdate $request)
    {
        DB::transaction(function () use ($request) {
            foreach ($request->input('roles') as $role) {
                $currentRole = Role::find($role['id']);
                $currentRole->permissions()->sync(array_map(function ($permission) {
                    return $permission['id'];
                }, $role['permissions']));
            }
        });
    }
}