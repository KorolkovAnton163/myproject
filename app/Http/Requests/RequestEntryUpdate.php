<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class RequestEntryUpdate extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('entriesEdit', auth()->user());
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:150',
            'description' => 'required|max:5000',
            'image.id' => 'required|exists:images,id',
            'tags' => 'required',
            'tags.*' => 'exists:tags,id',
            'year' => 'required|in:' . implode(',', range(Carbon::now()->format('Y'), '1985')),
            'episodes' => 'integer',
        ];
    }
}