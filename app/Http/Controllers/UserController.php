<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\User;

class UserController extends Controller
{
    //show register form
    public function create()
    {
        return view('users.register');
    }

    //create new user
    public function store(Request $request)
    {
        $formField = $request->validate([
            'name' => 'required',
            'email' => ['required','email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6',
        ]);

        $formField['password'] = bcrypt($formField['password']);

        $user = User::create($formField);

        // login user
        auth()->login($user);
        return redirect('/')->with('message', 'User created successfully!');
    }

    // logout user 
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'User logged out successfully!');
    }

    // show login form
    public function login()
    {
        return view('users.login');
    }

    // login user
    public function authenticate(Request $request)
    {
        $formField = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($formField)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'User logged in successfully!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
