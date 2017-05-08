<?php

namespace App\Http\Controllers;


use App\Entry;
use App\Http\Requests\RequestVideoBookmark;
use App\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    //TODO Rewrite this without DB::table
    public function bookmark(RequestVideoBookmark $request, Entry $entry, Video $video)
    {
        $user = Auth::user();
        DB::table('user_video')->where('user_id', $user->id)
            ->where('entry_id', $entry->id)->delete();
        DB::table('user_video')
            ->insert([
                'user_id' => $user->id,
                'video_id' => $video->id,
                'entry_id' => $entry->id,
            ]);
    }
}