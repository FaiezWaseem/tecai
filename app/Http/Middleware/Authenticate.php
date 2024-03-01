<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('user')) {
            return redirect()->route('auth.login')->withErrors([
                'login' => 'Please login to access this page.',
            ]);
        }

        return $next($request);
    }
}
