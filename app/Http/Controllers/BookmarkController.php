<?php

namespace App\Http\Controllers;


use App\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = $user->entries();

        $count = $query->count();

        if ($request->has('page')) {
            $query->skip(($request->input('page') - 1) * 10);
        }

        $query->take(10);

        $entries = $query->get();

        return [
            'entries' => $entries->map(function ($entry) use ($user) {
                return $entry->present()->show($user);
            }),
            'count' => $count,
        ];
    }

    public function store(Request $request, Entry $entry)
    {
        Auth::user()->entries()->sync($entry->id, false);
    }

    public function destroy(Request $request, Entry $entry)
    {
        $entries = Auth::user()->entries()->where('id', '!=', $entry->id)->pluck('id')->toArray();

        Auth::user()->entries()->sync($entries);
    }
}