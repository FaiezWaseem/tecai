<?php

namespace App\Http\Middleware;

use Closure;

class CheckTeacher
{
    public function handle($request, Closure $next)
    {
        if (!session('isTeacher')) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}