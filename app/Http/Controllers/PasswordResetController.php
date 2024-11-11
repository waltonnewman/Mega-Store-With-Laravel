<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function showResetRequestForm()
    {
        return view('auth.passwords.email');
    } 

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $token = Str::random(60);
        $email = $request->email;

        // Store token in the database
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now(),
        ]);

        // Send email with the reset link
        Mail::send('emails.password_reset', ['token' => $token], function ($message) use ($email) {
            $message->to($email);
            $message->subject('Password Reset Request');
        });

        return back()->with('status', 'Password reset link sent to your email!');
    }

    public function showResetForm(Request $request)
{
    return view('auth.passwords.reset')->with(['token' => $request->token]);
}

public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'token' => 'required',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Check if the token is valid
    $record = DB::table('password_reset_tokens')->where('email', $request->email)->where('token', $request->token)->first();

    if (!$record) {
        return back()->withErrors(['token' => 'The provided token is invalid.']);
    }

    // Update the user's password
    $user = User::where('email', $request->email)->first();
    $user->password = bcrypt($request->password);
    $user->save();

    // Optionally, delete the token after use
    DB::table('password_reset_tokens')->where('email', $request->email)->delete();

    return redirect()->route('login')->with('status', 'Your password has been reset!');
}

}
