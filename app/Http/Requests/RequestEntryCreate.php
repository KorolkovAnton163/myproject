<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestEntryCreate extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('entriesEdit', auth()->user());
    }

    public function rules()
    {
        return [
           //
        ];
    }
}