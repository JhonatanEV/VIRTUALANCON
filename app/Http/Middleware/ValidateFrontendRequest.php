<?php

namespace App\Http\Middleware;

use Closure;

class ValidateFrontendRequest
{
 
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
