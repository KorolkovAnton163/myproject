<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('master', [
            'user' => !empty($user) ? $user->present()->user() : null
        ]);
    }
}