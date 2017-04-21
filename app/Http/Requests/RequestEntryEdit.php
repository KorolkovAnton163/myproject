<?php

namespace App\Http\Requests;


use App\User;
use Illuminate\Foundation\Http\FormRequest;

class RequestEntryEdit extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('entryEdit', User::class);
    }

    public function rules()
    {
        return [
           //
        ];
    }
}