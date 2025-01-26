<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Url;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Session;

class AdministracionController extends Controller
{
   public function vistaActualizarDatos(){

        $page_data['header_js'] = array(
            'js/js_actualizar_datos.js',
            'plugins/toastr/build/toastr.min.js',
            'js/tabledit/bootstable.js'
        );
        $page_data['header_css'] = array('plugins/toastr/build/toastr.min.css');

        $PERS_CODIGO = Session::get('SESS_PERS_CODIGO');

        $dbContactos = Cache::remember('DB_CONTACTOS', 600, function () {
            unset($parametros);
            $parametros[] = array('@ACCION',1);
            $parametros[] = array('@PERS_CODIGO',$PERS_CODIGO);
            return ejec_store_procedure_sql("GENERAL.SP_CONTACTOS",$parametros);
        });
        
        $dbTipoContactos = Cache::remember('DB_TIPO_CONTACTOS', 600, function () {
            unset($parametros);
            $parametros[] = array('@ACCION',1);
            return ejec_store_procedure_sql("GENERAL.SP_TIPO_CONTACTOS",$parametros);
        });
      

        $page_data['dbContactos'] = json_encode($dbContactos);
        $page_data['dbTipoContactos'] = json_encode($dbTipoContactos);

        $page_data['page_directory'] = 'administracion';
        $page_data['page_name'] = 'actualizar-datos';
        $page_data['page_title'] = 'Actualizacion de datos';
        return view('index',$page_data);
   }

   public function vistaHorarios(){
        $page_data['header_js'] = array( 
            'plugins/datepicker/jquery-ui.js',
            'plugins/select2/select2.min.js',
            'plugins/moment/moment.js',
            'js/js_horarios.js'
        );
        $page_data['header_css'] = array('plugins/datepicker/jquery-ui.css','plugins/select2/select2.min.css');

        unset($parametros);
        $parametros[] = array('@ACCION',1);
        $parametros[] = array('@AREA_ESTADO',1);
        $dbAreas = ejec_store_procedure_sql("GENERAL.SP_AREAS",$parametros);
       
        $page_data['dbAreas'] = json_encode($dbAreas);


        $page_data['page_directory'] = 'administracion';
        $page_data['page_name'] = 'horarios';
        $page_data['page_title'] = 'Horarios de cita';

        return view('index',$page_data);
   }

   public function selectHorarios(Request $request ){
        $HORA_FECHA = $request->get("HORA_FECHA");
        $AREA_CODIGO = $request->get("AREA_CODIGO");
      

        #$HORA_FECHA = explode('/', $HORA_FECHA);
        #$HORA_FECHA = $HORA_FECHA[2].'-'.$HORA_FECHA[1].'-'.$HORA_FECHA['0'];

		unset($parametros);
		$parametros[] = array('@ACCION',1);
		$parametros[] = array('@HORA_FECHA',$HORA_FECHA);
        $parametros[] = array('@AREA_CODIGO',$AREA_CODIGO);
		$RESULT = ejec_store_procedure_sql("CITA.SP_HORARIOS",$parametros);
		return json_encode($RESULT);
   }
   public function selectHorariosExistentes(Request $request){
        $HORA_FECHA = $request->post('HORA_FECHA');
        unset($parametros);
		$parametros[] = array('@ACCION',12);
		#$parametros[] = array('@HORA_FECHA',$HORA_FECHA);
		$RESULT = ejec_store_procedure_sql("CITA.SP_HORARIOS",$parametros);
		return json_encode($RESULT);

   }

   public function validarPersona(Request $request){
        $TIPO = $request->post('TIPO');
        $DOCUMENTO = $request->post('DOCUMENTO');
        
        $cacheKey = 'pide_sunat_api_' . $TIPO . '_' . $DOCUMENTO.'_' . date('YmdHis');
        $cacheTime = 3600; //1H tiempo de caché en segundos
    
        $PIDE = Cache::remember($cacheKey, $cacheTime, function () use ($TIPO, $DOCUMENTO) {
            $resultado =ejec_pide_sunat_api($TIPO,$DOCUMENTO);
            return $resultado;
        });

        #$PIDE = ejec_pide_sunat_api($TIPO,$DOCUMENTO);
        $PIDE = json_decode($PIDE,TRUE);
       
        if($PIDE['DATA']['STATUS']==1){
			$FOTO 		= $PIDE['DATA']['FOTO'];

			if(!empty($FOTO)):
				$img = explode(',', $FOTO)[1];
				$imageData = base64_decode($img);   
				$FOTO = $DOCUMENTO.'.png';
				$filePath = public_path('img_datos') . '/'.$FOTO;
				file_put_contents($filePath, $imageData);
			endif;
		}

        $ARRAY = array();
        $ARRAY['DATA']['DOCUMENTO']=$PIDE['DATA']['DOCUMENTO'];
        $ARRAY['DATA']['NOMBRE_COMPLETO']=$PIDE['DATA']['NOMBRE_COMPLETO'];
        $ARRAY['DATA']['APE_PATERNO']=$PIDE['DATA']['APE_PATERNO'];
        $ARRAY['DATA']['APE_MATERNO']=$PIDE['DATA']['APE_MATERNO'];
        $ARRAY['DATA']['DIRECCION']=$PIDE['DATA']['DIRECCION'];        
        return $ARRAY;
    }
}
