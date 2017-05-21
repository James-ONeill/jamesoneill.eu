<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login()
    {
        if (! Auth::attempt(request(['email', 'password']))) {
            return redirect('/login')->withInput(request(['email']))->withErrors([
                'email' => ['These credentials do not match our records.'],
            ]);
        }

        return redirect('/dashboard');
    }
}
