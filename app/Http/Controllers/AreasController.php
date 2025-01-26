<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AreasController extends Controller
{
    public function vistaArea(){
        
        $page_data['header_js'] = array(
        	'plugins/toastr/build/toastr.min.js',
        	'plugins/datatables/jquery.dataTables.min.js',
			'plugins/datatables/dataTables.bootstrap5.min.js',
			'plugins/datatables/dataTables.responsive.min.js',
			'plugins/datatables/responsive.bootstrap4.min.js',
            'plugins/select2/select2.min.js',
			'plugins/jpagination/jpagination.js',
            'js/js_areas.js'

        );
		$page_data['header_css'] = array(
		 	'plugins/toastr/build/toastr.min.css',
		 	'plugins/datatables/dataTables.bootstrap5.min.css',
			'plugins/datatables/responsive.bootstrap4.min.css',
			'plugins/treeview/style.css'
		);

        $page_data['page_directory'] = 'areas';
    	$page_data['page_name'] = 'consulta';
    	$page_data['page_title'] = 'Areas - MDPP';

        return view('index',$page_data);
    }

    public function selectAreas(Request $request){

		$AREA_CODIGO 	= $request->get('AREA_CODIGO');
		$AREA_ESTADO 	= $request->get('AREA_ESTADO');
		$AREA_TIPO 		= $request->get('AREA_TIPO');

		unset($parametros);
    	$parametros[] = array('@ACCION',1);
    	$parametros[] = array('@AREA_CODIGO',$AREA_CODIGO);
    	$parametros[] = array('@AREA_ESTADO',$AREA_ESTADO);
    	$parametros[] = array('@AREA_TIPO',$AREA_TIPO);
		$sql_data = ejec_store_procedure_sql("GENERAL.SP_AREAS",$parametros);
		return json_encode($sql_data);
	}

	public function guardarArea(Request $request){

		$AREA_CODIGO	= $request->post('AREA_CODIGO');
		$AREA_SUB_CODIGO= $request->post('AREA_SUB_CODIGO');
		$AREA_NOMBRE	= $request->post('AREA_NOMBRE');
		$AREA_ABREV		= $request->post('AREA_ABREV');
		$AREA_ORDEN		= $request->post('AREA_ORDEN');
		$AREA_TIPO 		= $request->post('AREA_TIPO');
		$AREA_ESTADO	= 1;

		$ACCION 		= (empty($AREA_CODIGO)) ? 2 : 3; //Insert ó Update 

		$OPERADOR 		= Session::get('SESS_USUA_CODIGO');
		$IP 			= $_SERVER['REMOTE_ADDR'];
		$FECHA 			= date('d-m-Y');
		$FECHA_HORA 	= date('d-m-Y H:i:s');
		$ARRAY = array();

		unset($parametros);
    	$parametros[] = array('@ACCION',$ACCION);
		$parametros[] = array('@AREA_CODIGO',$AREA_CODIGO);
		$parametros[] = array('@AREA_TIPO',$AREA_TIPO);
		$parametros[] = array('@AREA_SUB_CODIGO',$AREA_SUB_CODIGO);
		$parametros[] = array('@AREA_NOMBRE',$AREA_NOMBRE);
		$parametros[] = array('@AREA_ABREV',$AREA_ABREV);
		$parametros[] = array('@AREA_ORDEN ',$AREA_ORDEN);
		$parametros[] = array('@AREA_ESTADO',$AREA_ESTADO);
		$sql_data = ejec_store_procedure_sql("GENERAL.SP_AREAS",$parametros);
		$DB_CODIGO = $sql_data[0]->RESULT;

		if($DB_CODIGO<>0):
			$ARRAY['accion'] = "success";
			$ARRAY['smg']="Se registro correctamente!";
		else:
			$ARRAY['accion'] = "error";
			$ARRAY['smg']="Problema al guardar el registro!";
		endif;
		
		return json_encode($ARRAY);
	}
    public function eliminarArea(Request $request){
        $AREA_CODIGO	= $request->get('AREA_CODIGO');
		$AREA_ESTADO	        = $request->get('AREA_ESTADO');

		$ARRAY = array();

		unset($parametros);
    	$parametros[] = array('@ACCION',4);
		$parametros[] = array('@AREA_CODIGO',$AREA_CODIGO);
		$parametros[] = array('@AREA_ESTADO',$AREA_ESTADO);
		$sql_data = ejec_store_procedure_sql("GENERAL.SP_AREAS",$parametros);

		$ARRAY['accion'] = "success";
		$ARRAY['smg'] = "Se dio de baja correctamente!";

		return json_encode($ARRAY);
    }
	public function selectTemas(Request $request){
		$AREA_CODIGO 	= $request->get('AREA_CODIGO');

		unset($parametros);
    	$parametros[] = array('@ACCION',1);
    	$parametros[] = array('@AREA_CODIGO',$AREA_CODIGO);
		$sql_data = ejec_store_procedure_sql("CITA.SP_TEMAS",$parametros);
		return json_encode($sql_data);
	}
}
