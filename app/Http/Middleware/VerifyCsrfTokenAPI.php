<?php

namespace App\Http\Middleware;

use Closure;

class VerifyCsrfTokenAPI
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('X-CSRF-TOKEN');

        if (! $token || ! hash_equals($token, $request->session()->token())) {
            return response()->json(['error' => 'Token CSRF no válido'], 403);
        }

        return $next($request);
    }
}
