<?php

namespace App\Http\Controllers;


use App\Entry;
use App\Http\Requests\RequestEntryCreate;
use App\Http\Requests\RequestEntryEdit;
use App\Http\Requests\RequestEntryStore;
use App\Http\Requests\RequestEntryUpdate;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $entries = $query->orderBy('updated_at', 'desc')->get();

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

    public function create(RequestEntryCreate $request)
    {
        return [
            'tags' => Tag::all()
        ];
    }

    public function edit(RequestEntryEdit $request, Entry $entry)
    {
        return [
            'entry' => $entry->present()->edit(),
            'tags' => Tag::all()
        ];
    }

    public function update(RequestEntryUpdate $request, Entry $entry)
    {
        DB::transaction(function () use ($entry, $request) {
            $input = $request->input();

            $entry->title = $input['title'];
            $entry->description = $input['description'];
            $entry->alias = $input['title'];

            $entry->save();

            $entry->images()->sync($input['image']['id']);
            $entry->tags()->sync($input['tags']);
        });
    }

    public function store(RequestEntryStore $request)
    {
        return DB::transaction(function () use ($request) {
            $input = $request->input();

            $entry = new Entry([
                'title' => $input['title'],
                'description' => $input['description'],
                'alias' => $input['title'],
            ]);

            $entry->save();

            $entry->images()->sync($input['image']['id']);
            $entry->tags()->sync($input['tags']);

            return $entry;
        });
    }

    public function getNew(Request $request)
    {
        return Entry::orderBy('updated_at', 'desc')->take(5)->get()->map(function ($entry) {
            return $entry->present()->listing();
        });
    }
}