<?php

namespace App\Http\Controllers\Seguridad;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\General\Models\Persona;
use Illuminate\Http\Request;
use App\Http\Controllers\Seguridad\Resources\PersonaResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PersonaController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        try{
            $personas = Persona::all();

            return $this->successResponse(PersonaResponse::collection($personas));

        }catch(\Exception $e){
            return $this->errorResponse('Error en el servidor', $e->getMessage(), 500);
        }
    }

    public function store(Request $request)
    {
        
        try {
            $persona = Persona::where('PERS_DOCUMENTO', $request->pers_documento)->first();
            if($persona){
                return $this->errorResponse('Ya existe una persona con el mismo documento', null, 400);
            }
            DB::beginTransaction();

            $persona = new Persona();
            $persona->PERS_AMATERNO = $request->pers_amaterno;
            $persona->PERS_APATERNO = $request->pers_apaterno;
            #$persona->PERS_CODIGO = $request->pers_codigo;
            $persona->PERS_DIRECCION = $request->pers_direccion;
            $persona->PERS_DOCUMENTO = $request->pers_documento;
            $persona->PERS_ESTADO = 1;
            $persona->PERS_FECNACI = $request->pers_fecnaci;
            $persona->PERS_FOTO = $request->pers_foto;
            $persona->PERS_NOMBRE = $request->pers_nombre;
            $persona->PERS_NOMCOM = $request->pers_apaterno . ' ' . $request->pers_amaterno . ' ' . $request->pers_nombre;
            $persona->PERS_OCUPACION = $request->pers_ocupacion;
            $persona->PERS_OPERADOR = $request->pers_operador;
            $persona->PERS_SEXO = $request->pers_sexo;
            $persona->PERS_TIPODOC = $request->pers_tipodoc;
            $persona->PERS_FECING = Carbon::now();
            $persona->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Error en el servidor', $e->getMessage(), 500);
        }
        return $this->successResponse(new PersonaResponse($persona), 201);
    }

    public function show(Request $request)
    {
        try {
            $persona = Persona::findOrFail($request->pers_codigo);
            
            return $this->successResponse(new PersonaResponse($persona));
        } catch (\Throwable $th) {
            return $this->errorResponse('Error en el servidor', $th->getMessage(), 500);
        }
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $persona = Persona::findOrFail($request->pers_codigo);
            $persona->PERS_AMATERNO = $request->pers_amaterno;
            $persona->PERS_APATERNO = $request->pers_apaterno;
            $persona->PERS_DIRECCION = $request->pers_direccion;
            $persona->PERS_DOCUMENTO = $request->pers_documento;
            $persona->PERS_ESTADO = $request->pers_estado;
            $persona->PERS_FECNACI = $request->pers_fecnaci;
            $persona->PERS_FOTO = $request->pers_foto;
            $persona->PERS_NOMBRE = $request->pers_nombre;
            $persona->PERS_NOMCOM = $request->pers_apaterno . ' ' . $request->pers_amaterno . ' ' . $request->pers_nombre;
            $persona->PERS_OCUPACION = $request->pers_ocupacion;
            $persona->PERS_OPERADOR = $request->pers_operador;
            $persona->PERS_SEXO = $request->pers_sexo;
            $persona->PERS_TIPODOC = $request->pers_tipodoc;
            $persona->save();
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Error en el servidor', $e->getMessage(), 500);
        }
        return $this->successResponse(new PersonaResponse($persona));
    }

    public function destroy($id)
    {
        $persona = Persona::findOrFail($id);
        $persona->PERS_ESTADO = 0;
        $persona->save();
        return $this->successResponse();
    }
}