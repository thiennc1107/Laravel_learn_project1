<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create()
    {
        return view('users.register');
    }

    public function store(Request $request)
    {
        $formField = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email',Rule::unique('users','email')],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $formField['password'] = bcrypt($formField['password']);

        $user = User::create($formField);

        auth()->login($user);

        return redirect('/')->with('message', 'user created and logged in');
    }

    public function logout(Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('message', 'You have been logged out!');
    }

    public function login()
    {
        return view('users.login');
    }

    public function authenticate(Request $request)
    {
        $formField = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(auth()->attempt($formField)) {
            $request->session()->regenerate();
            return redirect('/')->with('message', 'Login succesfully');
        }

        return back()->withErrors(['email' => 'Invalid credential'])
            ->onlyInput('email');
    }
}