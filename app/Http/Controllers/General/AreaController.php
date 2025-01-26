<?php

namespace App\Http\Controllers\General;
use App\Http\Controllers\ApiController;
use App\Http\Requests\AccesosRequest;
use App\Http\Controllers\General\Resources\AreasResource;
use App\Http\Controllers\General\Models\Areas;
use Illuminate\Http\Request;

class AreaController extends ApiController
{
    function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index(Request $request)
    {
        try {
            $data = Areas::where('EMPR_CODIGO', $request->empr_codigo)->orderBy('AREA_NOMBRE', 'ASC')->get();

            return $this->successResponse(AreasResource::collection($data));
        } catch (\Throwable $th) {
            return $this->exceptionResponse($th->getMessage());
        }
    }

    public function store(Request $request)
    {   
        try {
            $area = new Areas();
            $area->AREA_NOMBRE = $request->area_nombre;
            $area->AREA_TIPO = $request->area_tipo;
            $area->AREA_ABREV = $request->area_abrev;
            $area->AREA_ORDEN = $request->area_orden;
            $area->AREA_ESTADO = $request->area_estado;
            $area->EMPR_CODIGO = $request->empr_codigo;
            $area->save();

        } catch (\Throwable $th) {
            return $this->exceptionResponse($th->getMessage());
        }

        return $this->successResponse('Registrado correctamente');
    }

    public function show(Areas $acceso)
    {
        return new AreasResource($acceso);
    }

    public function update(Request $request)
    {
        try {
            $area = Areas::find($request->area_codigo);
            $area->AREA_NOMBRE = $request->area_nombre;
            $area->AREA_TIPO = $request->area_tipo;
            $area->AREA_ABREV = $request->area_abrev;
            $area->AREA_ORDEN = $request->area_orden;
            $area->AREA_ESTADO = $request->area_estado;
            $area->save();

        } catch (\Throwable $th) {
            return $this->exceptionResponse($th->getMessage());
        }

        return $this->successResponse(new AreasResource($area));
    }

    public function destroy(Request $request)
    {
        try {
            $area = Areas::find($request->area_codigo);
            $area->AREA_ESTADO = 0;
            $area->save();

            return $this->successResponse(new AreasResource($area));
        } catch (\Throwable $th) {
            return $this->exceptionResponse($th->getMessage());
        }
    }
}