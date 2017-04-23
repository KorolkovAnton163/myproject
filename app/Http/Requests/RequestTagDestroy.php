<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class RequestTagDestroy extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('tagsEdit', User::class);
    }

    public function rules()
    {
        return [
            //
        ];
    }
}