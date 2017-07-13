<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestRoleStore extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('rolesEdit', auth()->user());
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:150',
        ];
    }
}