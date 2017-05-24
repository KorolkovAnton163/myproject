<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestUserLogin;
use App\Http\Requests\RequestUserStore;
use App\Role;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ThrottlesLogins, RegistersUsers;

    public function getUsers(Request $request)
    {
        $query = User::query();

        $count = $query->count();

        if ($request->has('page')) {
            $query->skip(($request->input('page') - 1) * 10);
        }

        $query->take(10);

        $users = $query->get();

        return [
            'users' => $users->map(function ($user) {
                return $user->present()->listing();
            }),
            'count' => $count,
            'roles' => Role::all(),
        ];
    }

    public function update(Request $request, User $user)
    {
        $user->fill($request->except('_token'));
        $user->save();

        return response()->json($user->present()->user());
    }

    public function register(RequestUserStore $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role_id' => Role::where('name', 'User')->first()->id,
            'password' => $request->input('password'),
        ]);

        event(new Registered($user));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: response()->json($user->present()->user());
    }

    public function login(RequestUserLogin $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return response()->json([], 422);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect()->to('/');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return response()->json(Auth::user()->present()->user());
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $request->only($this->username(), 'password'), $request->has('remember')
        );
    }

    protected function username()
    {
        return 'email';
    }

    protected function guard()
    {
        return Auth::guard();
    }
}