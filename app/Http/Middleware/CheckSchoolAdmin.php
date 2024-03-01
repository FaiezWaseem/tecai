<?php

namespace App\Http\Middleware;

use Closure;

class CheckSchoolAdmin
{
    public function handle($request, Closure $next)
    {
        if (!session('admin') && session('user')['super_admin'] != 0) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}