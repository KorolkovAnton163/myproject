<?php

namespace App\Http\Controllers;


use App\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntryController extends Controller
{
    public function index(Request $request)
    {
        $query = Entry::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . trim($request->input('search')) . '%')
                ->orWhere('description', 'like', '%' . trim($request->input('search')) . '%');
        }

        $count = $query->count();

        if ($request->has('page')) {
            $query->skip(($request->input('page') - 1) * 10);
        }

        $query->take(10);

        $entries = $query->get();

        return [
            'entries' => $entries->map(function ($entry) {
                return $entry->present()->listing(Auth::user());
            }),
            'count' => $count,
        ];
    }

    public function show(Request $request, Entry $entry)
    {
        return $entry->present()->show(Auth::user());
    }

    public function bookmarks(Request $request)
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
                return $entry->present()->listing($user);
            }),
            'count' => $count,
        ];
    }

    public function bookmarkStore(Request $request, Entry $entry)
    {
        Auth::user()->entries()->sync($entry->id, false);
    }

    public function bookmarkDestroy(Request $request, Entry $entry)
    {
        $entries = Auth::user()->entries()->where('id', '!=', $entry->id)->pluck('id')->toArray();

        Auth::user()->entries()->sync($entries);
    }
}