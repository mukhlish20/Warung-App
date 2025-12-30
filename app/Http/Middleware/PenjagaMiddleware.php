<?php

namespace App\Http\Middleware;

use Closure;

class PenjagaMiddleware
{
    public function handle($request, Closure $next)
    {
        // Jika belum login, redirect ke login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Jika bukan penjaga, redirect ke dashboard sesuai role
        if (auth()->user()->role !== 'penjaga') {
            return redirect()->route('owner.dashboard');
        }

        return $next($request);
    }

}

