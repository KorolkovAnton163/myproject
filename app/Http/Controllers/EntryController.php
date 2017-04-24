<?php

namespace App\Http\Controllers;


use App\Entry;
use App\Http\Requests\RequestEntryCreate;
use App\Http\Requests\RequestEntryEdit;
use App\Http\Requests\RequestEntryStore;
use App\Http\Requests\RequestEntryUpdate;
use App\Tag;
use App\Title;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntryController extends Controller
{
    public function index(Request $request)
    {
        $query = Entry::query();

        // TODO ILIKE use only postgresql
        if ($request->has('search')) {
            $query->where(function ($query) use ($request) {
                $query->where('title', 'ilike', '%' . trim($request->input('search')) . '%')
                    ->orWhere('description', 'ilike', '%' . trim($request->input('search')) . '%')
                    ->orWhereHas('titles', function ($query) use ($request) {
                        $query->where('name', 'ilike', '%' . trim($request->input('search')) . '%');
                    });
            });
        }

        if ($request->has('tags')) {
            foreach (explode(',', $request->input('tags')) as $tag) {
                $query->whereHas('tags', function ($query) use ($tag) {
                    $query->where('id', $tag);
                });
            }
        }

        if ($request->has('year')) {
            $query->where('year', $request->input('year'));
        }

        $count = $query->count();

        if ($request->has('page')) {
            $query->skip(($request->input('page') - 1) * 10);
        }

        $query->take(10);

        $entries = $query->orderBy('year', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        return [
            'entries' => $entries->map(function ($entry) {
                return $entry->present()->listing(Auth::user());
            }),
            'count' => $count,
            'tags' => Tag::orderBy('name')->get(),
            'years' => range(Carbon::now()->format('Y'), '1985'),
        ];
    }

    public function show(Request $request, Entry $entry)
    {
        return $entry->present()->show(Auth::user());
    }

    public function create(RequestEntryCreate $request)
    {
        return [
            'tags' => Tag::orderBy('name')->get(),
            'years' => range(Carbon::now()->format('Y'), '1985'),
        ];
    }

    public function edit(RequestEntryEdit $request, Entry $entry)
    {
        return [
            'entry' => $entry->present()->edit(),
            'tags' => Tag::orderBy('name')->get(),
            'years' => range(Carbon::now()->format('Y'), '1985'),
        ];
    }

    public function update(RequestEntryUpdate $request, Entry $entry)
    {
        DB::transaction(function () use ($entry, $request) {
            $input = $request->input();

            $entry->title = $input['title'];
            $entry->description = $input['description'];
            $entry->alias = $input['title'];
            $entry->year = $input['year'];

            $entry->save();

            $this->saveEntryParams($entry, $input);
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
                'year' => $input['year'],
            ]);

            $entry->save();

            $this->saveEntryParams($entry, $input);

            return $entry;
        });
    }

    private function saveEntryParams(Entry $entry, $input)
    {
        $entry->images()->sync($input['image']['id']);
        $entry->tags()->sync($input['tags']);

        Title::where('entry_id', $entry->id)->delete();
        foreach ($input['titles'] as $title) {
            $title = new Title([
                'entry_id' => $entry->id,
                'name' => $title['name'],
            ]);
            $title->save();
        }
    }

    public function getNew(Request $request)
    {
        return Entry::orderBy('updated_at', 'desc')->take(5)->get()->map(function ($entry) {
            return $entry->present()->listing();
        });
    }
}