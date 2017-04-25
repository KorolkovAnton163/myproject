<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class RequestImageUpload extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('entriesEdit', User::class);
    }

    public function rules()
    {
        return [
            'image' => 'required|image:jpeg,png|max:2048'
        ];
    }
}