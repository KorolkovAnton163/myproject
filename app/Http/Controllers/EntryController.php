<?php

namespace App\Http\Controllers;


use App\Entry;
use App\Tag;
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

        if ($request->has('tags')) {
            $tags = $request->input('tags');
            $query->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('id', explode(',', $tags));
            });
        }

        $count = $query->count();

        if ($request->has('page')) {
            $query->skip(($request->input('page') - 1) * 10);
        }

        $query->take(10);

        $entries = $query->get();

        return [
            'entries' => $entries->map(function ($entry) {
                return $entry->present()->show(Auth::user());
            }),
            'count' => $count,
            'tags' => Tag::all(),
        ];
    }

    public function show(Request $request, Entry $entry)
    {
        return $entry->present()->show(Auth::user());
    }

    public function edit(Request $request, Entry $entry)
    {
        return $entry->present()->edit();
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
                return $entry->present()->show($user);
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