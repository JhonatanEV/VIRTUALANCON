<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Session;

class ValidarAccesoMiddleware
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
        $url_actual = $request->path();
        $permisos = Session::get('SESS_USUA_ACCESOS');
        $array_unidimensional = array_map('reset', $permisos);
        
        if (!in_array(strval($url_actual), $array_unidimensional)) {
            return redirect()->route('main')->with('error', 'No tienes acceso a este recurso.');
        }
        
        
        return $next($request);
    }
}
