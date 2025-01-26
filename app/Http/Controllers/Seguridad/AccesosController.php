<?php

namespace App\Http\Controllers\Seguridad;
use App\Http\Controllers\ApiController;
use App\Http\Requests\AccesosRequest;
use App\Http\Controllers\Seguridad\Resources\AccesosResource;
use App\Http\Controllers\Seguridad\Models\Accesos;
use Illuminate\Http\Request;
use App\Helpers\DeviceIdentifier;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AccesosController extends ApiController
{
    function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $accesos = Accesos::all();
        return AccesosResource::collection($accesos);
    }

    public function store(Request $request)
    {   
        
        try {
            
            Accesos::where('USUA_CODIGO', $request->usua_codigo)->delete();

            $accesosArray = $request->accesos;
            $insertedIds = [];

            DB::transaction(function () use ($accesosArray, $request, &$insertedIds) {
                foreach ($accesosArray as $acceso) {
                    $nuevoAcceso = Accesos::create([
                        'OPCI_CODIGO' => $acceso,
                        'USUA_CODIGO' => $request->usua_codigo,
                        'ACCE_ESTADO' => 1,
                        'ACCE_FECHING' => Carbon::now(),
                        'ACCE_OPERADOR' => auth()->user()->USUA_CODIGO,
                        'ACCE_ESTACION' => $request->ip()
                    ]);

                    $insertedIds[] = $nuevoAcceso->ACCE_CODIGO;
                }
            });
        } catch (\Throwable $th) {
            return $this->exceptionResponse($th->getMessage());
        }

        return $this->successResponse('Accesos asignados correctamente');
    }

    public function show(Accesos $acceso)
    {
        return new AccesosResource($acceso);
    }

    public function update(Request $request, Accesos $acceso)
    {
        $acceso->update($request->validated());
        return new AccesosResource($acceso);
    }

    public function destroy(Accesos $acceso)
    {
        $acceso->delete();
        return response()->noContent();
    }
}