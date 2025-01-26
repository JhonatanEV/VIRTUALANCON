<?php
namespace App\Http\Controllers\pagalo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReporteIngresosOnlineController extends Controller
{   

    public function __construct()
    {
    }
    public function viewPagosLinea()
    {

        $page_data['header_js'] = array(
			'plugins/datatables/jquery.dataTables.min.js',
			'plugins/datatables/dataTables.bootstrap5.min.js',
			'plugins/datatables/dataTables.responsive.min.js',
            'plugins/datatables/responsive.bootstrap4.min.js',
            'js/js_pago_linea_reporte.js'
		);

        $page_data['header_css'] = array(
        'plugins/datatables/dataTables.bootstrap5.min.css',
        'plugins/datatables/buttons.bootstrap5.min.css',
        'plugins/datatables/responsive.bootstrap4.min.css'
        );
        $page_data['titulo_principal'] = 'Reporte de Pagos en Línea de Tributos Predial y Arbitrios';
        $page_data['page_directory'] = 'pagalo.reportes';
        $page_data['page_name'] = 'reporte_online';
        $page_data['page_title'] = 'Pago en línea';
        $page_data['breadcrumbone'] = 'Págalo Ancón';
        $page_data['breadcrumb'] = 'Pago en Línea de Tributos';
        return view('index',$page_data);
    }
    public function consultaPagosOnline(Request $request){

        try {
            unset($parametros);
            $parametros[] = array('@pFechaDesde',$request->fec_ini);
            $parametros[] = array('@pFechaHasta',$request->fec_hasta);
            $parametros[] = array('@pNroCaja','PO');
            $AllEcuenta = ejec_store_procedure_sql_sims("DBO.sp_pagos_online_ingresos_2024",$parametros);

            $agrupado = [];

            foreach ($AllEcuenta as $registro) {
                $registro->TOTAL = (float) $registro->TOTAL;
                
                $codigo_contri = $registro->CODIGO_CONTRI;
                if (isset($agrupado[$codigo_contri])) {
                    $agrupado[$codigo_contri]['TOTAL'] += $registro->TOTAL;
                    
                } else {
                    $agrupado[$codigo_contri] = [
                        'CODIGO_CONTRI' => $registro->CODIGO_CONTRI,
                        'RAZON_SOCIAL' => $registro->RAZON_SOCIAL,
                        'FECHA_INGRESO' => $registro->FECHA_INGRESO,
                        'TOTAL' => $registro->TOTAL
                    ];
                }
            }
            $agrupado = array_values($agrupado);
            return response()->json(['data' => $agrupado]);

        } catch (\Throwable $th) {
            return response()->json(['data' => [],'error' => $th->getMessage()]);
        }

        
    }
}