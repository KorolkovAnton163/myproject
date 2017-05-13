<?php

namespace App\Http\Controllers;


use App\Comment;
use App\Entry;
use App\Http\Requests\RequestCommentStore;
use App\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    const ON_PAGE = 10;

    public function store(RequestCommentStore $request, Entry $entry, User $user)
    {
        $comment = new Comment([
            'text' => $request->input('text'),
            'user_id' => $user->id,
            'entry_id' => $entry->id,
        ]);

        $comment->save();

        return [
            'comments' => $entry->comments()->orderBy('created_at', 'desc')->take(self::ON_PAGE)->get()
                ->map(function ($comment) {
                    return $comment->present()->listing();
                }),
            'count' => $entry->comments()->count(),
        ];
    }

    public function show(Request $request, Entry $entry)
    {
        $comments = $entry->comments()
            ->skip(($request->input('page') - 1) * self::ON_PAGE)
            ->take(self::ON_PAGE)
            ->orderBy('created_at', 'desc')
            ->get();

        return [
            'comments' => $comments->map(function ($comment) {
                return $comment->present()->listing();
            }),
            'count' => $entry->comments()->count()
        ];
    }
}