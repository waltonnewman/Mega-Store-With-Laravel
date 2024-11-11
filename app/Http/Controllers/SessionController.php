<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Sorry, those credentials do not match.',
            ]);
        }

        // Regenerate the session to prevent session fixation attacks
        request()->session()->regenerate();

        // Redirect to the user dashboard instead of the home page
        return redirect('/users/dashboard');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/login');
    }
}
