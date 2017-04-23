<?php

namespace App\Http\Requests;


use App\User;
use Illuminate\Foundation\Http\FormRequest;

class RequestRoleEdit extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('rolesEdit', User::class);
    }

    public function rules()
    {
        return [
            //
        ];
    }
}