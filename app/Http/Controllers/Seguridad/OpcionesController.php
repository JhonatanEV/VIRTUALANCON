<?php

namespace App\Http\Controllers\Seguridad;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Seguridad\Models\Opciones;
use App\Http\Controllers\Seguridad\Resources\OpcionesResource;
use Illuminate\Http\Request;

class OpcionesController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index(Request $request)
    {
        try {
            $opciones = Opciones::search($request)->orderBy('OPCI_ORDER', 'ASC')->get();

            return $this->successResponse(OpcionesResource::collection($opciones));

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
    public function allOpciones(Request $request)
    {
        try {
            $opciones = Opciones::with('subOpciones')
            ->orderBy('OPCI_ORDER', 'ASC')
            ->get();
            $treeData = $this->buildTree($opciones);
            
            return $this->successResponse($treeData);
            
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    private function buildTree($opciones)
    {
        $tree = [];
        
        foreach ($opciones as $opcion) {
            if ($opcion->OPCI_TIPO === 1) {
                $tree[] = $this->formatOpcion($opcion);
            }
        }
        
        return $tree;
    }

    private function formatOpcion($opcion)
    {
        $formattedOpcion = [
            'opci_codigo' => $opcion->OPCI_CODIGO,
            'opci_nombre' => $opcion->OPCI_NOMBRE,
            'opci_estado' => $opcion->OPCI_ESTADO,
            'opci_tipo' => $opcion->OPCI_TIPO,
            'disabled' => $opcion->OPCI_ESTADO === 0,
            'children' => [],
        ];

        foreach ($opcion->subOpciones as $subOpcion) {
            $formattedOpcion['children'][] = $this->formatOpcion($subOpcion);
        }

        return $formattedOpcion;
    }

    public function store(Request $request)
    {
       try {
            $opciones = new Opciones();
            $opciones->OPCI_NOMBRE = $request->opci_nombre;
            $opciones->OPCI_HREF = $request->opci_href;
            $opciones->OPCI_ICON = $request->opci_icon;
            $opciones->OPCI_ORDER = $request->opci_order;
            $opciones->OPCI_TIPO = $request->opci_tipo;
            $opciones->OPCI_SUB_CODIGO = $request->opci_sub_codigo;
            $opciones->OPCI_ESTADO = $request->opci_estado;
            $opciones->save();

            return $this->successResponse();

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function show($id)
    {
        $opciones = Opciones::find($id);
        if (is_null($opciones)) {
            return response()->json(['message' => 'Opciones not found'], 404);
        }
        return response()->json($opciones);
    }

    public function update(Request $request)
    {
        try {
            $opciones = Opciones::find($request->opci_codigo);
            if (is_null($opciones)) {
                return response()->json(['message' => 'Opciones not found'], 404);
            }
            $opciones->OPCI_NOMBRE = $request->opci_nombre;
            $opciones->OPCI_ESTADO = $request->opci_estado;
            $opciones->OPCI_HREF = $request->opci_href;
            $opciones->OPCI_ICON = $request->opci_icon;
            $opciones->OPCI_ORDER = $request->opci_order;
            $opciones->OPCI_TIPO = $request->opci_tipo;
            $opciones->OPCI_SUB_CODIGO = $request->opci_sub_codigo;
            $opciones->save();
            return $this->successResponse();

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        $opciones = Opciones::find($id);
        if (is_null($opciones)) {
            return $this->errorResponse('Opciones not found');
        }
        $opciones->OPCI_ESTADO = 0;
        $opciones->save();
        return $this->successResponse();
    }

    public function getmenus(Request $request)
    {
        $opci_tipo = $request->input('opci_tipo');
        try {
            $opciones = Opciones::where('OPCI_TIPO', $opci_tipo)
            ->where('OPCI_ESTADO', 1)
            ->orderBy('OPCI_ORDER', 'ASC')->get();
            return $this->successResponse(OpcionesResource::collection($opciones));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}