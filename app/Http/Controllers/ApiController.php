<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use ApiResponser;

    protected function successResponse($mensaje = 'La operación se realizó exitosamente', $code = 200)
    {
        return response()->json([
            'code' => $code,
            'data' => $mensaje,
        ], 200);
    }

    protected function exceptionResponse($exception, $code = 422)
    {

        return response()->json([
            'code' => $code,
            'mensaje' => $exception,
        ], 422);
    }
}
