<?php

namespace App\Http\Controllers\Seguridad;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Seguridad\Models\Perfil;
use App\Http\Controllers\Seguridad\Resources\PerfilResource;

class PerfilController extends ApiController
{
    public function __construct()
    {
    }
    public function index(Request $request)
    {
        try{
            $perfiles = Perfil::all();
            return $this->successResponse(PerfilResource::collection($perfiles));
        }catch(\Exception $e){
            return $this->errorResponse('Error en el servidor', $e->getMessage(), 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $perfil = new Perfil();
            $perfil->PERF_NOMBRE = $request->perf_nombre;
            $perfil->PERF_NC_NOMBRE = $request->perf_nc_nombre;
            $perfil->PERF_ESTADO = $request->perf_estado;
            $perfil->EMPR_CODIGO = $request->empr_codigo;
            $perfil->save();
            
            return $this->successResponse(new PerfilResource($perfil));

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function show($id)
    {
        $perfil = Perfil::findOrFail($id);
        return response()->json($perfil);
    }

    public function update(Request $request)
    {
        try {
            $perfil = Perfil::findOrFail($request->perf_codigo);
            if (is_null($perfil)) {
                return response()->json(['message' => 'Perfil no encontrado'], 404);
            }
            $perfil->PERF_NOMBRE = $request->perf_nombre;
            $perfil->PERF_NC_NOMBRE = $request->perf_nc_nombre;
            $perfil->PERF_ESTADO = $request->perf_estado;
            $perfil->save();

            return $this->successResponse(new PerfilResource($perfil));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        $perfil = Perfil::findOrFail($id);
        if (is_null($perfil)) {
            return $this->errorResponse('Perfil no encontrado', 404);
        }
        $perfil->PERF_ESTADO = 0;
        $perfil->save();
        return $this->successResponse();
    }
}