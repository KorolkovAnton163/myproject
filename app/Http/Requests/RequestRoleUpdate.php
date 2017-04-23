<?php

namespace App\Http\Requests;


use App\User;
use Illuminate\Foundation\Http\FormRequest;

class RequestRoleUpdate extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('rolesEdit', User::class);
    }

    public function rules()
    {
        return [
            'roles.*.id' => 'required|exists:roles,id',
            'roles.*.permissions.*.id' => 'required|exists:permissions,id',
        ];
    }
}