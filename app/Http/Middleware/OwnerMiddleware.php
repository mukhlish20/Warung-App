<?php

namespace App\Http\Middleware;

use Closure;

class OwnerMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'owner') {
            abort(403);
        }

        return $next($request);
    }

}
