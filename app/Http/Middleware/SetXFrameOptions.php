<?php

namespace App\Http\Middleware;

use Closure;

class SetXFrameOptions
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'DENY');

        return $response;
    }
}
