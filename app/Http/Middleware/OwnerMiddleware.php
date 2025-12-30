<?php

namespace App\Http\Middleware;

use Closure;

class OwnerMiddleware
{
    public function handle($request, Closure $next)
    {
        // Jika belum login, redirect ke login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Jika bukan owner, redirect ke dashboard sesuai role
        if (auth()->user()->role !== 'owner') {
            return redirect()->route('penjaga.dashboard');
        }

        return $next($request);
    }

}
