<?php
namespace App\Http\Controllers\Seguridad;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Controllers\Seguridad\Models\Usuarios;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Seguridad\Models\Perfil;
use App\Http\Controllers\Seguridad\Resources\AccesosUserResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class SeguridadController extends ApiController
{ 
    public function login(Request $request)
    {   
        $token = null;
        $decoded = null;
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required'   => 'Ingrese usuario.',
            'password.required'    => 'Ingrese contraseña.',
        ]);

        try {
            $model = Usuarios::where('USUA_USERNAME', Str::upper($request->username))->first();
            if (!$model) {
                throw new \Exception('El usuario no existe.');
            }
            // dd([
            //     'input_password' => $request->password,
            //     'stored_password' => $model->USUA_PASSWORD,
            //     'has_make' => Hash::make($request->password),
            //     'hash_check' => Hash::check($request->password, $model->USUA_PASSWORD),
            // ]);
            $validapass = Hash::check($request->password, $model->USUA_PASSWORD);
            if (!$validapass) {
                throw new \Exception('La contraseña es incorrecta.');
            }

            Session::put('SESS_USUA_CODIGO', $model->USUA_CODIGO);
            Session::put('SESS_PERF_CODIGO', $model->PERF_CODIGO);
            Session::put('SESS_PERS_CODIGO', $model->PERS_CODIGO);
            Session::put('SESS_USUA_USERNAME', $model->USUA_USERNAME);
            Session::put('SESS_USUA_NOMBRES', $model->persona->PERS_NOMBRE);
            Session::put('SESS_NOMBRE_COMPLETO', $model->persona->PERS_NOMCOM);
            session::put('SESS_PERS_DOCUMENTO', $model->persona->PERS_DOCUMENTO);
            session::put('SESS_PERS_CONTR_CODIGO', $model->persona->PERS_CONTR_CODIGO);
            session::put('SESS_PERS_CORREO', $model->persona->PERS_CORREO);
            session::put('SESS_PERS_CELULAR', $model->persona->PERS_CELULAR);

            Session::put('SESS_PERF_NOMBRE', $model->perfil->PERF_NOMBRE);
            Session::put('SESS_USUA_CORREO', $model->USUA_CORREO);
            Session::put('SESS_ACTIVE', 1);

            $accesos = $this->getAccesos($model->PERF_CODIGO);

            $this->navbar2($accesos);

        } catch (\Exception $e) {
            return $this->errorexceptionResponse($e->getMessage());
        }
        
        return response()->json(['accion'=>'success'], 200);
    }

    public function getAccesos($perfCodigo)
    {
        // Primero obtenemos las opciones ordenadas
        $opcionesOrdenadas = DB::table('virtual.OPCIONES')
            ->where('OPCI_ESTADO', 1)
            ->orderBy('OPCI_ORDER', 'ASC')
            ->pluck('OPCI_CODIGO');

        $accesos = Perfil::with(['permisos' => function($query) use ($opcionesOrdenadas) {
            $query->where('PERM_ESTADO', 1)
                ->whereHas('opciones', function($query) {
                    $query->where('OPCI_ESTADO', 1);
                })
                ->with(['opciones' => function($query) {
                    $query->where('OPCI_ESTADO', 1);
                }]);
        }])
        ->where('PERF_CODIGO', $perfCodigo)
        ->first();

        if (!$accesos || !$accesos->permisos) {
            return collect([]);
        }

        // Ordenamos según el orden de las opciones
        $validPermisos = $accesos->permisos
            ->filter(function($permiso) {
                return $permiso->opciones !== null;
            })
            ->sort(function($a, $b) use ($opcionesOrdenadas) {
                $posA = $opcionesOrdenadas->search($a->opciones->OPCI_CODIGO);
                $posB = $opcionesOrdenadas->search($b->opciones->OPCI_CODIGO);
                return $posA - $posB;
            });

        $resourceCollection = AccesosUserResource::collection($validPermisos);

        return $resourceCollection->filter()->values();
    }
    public function navbar2($menuGlobal)
    {
        $USUA_CODIGO = Session::get('SESS_USUA_CODIGO');
        
        if (empty($USUA_CODIGO)) {
            session(['SESS_NAVBAR' => '<h4>Vuelva a iniciar sesión</h4>']);
            return;
        }
    
        $html = '';
        $scriptAcceso = '<script>$(document).ready(function() {';
        $ACCESOS = [];
        
        foreach ($menuGlobal as $valGlobal) {
            //si existe data
            if($valGlobal['opciones'] == null){
                continue;
            }

            if ($valGlobal['opciones']['OPCI_TIPO'] == 1) {
                
                foreach ($menuGlobal as $row_op2) {
                    if ($row_op2['opciones']['OPCI_TIPO'] == 2 && 
                        $row_op2['opciones']['OPCI_SUB_CODIGO'] == $valGlobal['opciones']['OPCI_CODIGO']) {
                        
                        // Contar submenús
                        $Submenu = $menuGlobal->filter(function($cantSubmenu) use ($row_op2) {
                            return $cantSubmenu['opciones']['OPCI_TIPO'] == 3 && 
                                   $cantSubmenu['opciones']['OPCI_SUB_CODIGO'] == $row_op2['OPCI_CODIGO'];
                        })->count();
    
                        if ($Submenu > 0) {
                            $html .= '<li class="has-submenu">
                                <a href="#">                                
                                    <span><i data-feather="grid" class="align-self-center hori-menu-icon"></i>'
                                    . $row_op2['opciones']['OPCI_NOMBRE'] .
                                '</span>
                                </a>
                                <ul class="submenu">';
    
                            foreach ($menuGlobal as $row_op3) {
                                if ($row_op3['opciones']['OPCI_TIPO'] == 3 && 
                                    $row_op3['opciones']['OPCI_SUB_CODIGO'] == $row_op2['opciones']['OPCI_CODIGO']) {
                                    
                                    $contaOpc = $menuGlobal->filter(function($cantidad) use ($row_op3) {
                                        return $cantidad['opciones']['OPCI_TIPO'] == 4 && 
                                               $cantidad['opciones']['OPCI_SUB_CODIGO'] == $row_op3['opciones']['OPCI_CODIGO'];
                                    })->count();
    
                                    if ($contaOpc < 1) {
                                        $html .= '<li><a href="' . url('/') . '/' . $row_op3['opciones']['OPCI_HREF'] . 
                                                '"><i class="ti ti-minus"></i>' . $row_op3['opciones']['OPCI_NOMBRE'] . '</a></li>';
                                    } else {
                                        $html .= '<li class="has-submenu">
                                            <a href="#"><i class="ti ti-minus"></i>' . $row_op3['opciones']['OPCI_NOMBRE'] . '</a>
                                            <ul class="submenu">';
                                        
                                        foreach ($menuGlobal as $row_op4) {
                                            if ($row_op4['opciones']['OPCI_TIPO'] == 4 && 
                                                $row_op4['opciones']['OPCI_SUB_CODIGO'] == $row_op3['opciones']['OPCI_CODIGO']) {
                                                $html .= '<li><a href="' . url('/') . '/' . $row_op4['opciones']['OPCI_HREF'] . 
                                                        '"><i class="ti ti-minus"></i>' . $row_op4['opciones']['OPCI_NOMBRE'] . '</a></li>';
                                            }
                                        }
                                        
                                        $html .= '</ul></li>';
                                    }
    
                                    if ($row_op3['opciones']['OPCI_DIVIDIR'] == 1) {
                                        $html .= '<hr class="hr-dashed hr-menu mt-1 mb-1">';
                                    }
                                }
                            }
    
                            $html .= '</ul></li>';
                        } else {
                            $html .= '<li class="has-submenu">
                                <a href="' . url('/') . '/' . $row_op2['opciones']['OPCI_HREF'] . '">
                                    <span><i data-feather="layers" class="align-self-center hori-menu-icon"></i>'
                                    . $row_op2['opciones']['OPCI_NOMBRE'] .
                                '</span>
                                </a>                               
                            </li>';
                        }
                    }
                }
            }
        }
    
        foreach ($menuGlobal as $objetos) {
            if ($objetos['opciones']['OPCI_TIPO'] == 5) {
                $scriptAcceso .= '$("' . $objetos['opciones']['OPCI_HREF'] . '").removeClass("d-none"); ';
            }
        }
        $scriptAcceso .= '});</script>';
    
        foreach ($menuGlobal as $url) {
            if ($url['opciones']['OPCI_TIPO'] != 5 && !empty($url['opciones']['OPCI_HREF'])) {
                $ACCESOS[] = [$url['opciones']['OPCI_HREF']];
            }
        }
    
        session([
            'SESS_NAVBAR' => $html,
            'SESS_ACCESOS' => $scriptAcceso,
            'SESS_USUA_ACCESOS' => $ACCESOS
        ]);
    }
    public function store(Request $request){
        $model = new Usuarios();
        $model->PERF_CODIGO = 1;
        $model->USUA_USERNAME = Str::upper($request->username);
        $model->USUA_PASSWORD = Usuarios::hashPassword($request->password);
        $model->PERS_CODIGO = 1;
        $model->USUA_FECHING = Carbon::now()->format('Y-m-d H:i:s');
        $model->USUA_ESTADO = 1;
        $model->save();
    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        auth('web')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}