<?php
namespace App\Http\Controllers\pagalo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        /*
            execute DBO.SP_RENTAS_LISTADO_CTACTE   
            @lsp_facodcontr = '0119439', 
            @lsp_facodtribu = '', 
            @lsp_faanotribui = '1995', 
            @lsp_faanotribuf = '2024',
            @lsp_faanexoi = '0000', 
            @lsp_faanexof = '9999', 
            @lsp_faestrecib = 'P', 
            @lsp_fatipo = '3', 
            @lsp_nocon = 'SUCESION ELLIOTT DAVALOS MAXI INDALECIO', 
            @lsp_notam = 'PEQUEÑO   ', 
            @lsp_faestado = 'PENDIENTE', 
            @ldt_fechaact = '2024-18-06 00:00:00.000'
        */
        #$anio_desde = $request->anno_desde;
        #$anio_hasta = $request->anno_hasta;

        $anio_desde = '1995';
        $anio_hasta = date('Y');
        $codigo = Session::get('SESS_CODIGO_CONTRI');

        try {
        
            #unset($parametros);
            #$parametros[] = array('@lsp_facodcontr',$codigo);
            #$parametros[] = array('@lsp_facodtribu','');
            #$parametros[] = array('@lsp_faanotribui',$anio_desde);
            #$parametros[] = array('@lsp_faanotribuf',$anio_hasta);
            #$parametros[] = array('@lsp_faanexoi','0000');
            #$parametros[] = array('@lsp_faanexof','9999');
            #$parametros[] = array('@lsp_faestrecib','P');
            #$parametros[] = array('@lsp_fatipo','3');
            #$parametros[] = array('@lsp_nocon','');
            #$parametros[] = array('@lsp_notam','');
            #$parametros[] = array('@lsp_faestado','PENDIENTE');
            #$parametros[] = array('@ldt_fechaact',date('d-m-Y H:i:s'));
            #$arbEcuenta = ejec_store_procedure_sql_sims("DBO.SP_RENTAS_LISTADO_CTACTE",$parametros);
            
            unset($parametros);
            $parametros[] = array('@pfacodcontr',$codigo);
            $arbEcuenta = ejec_store_procedure_sql_sims("DBO.SP_CTACTE_ONLINE_2024",$parametros);

            return response()->json($arbEcuenta, 200);
            
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}