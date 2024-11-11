<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminSessionController extends Controller
{
    public function create()
    {
        return view('admin_auth.signin');
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
        return redirect('/admins/dashboard');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/signin');
    }
}
