<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class RequestRoleStore extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('rolesEdit', User::class);
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:150',
        ];
    }
}