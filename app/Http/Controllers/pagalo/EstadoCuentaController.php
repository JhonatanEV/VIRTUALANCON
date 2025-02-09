<?php
namespace App\Http\Controllers\pagalo;
use App\Http\Controllers\Controller;
use App\Http\Controllers\pagalo\Repositories\EstadoCuentaRespository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Pagalo\Resources\CuentaResource;
class EstadoCuentaController extends Controller
{   
    public function __construct()
    {

    }
    public function viewEcuenta()
    {

        $page_data['header_js'] = array(
			'plugins/datatables/jquery.dataTables.min.js',
			'plugins/datatables/dataTables.bootstrap5.min.js',
			'plugins/datatables/dataTables.responsive.min.js',
            'plugins/datatables/responsive.bootstrap4.min.js',
			'plugins/datatables/dataTables.rowGroup.min.js',
			'plugins/datatables/buttons.colVis.min.js',
            'plugins/multicheck/jquery.multi-select.js',
            'js/js_pagalo_estado_cuenta.js'
		);

        $page_data['header_css'] = array(
        'plugins/datatables/dataTables.bootstrap5.min.css',
        'plugins/datatables/buttons.bootstrap5.min.css',
        'plugins/datatables/responsive.bootstrap4.min.css',
        'plugins/multicheck/example-styles.css'
        );

        $codigo = Session::get('SESS_CODIGO_CONTRI'); #'0000255';#0000255 Session::get('SESS_PERS_DOCUMENTO')
  
        $page_data['titulo_principal'] = 'Estado de cuenta';
        $page_data['page_directory'] = 'pagalo.estado_cuenta';
        $page_data['page_name'] = 'index';
        $page_data['page_title'] = 'Estado de cuenta';
        $page_data['breadcrumbone'] = 'Págalo Ancón';
        $page_data['breadcrumb'] = 'Estado de cuenta';
        #return view('layouts.app', compact('page_data'));
        return view('index',$page_data);
    }
    public function getEcuenta(Request $request)
    {
        $anio_desde = '1995';
        $anio_hasta = date('Y');
        $codigo = Session::get('SESS_CODIGO_CONTRI');

        try {
        
            $codigo = Session::get('SESS_PERS_CONTR_CODIGO');
            $codigo = str_pad($codigo, 10, "0", STR_PAD_LEFT);

            $estadoCuentaRespository = new EstadoCuentaRespository();
            $arbEcuenta = $estadoCuentaRespository->getData($codigo);

            return response()->json(
                [
                    'data' => $arbEcuenta,
                    'message' => 'Estado de cuenta obtenido correctamente'
                ]
                , 200);
            
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}