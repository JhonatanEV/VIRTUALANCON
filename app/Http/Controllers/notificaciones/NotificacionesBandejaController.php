<?php

namespace App\Http\Controllers\notificaciones;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\notificaciones\Models\Bandeja;

class NotificacionesBandejaController extends Controller
{
    public function index(){

        $page_data['header_js'] = array(
            'js/js_notificaciones_bandeja.js'
        );
        $page_data['header_css'] = array();
        $page_data['header_js'] = array(
            'plugins/toastr/build/toastr.min.js',
            'plugins/datatables/jquery.dataTables.min.js',
			'plugins/datatables/dataTables.bootstrap5.min.js',
			'plugins/datatables/dataTables.responsive.min.js',
			'plugins/datatables/responsive.bootstrap4.min.js',
            'js/js_notificaciones_bandeja.js'

        );
		$page_data['header_css'] = array(
		 	'plugins/toastr/build/toastr.min.css',
		 	'plugins/datatables/dataTables.bootstrap5.min.css',
			'plugins/datatables/responsive.bootstrap4.min.css',
		);


        $page_data['page_directory'] = 'notificaciones';
        $page_data['page_name'] = 'bandeja';
        $page_data['page_title'] = 'Notificaciones enviados';
        $page_data['breadcrumbone'] = 'Notificaciones';

        $page_data['breadcrumbone'] = 'Notificaciones';
        $page_data['breadcrumb'] = 'Bandeja';
        $page_data['titulo_principal'] = 'Bandeja';

        return view('index',$page_data);
    }  
    public function selectBandeja(Request $request){
        try{
            $fecha_notificacion = $request->fecha_notificacion;
          
            $bandeja = Bandeja::whereDate('BAND_CREADO', $fecha_notificacion)->get();

            return response()->json(['status' => true ,'data' => $bandeja], 200);

        } catch (\Throwable $th) {
            return response()->json(['status' => false ,'message' => 'Error al crear la bandeja: '.$th->getMessage()], 500);
        } 
    }
}