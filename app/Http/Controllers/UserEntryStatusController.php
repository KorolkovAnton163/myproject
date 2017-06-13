<?php

namespace App\Http\Controllers;

use App\Entry;
use App\UserEntryStatus;
use Illuminate\Http\Request;

class UserEntryStatusController extends Controller
{
    public function store(Request $request, Entry $entry)
    {
        $entryStatus = new UserEntryStatus([
            'user_id' => auth()->user()->id,
            'entry_id' => $entry->id,
            'status' => $request->input('status'),
        ]);

        $entryStatus->save();
    }

    public function update(Request $request, Entry $entry)
    {
        $entryStatus = $entry->statuses()->where('user_id', auth()->user()->id)->first();
        $entryStatus->status = $request->input('status');
        $entryStatus->save();
    }
}