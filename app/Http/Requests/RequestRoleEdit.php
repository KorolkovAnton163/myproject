<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestRoleEdit extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('rolesEdit', auth()->user());
    }

    public function rules()
    {
        return [
            //
        ];
    }
}