<?php

namespace App\Console\Commands;

use App\Entry;
use Illuminate\Console\Command;

class MockEntries extends Command
{
    protected $signature = 'mock:entries';

    protected $description = 'Add mock entries';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $entries = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/posts'));

        foreach ($entries as $moc) {
            $entry = new Entry([
                'title' => $moc->title,
                'description' => $moc->body,
            ]);
            $entry->save();
        }
    }
}
