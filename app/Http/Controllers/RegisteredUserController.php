<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
   

    $userAttributes = $request->validate([
        'name' => ['required'],
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => ['required', 'confirmed', Password::min(6)],
    ]);

    

    $user = User::create($userAttributes);
    Auth::login($user);
    return redirect('/users/dashboard');
}

public function settings(User $user)
{

     // Get the current user's latest request status
    $requestStatus = auth()->user() ? auth()->user()->latestRequestStatus() : null;
     return view('/users/profile.settings', compact('user', 'requestStatus'));
}


    public function update(Request $request, User $user)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'email' => 'string|max:255',
        'phone' => 'string',
        'country' => 'nullable|string',
        'city' => 'string',
    ]);


    // Handle image upload if applicable
   
        // Assuming you have a method to handle the image upload
    
         // Handle image upload if applicable
    if ($request->hasFile('image')) {
        $user->image = $request->file('image')->store('images/users', 'public');
    }
       // Update other user attributes
    $user->email = $validatedData['email'];
    $user->phone = $validatedData['phone'];
    $user->country = $validatedData['country'];
    $user->city = $validatedData['city'];
    $user->save();
    

    return redirect()->route('profile.settings', auth()->user()->id)->with('success', 'Product updated successfully!');
}

}