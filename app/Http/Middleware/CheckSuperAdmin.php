<?php

namespace App\Http\Middleware;

use Closure;

class CheckSuperAdmin
{
    public function handle($request, Closure $next)
    {
        if (session('user')['super_admin'] !== 1) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}