<?php

namespace App\Http\Controllers;


use App\Http\Requests\RequestTagDestroy;
use App\Http\Requests\RequestTagEdit;
use App\Http\Requests\RequestTagStore;
use App\Http\Requests\RequestTagUpdate;
use App\Tag;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function index(RequestTagEdit $request) {
        return Tag::all();
    }

    public function store(RequestTagStore $request)
    {
        return DB::transaction(function () use ($request) {
            $tag = new Tag([
                'name' => $request->input('name'),
            ]);
            $tag->save();

            return $tag;
        });
    }

    public function destroy(RequestTagDestroy $request, Tag $tag)
    {
        $tag->delete();

        return Tag::all();
    }

    public function update(RequestTagUpdate $request)
    {
        DB::transaction(function () use ($request) {
            foreach ($request->input() as $tag) {
                $current = Tag::find($tag['id']);
                $current->name = $tag['name'];
                $current->save();
            }
        });
    }
}