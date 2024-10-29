<?php

namespace App\Http\Middleware;

use App\Http\Controllers\UserPermission;
use Closure;

class CheckDemoStudent
{
    public function handle($request, Closure $next)
    {
        if (!UserPermission::isDemoStudent()) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}