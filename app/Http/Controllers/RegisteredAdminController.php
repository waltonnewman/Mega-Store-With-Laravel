<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class RegisteredAdminController extends Controller
{
    public function create()
    {
        return view('admin_auth.signup');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    

    $adminAttributes = $request->validate([
        'name' => ['required'],
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => ['required', 'confirmed', Password::min(6)],

    ]);

    
    // Set the role to 'admin'
    $adminAttributes['role'] = 'admin';

    $admin = User::create($adminAttributes); // Use User model
    Auth::login($admin); // Corrected from Auth::signin to Auth::login

    return view('/signin');
}
}
