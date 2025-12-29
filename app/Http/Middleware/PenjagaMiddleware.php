<?php

namespace App\Http\Middleware;

use Closure;

class PenjagaMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'penjaga') {
            abort(403);
        }

    return $next($request);
    }

}

