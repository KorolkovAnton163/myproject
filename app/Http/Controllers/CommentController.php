<?php

namespace App\Http\Controllers;


use App\Comment;
use App\Entry;
use App\Http\Requests\RequestCommentStore;
use App\User;

class CommentController extends Controller
{
    public function store(RequestCommentStore $request, Entry $entry, User $user)
    {
        $comment = new Comment([
            'text' => $request->input('text'),
            'user_id' => $user->id,
            'entry_id' => $entry->id,
        ]);

        $comment->save();

        return $comment->present()->listing();
    }
}