<?php

namespace App\Http\Middleware;

use App\Http\Controllers\UserPermission;
use Closure;

class CheckStudent
{
    public function handle($request, Closure $next)
    {
        if (!UserPermission::isStudent()) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}