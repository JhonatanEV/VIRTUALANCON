<?php

namespace App\Http\Middleware;

use Closure;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        session([
            'SESS_RETURN' => $request->path()
        ]);
        if (!session()->has('SESS_ACTIVE')) {
            return redirect('login');
        }
    
        return $next($request);
    }
}
