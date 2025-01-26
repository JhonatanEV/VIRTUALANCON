<?php

namespace App\Http\Controllers\Api\Seguridad;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Api\Seguridad\Models\Usuarios;
use App\Http\Controllers\Api\Seguridad\Models\Accesos;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Seguridad\Resources\UsuariosResponse;
use App\Http\Controllers\Api\Seguridad\Resources\AccesosUsuariosResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UsuariosController extends ApiController
{
    function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index(Request $request)
    {
        try {
            $usuarios = Usuarios::search($request)->orderBy('USUA_CODIGO', 'DESC')
            ->paginate(($request->per_page) ? $request->per_page : 10);

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

            $usuario = new Usuarios();
            $usuario->PERS_CODIGO = $request->pers_codigo;
            $usuario->PERF_CODIGO = $request->perf_codigo;
            $usuario->USUA_USERNAME = $request->usua_username;
            $usuario->USUA_PASSWORD = Usuarios::hashPassword($request->usua_username);
            $usuario->USUA_ESTADO = $request->usua_estado;
            $usuario->USUA_FECHING = Carbon::now();
            $usuario->save();

            $usuario->assignRolesAndMenus();

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

    public function activar($id)
    {
        try {
            $usuario = Usuarios::findOrFail($id);
        
            $usuario->USUA_ESTADO = 1;
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