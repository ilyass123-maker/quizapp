<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');  // Ensure this matches the login Blade view you are using
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Redirect based on user type
            if (Auth::user()->type === 'teacher') {
                return redirect()->route('welcome-teacher');
            } elseif (Auth::user()->type === 'student') {
                return redirect()->route('quiz');
            }
        }

        return redirect()->back()->withErrors(['Invalid credentials.']);
    }
    public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login'); // Redirect to login page after logout
}

}
