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
                return $entry->present()->listing(Auth::user());
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

    public function getNew(Request $request)
    {
        return Entry::orderBy('updated_at', 'desc')->take(5)->get()->map(function ($entry) {
            return $entry->present()->listing();
        });
    }
}