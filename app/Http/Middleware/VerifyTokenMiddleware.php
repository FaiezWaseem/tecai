<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class VerifyTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token not provided',
            ], 401);
        }

        try {
      
            $token = str_replace('Bearer ', '', $token);
            $decoded = JWT::decode($token, new Key('tecai', 'HS256'));
            $request->id = $decoded->id;
            $request->email = $decoded->email;
            $request->decodedToken = $decoded;

            return $next($request);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 401);
        }
    }
}