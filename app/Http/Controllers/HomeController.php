<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('master', [
            'user' => !empty($user) ? $user->present()->user() : null
        ]);
    }
}