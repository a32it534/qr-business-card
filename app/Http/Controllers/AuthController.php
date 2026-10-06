<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $r)
    {
        $d = $r->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:190|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $u = User::create([
            'name'     => $d['name'],
            'email'    => $d['email'],
            'password' => Hash::make($d['password']),
        ]);

        Auth::login($u);

        return redirect()->route('dashboard.index');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $r)
    {
        $d = $r->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($d, $r->boolean('remember'))) {
            return back()->withErrors(['email' => 'ایمیل یا رمز عبور صحیح نیست.'])->withInput();
        }

        $r->session()->regenerate();

        return redirect()->intended(route('dashboard.index'));
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();

        return redirect()->route('home');
    }
}
