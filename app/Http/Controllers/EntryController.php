<?php

namespace App\Http\Controllers;


use App\Entry;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    public function index(Request $request)
    {
        $query = Entry::query();

        $count = $query->count();

        if ($request->has('page')) {
            $query->skip(($request->input('page') - 1) * 10);
        }

        $query->take(10);

        $entries = $query->get();

        return [
            'entries' => $entries->map(function ($entry) {
                return $entry->present()->listing();
            }),
            'count' => $count,
        ];
    }

    public function show(Request $request, Entry $entry)
    {
        return $entry->present()->show();
    }
}