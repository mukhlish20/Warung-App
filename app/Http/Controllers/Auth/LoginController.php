<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\LoginAttempt;


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
            'email' => 'required|email|max:255',
            'password' => 'required|min:8',
        ]);

        // Rate limiting untuk mencegah brute force
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request));
            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
            ])->onlyInput('email');
        }

        if (!Auth::attempt(
            $request->only('email', 'password'),
            $request->filled('remember')
        )) {
            RateLimiter::hit($this->throttleKey($request), 60); // 1 menit lockout

            // Log failed login attempt
            event(new LoginAttempt(
                $request->email,
                $request->ip(),
                false,
                $request->userAgent()
            ));

            return back()->withErrors([
                'email' => 'Email atau password salah',
            ])->onlyInput('email');
        }

        RateLimiter::clear($this->throttleKey($request));

        // Log successful login
        event(new LoginAttempt(
            $request->email,
            $request->ip(),
            true,
            $request->userAgent()
        ));

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

    /**
     * Get the throttle key for the given request.
     */
    protected function throttleKey(Request $request): string
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }
}
