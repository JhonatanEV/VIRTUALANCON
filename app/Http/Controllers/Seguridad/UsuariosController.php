<?php

namespace App\Http\Controllers\Seguridad;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\General\Models\Persona;
use App\Http\Controllers\Seguridad\Models\Usuarios;
use App\Http\Controllers\Seguridad\Models\Accesos;
use Illuminate\Http\Request;
use App\Http\Controllers\Seguridad\Resources\UsuariosResponse;
use App\Http\Controllers\Seguridad\Resources\AccesosUsuariosResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UsuariosController extends ApiController
{
    function __construct()
    {
    }
    public function index(Request $request)
    {
        try {
            $usuarios = Usuarios::search($request)->orderBy('USUA_CODIGO', 'DESC')
            ->with('persona')
            ->with('perfil')
            ->get();
            #return $this->successResponse($usuarios);
            return UsuariosResponse::collection($usuarios);
        } catch (\Throwable $th) {
            return $this->errorexceptionResponse($th->getMessage());
        }
    }

    public function show($id)
    {
        
        try {
            $usuario = Usuarios::findOrFail($id);

        return $this->successResponse($usuario);
        } catch (\Throwable $th) {
            return $this->errorexceptionResponse($th->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->json()->all();

            $usuario = Usuarios::where('USUA_CODIGO',$data['usua_codigo'])->first();
            if(!$usuario){
                $usuario = new Usuarios();
            }

            $persona = Persona::where('PERS_CODIGO',$data['pers_codigo'])->first();
            if(!$persona){
			    $persona = new Persona();
            }

			if(!empty($data['pers_contr_codigo'])):
				$codigo = str_pad($data['pers_contr_codigo'], 7, "0", STR_PAD_LEFT);
				$persona->PERS_CONTR_CODIGO = $codigo;
			endif;
            
            $OPERADOR = $_SERVER["SERVER_ADDR"];

			$persona->PERS_DOCUMENTO = $data['pers_documento'];
			$persona->PERS_ESTADO = 1;
			$persona->PERS_NOMCOM = $data['pers_nombre'];
			$persona->PERS_CORREO = $data['pers_correo'];
			$persona->PERS_CELULAR = $data['pers_celular'];
			$persona->PERS_OPERADOR = $OPERADOR;
			$persona->PERS_TIPODOC = $data['pers_tipodoc'];
			$persona->PERS_FECING = Carbon::now();
			$persona->save();

            $usuario->PERS_CODIGO = $data['pers_codigo'];
            $usuario->PERF_CODIGO = $data['perf_codigo'];
            $usuario->USUA_USERNAME = $data['usua_username'];
            $usuario->USUA_PASSWORD = ($data['usua_password'] && !empty($data['usua_password'])) ? Usuarios::hashPassword($data['usua_password']) : $usuario->USUA_PASSWORD;
            $usuario->USUA_ESTADO = $data['usua_estado'];
            $usuario->USUA_FECHING = Carbon::now();
            $usuario->save();

            DB::commit();

            return $this->successResponse($usuario, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorexceptionResponse($th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {   
        try {
            $password = null;
            if($request->user_password && !empty($request->user_password)){
                $password = Usuarios::hashPassword($request->user_password);
            }
            $usuario = Usuarios::findOrFail($request->usua_codigo);
            $usuario->PERS_CODIGO = $request->pers_codigo;
            $usuario->PERF_CODIGO = $request->perf_codigo;
            $usuario->USUA_USERNAME = $request->usua_username;
            $usuario->USUA_PASSWORD = $password ?? $usuario->USUA_PASSWORD;
            $usuario->USUA_ESTADO = $request->usua_estado;
            $usuario->save();

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorexceptionResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $usuario = Usuarios::findOrFail($id);
        
            $usuario->USUA_ESTADO = 0;
            $usuario->save();

            return $this->successResponse();

        } catch (\Throwable $th) {
            return $this->errorexceptionResponse($th->getMessage());
        }
    }

    public function activar(Request $request)
    {
        try {
            $data = $request->json()->all();
            $id = $data['usua_codigo'];

            $usuario = Usuarios::findOrFail($id);
        
            $usuario->USUA_ESTADO = $data['usua_estado'];
            $usuario->save();

            return $this->successResponse();

        } catch (\Throwable $th) {
            return $this->errorexceptionResponse($th->getMessage());
        }
    }
    public function accesosUsuario($id)
    {
        try {
            $usuario = Usuarios::findOrFail($id);

            return $this->successResponse(AccesosUsuariosResource::collection($usuario->accesos));
        } catch (\Throwable $th) {
            return $this->errorexceptionResponse($th->getMessage());
        }
    }
    public function grabarAccesoUsuario(Request $request, $id){
	}
}