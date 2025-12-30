<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;


class LoginController extends Controller
{
    /*Tampilkan form login*/
    public function form()
    {
        // Jika sudah login, redirect ke dashboard sesuai role
        if (Auth::check()) {
            $user = Auth::user();
            return $user->role === 'owner'
                ? redirect()->route('owner.dashboard')
                : redirect()->route('penjaga.dashboard');
        }

        return view('auth.login');
    }

    /*Proses login*/
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt(
            $request->only('email', 'password'),
            $request->filled('remember')
        )) {
            return back()->withErrors([
                'email' => 'Email atau password salah',
            ]);
        }

        $user = Auth::user();

        // 🔒 VALIDASI KERAS PENJAGA
        if ($user->role === 'penjaga' && !$user->warung_id) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'Akun Anda belum di-assign ke cabang warung. Hubungi owner.',
            ]);
        }

        // 🔒 AKUN NONAKTIF
        if (!$user->is_active) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'Akun Anda sedang dinonaktifkan. Hubungi owner.',
            ]);
        }
        $request->session()->regenerate();

        return $user->role === 'owner'
            ? redirect()->route('owner.dashboard')
            : redirect()->route('penjaga.dashboard');


    }



    /*Logout*/
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
