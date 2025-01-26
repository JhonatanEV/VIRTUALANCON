<?php

namespace App\Traits;

trait ApiResponser
{

    protected function errorexceptionResponse($message)
    {
        return response()->json([
            'errors' => [
                'error' => [
                    $message
                ]
            ]
        ], 422);
    }

    protected function successResponse($data = null, $code = 200, $mensaje = 'La operación se realizó exitosamente')
    {
        return response()->json(['code' => $code, 'mensaje' => $mensaje, 'data' => $data], $code);
    }

    protected function errorResponse($exception, $code = 500, $mensaje = null)
    {
        return response()->json(['code' => $code, 'mensaje' => $mensaje, 'errors' => ['info' => ["Error {$exception}, por favor contacte con el administrador."]]], $code);
    }
}
