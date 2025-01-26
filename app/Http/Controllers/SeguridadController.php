<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Url;
use Illuminate\Support\Facades\DB;
use Session;

class SeguridadController extends Controller
{
    public function __construct()
    {
        #$this->middleware('auth');
    }
    
    public function opciones(){
        
        $page_data = ['page_title'=>'Sistema web'];
        $page_data['header_js'] = array(
        	'plugins/toastr/build/toastr.min.js',
        	'plugins/datatables/jquery.dataTables.min.js',
			'plugins/datatables/dataTables.bootstrap5.min.js',
			'plugins/datatables/dataTables.responsive.min.js',
			'plugins/datatables/responsive.bootstrap4.min.js',
			'plugins/treeview/jstree.min.js',
			'plugins/treeview/jquery.treeview.init.js',
			'js/js_opciones.js'
        );
		$page_data['header_css'] = array(
		 	'plugins/toastr/build/toastr.min.css',
		 	'plugins/datatables/dataTables.bootstrap5.min.css',
			'plugins/datatables/responsive.bootstrap4.min.css',
			'plugins/treeview/style.css'
		);

        $page_data['page_directory'] = 'seguridad';
    	$page_data['page_name'] = 'opciones';
    	$page_data['page_title'] = 'Opciones';

        return view('index',$page_data);
    }

    public function selectOpciones(){
	
        unset($parametros);
        $parametros[] = array('@ACCION',2);
        $parametros[] = array('@QUERY','');
        $dbResult = ejec_store_procedure_sql("ACCESOS.SP_OPCIONES",$parametros);
		echo json_encode($dbResult);
	}

    public function selectCmbMenuOpciones(Request $request){
		$OPCI_TIPO = $request->get('OPCI_TIPO');
		$params = ' ';
		if($OPCI_TIPO==2){
			$params = ' WHERE A.OPCI_TIPO=1';
		}else if($OPCI_TIPO==3){
			$params = ' WHERE A.OPCI_TIPO=2';
		}else if($OPCI_TIPO==4){
			$params = ' WHERE A.OPCI_TIPO=3';
		}
		
        unset($parametros);
        $parametros[] = array('@ACCION',2);
        $parametros[] = array('@QUERY',$params);
        $dbResult = ejec_store_procedure_sql("ACCESOS.SP_OPCIONES",$parametros);
		echo json_encode($dbResult);
	}

    public function editarOpciones(Request $request){
		$OPCI_CODIGO = $request->get('OPCI_CODIGO');

		$params = " WHERE A.OPCI_CODIGO=".$OPCI_CODIGO;
        
	    unset($parametros);
        $parametros[] = array('@ACCION',2);
        $parametros[] = array('@QUERY',$params);
        $dbResult = ejec_store_procedure_sql("ACCESOS.SP_OPCIONES",$parametros);

		echo json_encode($dbResult);
	}

    public function eliminarOpcion(Request $request){

        $OPCI_CODIGO	= $request->get("OPCI_CODIGO");
		$OPCI_ESTADO	= $request->get("OPCI_ESTADO");

        unset($parametros);
        $parametros[] = array('@ACCION',5);
        $parametros[] = array('@OPCI_CODIGO',$OPCI_CODIGO);
        $parametros[] = array('@OPCI_ESTADO',$OPCI_ESTADO);
        $dbResult = ejec_store_procedure_sql("ACCESOS.SP_OPCIONES",$parametros);
        
        $array = array();
		if(!empty($dbResult)) {
			$array['accion'] = 'success';
	    	$array['smg'] = 'Se guardó los cambios correctamente!';
		}else{
			$array['accion'] = 'error';
    		$array['smg'] = 'Problema al momento de realizar los cambios';
		}
	    	
	    echo json_encode($array);
    }

    public function guardarOpciones(Request $request){
		$OPCI_CODIGO	    = $request->post("OPCI_CODIGO");
		$OPCI_TIPO		    = $request->post("OPCI_TIPO");
		$OPCI_SUB_CODIGO    = $request->post("OPCI_SUB_CODIGO");
		$OPCI_NOMBRE	    = $request->post("OPCI_NOMBRE");
		$OPCI_SUB_NOMBRE    = $request->post("OPCI_SUB_NOMBRE");
		$OPCI_ICON		    = $request->post("OPCI_ICON");
		$OPCI_HREF		    = $request->post("OPCI_HREF");
		$OPCI_ICON_NOTIFICA	= $request->post("OPCI_ICON_NOTIFICA");
		$OPCI_ORDER		    = $request->post("OPCI_ORDER");
		$OPCI_ESTADO	    = $request->post("OPCI_ESTADO");
        $ACCION 		= (empty($OPCI_CODIGO)) ? 3 : 4; #I:U

		$ESTACION 		= $_SERVER["SERVER_ADDR"];
		$OPERADOR 		= Session::get('SESS_USUA_CODIGO');
		
        $parametros[] = array('@ACCION',$ACCION);
        $parametros[] = array('@OPCI_CODIGO',$OPCI_CODIGO);
        $parametros[] = array('@OPCI_TIPO',$OPCI_TIPO);
        $parametros[] = array('@OPCI_SUB_CODIGO',$OPCI_SUB_CODIGO);
        $parametros[] = array('@OPCI_NOMBRE', ucwords($OPCI_NOMBRE));
        $parametros[] = array('@OPCI_SUB_NOMBRE', ucwords($OPCI_SUB_NOMBRE));
        $parametros[] = array('@OPCI_ICON', $OPCI_ICON);
        $parametros[] = array('@OPCI_HREF', $OPCI_HREF);
        $parametros[] = array('@OPCI_ICON_NOTIFICA',$OPCI_ICON_NOTIFICA);
        $parametros[] = array('@OPCI_ORDER',  $OPCI_ORDER);
        $parametros[] = array('@OPCI_ESTADO', $OPCI_ESTADO);
    	$dbResult = ejec_store_procedure_sql("ACCESOS.SP_OPCIONES",$parametros);
	
		$array = array();
		if(!empty($dbResult)) {
			$array['accion'] = 'success';
	    	$array['smg'] = 'Se guardó correctamente!';
		}else{
			$array['accion'] = 'error';
    		$array['smg'] = 'Problema al momento de realizar los cambios';
		}
	    	
	    echo json_encode($array);

	}

    public function roles(){
        
        $page_data = ['page_title'=>'Sistema web'];
        $page_data['header_js'] = array(
        	'plugins/toastr/build/toastr.min.js',
        	'plugins/datatables/jquery.dataTables.min.js',
			'plugins/datatables/dataTables.bootstrap5.min.js',
			'plugins/datatables/dataTables.responsive.min.js',
			'plugins/datatables/responsive.bootstrap4.min.js',
			'plugins/treeview/jstree.min.js',
			'plugins/treeview/jquery.treeview.init.js',
			'js/js_roles.js'

        );
		$page_data['header_css'] = array(
		 	'plugins/toastr/build/toastr.min.css',
		 	'plugins/datatables/dataTables.bootstrap5.min.css',
			'plugins/datatables/responsive.bootstrap4.min.css',
			'plugins/treeview/style.css'
		);

        $page_data['page_directory'] = 'seguridad';
    	$page_data['page_name'] = 'roles';
    	$page_data['page_title'] = 'Roles';

        return view('index',$page_data);
    }

    public function selectRoles(Request $request){
		$PERF_CODIGO = $request->get('PERF_CODIGO');

		unset($parametros);
        $parametros[] = array('@ACCION',1);
        $parametros[] = array('@PERF_CODIGO',$PERF_CODIGO);
        $dbResult = ejec_store_procedure_sql("ACCESOS.SP_ROLES",$parametros);
		echo json_encode($dbResult);
	}

    public function eliminarRoles(Request $request){
        $PERF_CODIGO = $request->get('PERF_CODIGO');
        $PERF_ESTADO = $request->get('PERF_ESTADO');

		unset($parametros);
        $parametros[] = array('@ACCION',4);
        $parametros[] = array('@PERF_CODIGO',$PERF_CODIGO);
        $parametros[] = array('@PERF_ESTADO',$PERF_ESTADO);
        $dbResult = ejec_store_procedure_sql("ACCESOS.SP_ROLES",$parametros);

        $array = array();
		if(!empty($dbResult)) {
			$array['accion'] = 'success';
	    	$array['smg'] = 'Se guardó los cambios correctamente!';
		}else{
			$array['accion'] = 'error';
    		$array['smg'] = 'Problema al momento de realizar los cambios';
		}
	    	
	    echo json_encode($array);
    }
    public function selectLeyendasOpcion(Request $request){
        $OPCI_TIPO 		= $request->get("OPCI_TIPO");
		$PERF_CODIGO 	= $request->get("PERF_CODIGO");

        unset($parametros);
        $parametros[] = array('@ACCION',6);
        $parametros[] = array('@PERF_CODIGO',$PERF_CODIGO);
        $parametros[] = array('@OPCI_TIPO',$OPCI_TIPO);
        $dbResult = ejec_store_procedure_sql("ACCESOS.SP_OPCIONES",$parametros);
        echo json_encode($dbResult);
    }

	public function grabarRoles(Request $request){
		$PERF_CODIGO	= $request->post("PERF_CODIGO");
		$PERF_NOMBRE	= $request->post("PERF_NOMBRE");
		$PERF_NC_NOMBRE	= $request->post("PERF_NC_NOMBRE");
		$PERF_ESTADO	= $request->post("PERF_ESTADO");
		$ACCION 		= (empty($PERF_CODIGO)) ? 2 : 3; #I:U
		
		unset($parametros);
        $parametros[] = array('@ACCION',$ACCION);
        $parametros[] = array('@PERF_CODIGO',$PERF_CODIGO);
        $parametros[] = array('@PERF_NOMBRE',strtoupper($PERF_NOMBRE));
		$parametros[] = array('@PERF_NC_NOMBRE',strtoupper($PERF_NC_NOMBRE));
		$parametros[] = array('@PERF_ESTADO',$PERF_ESTADO);
        $dbResult = ejec_store_procedure_sql("ACCESOS.SP_ROLES",$parametros);

		$array = array();
		if($dbResult[0]->RESULT<>0) {
			$array['accion'] = 'success';
	    	$array['smg'] = 'Se guardó correctamente!';
		}else{
			$array['accion'] = 'error';
    		$array['smg'] = 'Ocurrio un problema!';
		}
	    	
	    echo json_encode($array);
	}
	
    public function selectLeyendasSubOpcion(Request $request){
        $OPCI_CODIGO 	= $request->get("OPCI_CODIGO");
		$PERF_CODIGO 	= $request->get("PERF_CODIGO");

        unset($parametros);
        $parametros[] = array('@ACCION',6);
        $parametros[] = array('@OPCI_SUB_CODIGO',$OPCI_CODIGO);
        $parametros[] = array('@PERF_CODIGO',$PERF_CODIGO);
        $dbResult = ejec_store_procedure_sql("ACCESOS.SP_OPCIONES",$parametros);
        
        $html ='';
		foreach ($dbResult as $value) {
			$checked='';
			if($value->MARCA==1):
				$checked='checked';
			endif;
			
			$success='success';
			$estado='&#x2713;';
			if($value->OPCI_ESTADO==0):
				$estado='&#10006;';
				$success='danger';
			endif;

			$html .='<details class="mb-1">
                    <summary> 
                			<input type="checkbox" '.$checked.' onclick="grabarPermiso('.$value->OPCI_CODIGO.','.$PERF_CODIGO.',this.checked);"  />
                			<span>'.$value->OPCI_NOMBRE.'</span>
                			<span class="badge badge-soft-'.$success.' fw-bold" style="float:right;">'.$estado.'</span>
                    </summary>';
                   
                    unset($parametros);
                    $parametros[] = array('@ACCION',6);
                    $parametros[] = array('@OPCI_SUB_CODIGO',$value->OPCI_CODIGO);
                    $parametros[] = array('@PERF_CODIGO',$PERF_CODIGO);
                    $query_op = ejec_store_procedure_sql("ACCESOS.SP_OPCIONES",$parametros);

	                foreach ($query_op as $value_op) {
								$checked='';
								if($value_op->MARCA==1):
									$checked='checked';
								endif;
								
								$success='success';
								$estado='&#x2713;';
								if($value_op->OPCI_ESTADO==0):
									$estado='&#10006;';
									$success='danger';
								endif;

								unset($parametros);
								$parametros[] = array('@ACCION',6);
								$parametros[] = array('@OPCI_SUB_CODIGO',$value_op->OPCI_CODIGO);
								$parametros[] = array('@PERF_CODIGO',$PERF_CODIGO);
								$query_op3 = ejec_store_procedure_sql("ACCESOS.SP_OPCIONES",$parametros);

								if(count($query_op3)>0):
									$html .='<details class="mb-1 p-1">
												<summary class="bg-soft-blue">
													<input type="checkbox" '.$checked.' onclick="grabarPermiso('.$value_op->OPCI_CODIGO.','.$PERF_CODIGO.',this.checked);"  />
													<span>'.$value_op->OPCI_NOMBRE.'</span>
													<span class="badge badge-soft-'.$success.' fw-bold" style="float:right;">'.$estado.'</span>';
										$html .='</summary>';

										foreach ($query_op3 as $value_op3):
											$checked3='';
											if($value_op3->MARCA==1):
												$checked3='checked';
											endif;
											$html .='<p class="mb-1 bg-soft-danger"> <input type="checkbox" '.$checked3.' 
												onclick="grabarPermiso('.$value_op3->OPCI_CODIGO.','.$PERF_CODIGO.',this.checked);" /> '.$value_op3->OPCI_NOMBRE.' </p>';
										endforeach;
										$html .='</details>';
								else:
									$checked='';
									if($value_op->MARCA==1):
										$checked='checked';
									endif;
									$html .='<p class="mb-1 bg-soft-blue"> <input type="checkbox" '.$checked.' onclick="grabarPermiso('.$value_op->OPCI_CODIGO.','.$PERF_CODIGO.',this.checked);" /> '.$value_op->OPCI_NOMBRE.' </p>';
								endif;
						

						
		            }

            $html .='</details>';
        }
		echo $html;

    }

    public function grabarOpcionRoles(Request $request){
        $OPCI_CODIGO	= $request->get("OPCI_CODIGO");
		$PERF_CODIGO	= $request->get("PERF_CODIGO");
		$CHECKED		= $request->get("CHECKED");

		#$RESULT = $this->db->query("SELECT * FROM ACCESOS.PERMISOS WHERE OPCI_CODIGO='$OPCI_CODIGO' AND PERF_CODIGO='$PERF_CODIGO' ")->num_rows();
        unset($parametros);
        $parametros[] = array('@ACCION',1);
        $parametros[] = array('@OPCI_CODIGO',$OPCI_CODIGO);
        $parametros[] = array('@PERF_CODIGO',$PERF_CODIGO);
        $dbResult = ejec_store_procedure_sql("ACCESOS.SP_PERMISOS",$parametros);

        $ACCION = count($dbResult)>0 ? 3 : 2; #U:I
        
        unset($parametros);
        $parametros[] = array('@ACCION',$ACCION);
        $parametros[] = array('@PERF_CODIGO',$PERF_CODIGO);
		$parametros[] = array('@OPCI_CODIGO',$OPCI_CODIGO);
        $parametros[] = array('@PERM_ESTADO',$CHECKED);
        $dbResult = ejec_store_procedure_sql("ACCESOS.SP_PERMISOS",$parametros);

		$array = array();
		if(!empty($dbResult)) {
			$array['accion'] = 'success';
	    	$array['smg'] = 'Se guardó correctamente!';
		}else{
			$array['accion'] = 'error';
    		$array['smg'] = 'Ocurrio un problema!';
		}
	    	
	    echo json_encode($array);
    }

    public function personas(){
        $page_data['header_js'] = array(
        	'plugins/toastr/build/toastr.min.js',
        	'plugins/datatables/jquery.dataTables.min.js',
			'plugins/datatables/dataTables.bootstrap5.min.js',
			'plugins/datatables/dataTables.responsive.min.js',
			'plugins/datatables/responsive.bootstrap4.min.js',
			'plugins/treeview/jstree.min.js',
			'plugins/treeview/jquery.treeview.init.js',
			'js/js_personas.js'

        );
		$page_data['header_css'] = array(
		 	'plugins/toastr/build/toastr.min.css',
		 	'plugins/datatables/dataTables.bootstrap5.min.css',
			'plugins/datatables/responsive.bootstrap4.min.css',
			'plugins/treeview/style.css'
		);

        $page_data['page_directory'] = 'seguridad';
    	$page_data['page_name'] = 'personas';
    	$page_data['page_title'] = 'Personas';
        return view('index',$page_data);
    }

    public function selectPersonas(Request $request){
        $PERS_CODIGO = $request->get('PERS_CODIGO');

		unset($parametros);
        $parametros[] = array('@ACCION',1);
        $parametros[] = array('@PERS_CODIGO',$PERS_CODIGO);
        $dbResult = ejec_store_procedure_sql("GENERAL.SP_PERSONA",$parametros);
		echo json_encode($dbResult);
    }
	
    public function grabarPersona(Request $request){
        $PERS_CODIGO	= $request->post('PERS_CODIGO');
		$PERS_TIPODOC	= $request->post('PERS_TIPODOC');
		$PERS_DOCUMENTO	= $request->post('PERS_DOCUMENTO');
		$PERS_APATERNO	= strtoupper($request->post('PERS_APATERNO'));
		$PERS_AMATERNO	= strtoupper($request->post('PERS_AMATERNO'));
		$PERS_NOMBRE	= strtoupper($request->post('PERS_NOMBRE'));
		$PERS_SEXO		= $request->post('PERS_SEXO');
		$PERS_FECNACI	= $request->post('PERS_FECNACI');
		$PERS_DIRECCION	= $request->post('PERS_DIRECCION');
		$PERS_OCUPACION	= $request->post('PERS_OCUPACION');
        $PERS_NOMCOM 	= $PERS_NOMBRE.' '.$PERS_APATERNO.' '.$PERS_AMATERNO;
        $IP 			= $_SERVER['REMOTE_ADDR'];
        $OPERADOR 		= Session::get('SESS_USUA_CODIGO');
        $FECHA 			= date('d-m-Y');
		$FECHA_HORA 	= date('d-m-Y H:i:s');
        $ARRAY = array();
        $ACCION 		= (empty($PERS_CODIGO)) ? 2 : 3; //Insert ó Update 
        unset($parametros);
    	$parametros[] = array('@ACCION',$ACCION);
		$parametros[] = array('@PERS_CODIGO',$PERS_CODIGO);
		$parametros[] = array('@PERS_APATERNO',$PERS_APATERNO);
		$parametros[] = array('@PERS_AMATERNO',$PERS_AMATERNO);
		$parametros[] = array('@PERS_NOMBRE',$PERS_NOMBRE);
		$parametros[] = array('@PERS_NOMCOM',$PERS_NOMCOM);
		$parametros[] = array('@PERS_TIPODOC',$PERS_TIPODOC);
		$parametros[] = array('@PERS_DOCUMENTO',$PERS_DOCUMENTO);
		$parametros[] = array('@PERS_SEXO',$PERS_SEXO);
		$parametros[] = array('@PERS_FECNACI',$PERS_FECNACI);
		$parametros[] = array('@PERS_DIRECCION',$PERS_DIRECCION);
		$parametros[] = array('@PERS_FOTO',NULL);
		$parametros[] = array('@PERS_OCUPACION',$PERS_OCUPACION);
		$parametros[] = array('@PERS_OPERADOR',$OPERADOR);
		$parametros[] = array('@PERS_ESTACION',$IP);
		$parametros[] = array('@PERS_ESTADO',1);
		$dbResult = ejec_store_procedure_sql("GENERAL.SP_PERSONA",$parametros);

        if(!empty($dbResult)):
            $ARRAY['accion'] = "success";
			$ARRAY['smg']="Se registro correctamente!";
		else:
			$ARRAY['accion'] = "error";
			$ARRAY['smg']="Problema al guardar el registro!";
		endif;

        echo json_encode($ARRAY);
    }
    public function eliminarPersona(Request $request){
        $PERS_CODIGO	= $request->get("PERS_CODIGO");
		$PERS_ESTADO	= $request->get("PERS_ESTADO");

        unset($parametros);
        $parametros[] = array('@ACCION',4);
        $parametros[] = array('@PERS_CODIGO',$PERS_CODIGO);
        $parametros[] = array('@PERS_ESTADO',$PERS_ESTADO);
        $dbResult = ejec_store_procedure_sql("GENERAL.SP_PERSONA",$parametros);

        $array = array();
		if(!empty($dbResult)) {
			$array['accion'] = 'success';
	    	$array['smg'] = 'Se guardó los cambios correctamente!';
		}else{
			$array['accion'] = 'error';
    		$array['smg'] = 'Ocurrio un problema!';
		}
	    	
	    echo json_encode($array);
    }
    
    public function usuarios(){
        $page_data['header_js'] = array(
        	'plugins/toastr/build/toastr.min.js',
        	'plugins/datatables/jquery.dataTables.min.js',
			'plugins/datatables/dataTables.bootstrap5.min.js',
			'plugins/datatables/dataTables.responsive.min.js',
			'plugins/datatables/responsive.bootstrap4.min.js',
			'js/js_usuario.js'

        );
		$page_data['header_css'] = array(
		 	'plugins/toastr/build/toastr.min.css',
		 	'plugins/datatables/dataTables.bootstrap5.min.css',
			'plugins/datatables/responsive.bootstrap4.min.css',
		);


		$page_data['page_directory'] = 'seguridad';
    	$page_data['page_name'] = 'usuarios';
    	$page_data['page_title'] = 'Usuarios';
        return view('index',$page_data);
    }
    public function listarUsuarios(Request $request){
        $USUA_CODIGO = $request->get('USUA_CODIGO');
		$PERS_CODIGO = $request->get('PERS_CODIGO');

		unset($parametros);
        $parametros[] = array('@ACCION',1);
        $parametros[] = array('@USUA_CODIGO',$USUA_CODIGO);
		$parametros[] = array('@PERS_CODIGO',$PERS_CODIGO);
        $dbResult = ejec_store_procedure_sql("ACCESOS.SP_USUARIOS",$parametros);
		echo json_encode($dbResult);
    }

    public function grabarUsuario(Request $request){
        $USUA_CODIGO	= $request->post('USUA_CODIGO');
		$PERS_CODIGO	= $request->post('PERS_CODIGO');
		$PERF_CODIGO	= $request->post('PERF_CODIGO');
		$USUA_USERNAME	= $request->post('USUA_USERNAME');
		$USUA_PASSWORD	= $request->post('USUA_PASSWORD');
		$USUA_ESTADO	= $request->post('USUA_ESTADO');
        $ESTACION 		= $_SERVER['REMOTE_ADDR'];
        $OPERADOR 		= Session::get('SESS_USUA_CODIGO');

        $ACCION 		= (empty($USUA_CODIGO)) ? 3 : 4; //Insert ó Update 
        $ARRAY          = array();

        unset($parametros);
        $parametros[] = array('@ACCION',$ACCION);        
        $parametros[] = array('@USUA_CODIGO',$USUA_CODIGO);
        $parametros[] = array('@PERF_CODIGO',$PERF_CODIGO);
        $parametros[] = array('@USUA_USERNAME',$USUA_USERNAME);
        $parametros[] = array('@USUA_PASSWORD',$USUA_PASSWORD);
        $parametros[] = array('@PERS_CODIGO',$PERS_CODIGO);
        $parametros[] = array('@USUA_ESTADO',$USUA_ESTADO);
		$parametros[] = array('@USUA_OPERADOR',$OPERADOR);
		$parametros[] = array('@USUA_ESTACION',$ESTACION);
        $dbResult = ejec_store_procedure_sql("ACCESOS.SP_USUARIOS",$parametros);

        if($dbResult[0]->RESULT<>0):
            $ARRAY['accion'] = "success";
			$ARRAY['smg']="Se registro correctamente!";
		else:
			$ARRAY['accion'] = "error";
			$ARRAY['smg']="Problema al guardar el registro!";
		endif;

        echo json_encode($ARRAY);
    }

	public function accesosUsuario(Request $request){
		$USUA_CODIGO	= $request->get('USUA_CODIGO');

		unset($parametros);
        $parametros[] = array('@ACCION',1);
		$parametros[] = array('@USUA_CODIGO',$USUA_CODIGO);
        $dbResult = ejec_store_procedure_sql("ACCESOS.SP_ACCESOS",$parametros);
		
		$page_data['USUA_CODIGO']=$USUA_CODIGO;
		$page_data['dbAcessos']=$dbResult;
		$returnHTML = view('seguridad.fmrAccesos',$page_data)->render();// render para ajax
        return $returnHTML;
		exit(0);
	}
	public function grabarAccesoUsuario(Request $request){
		$OPCI_CODIGO	= $request->get('OPCI_CODIGO');
		$USUA_CODIGO	= $request->get('USUA_CODIGO');
		$ACCE_ESTADO	= $request->get('CHECKED');
		
        $ESTACION 		= $_SERVER['REMOTE_ADDR'];
        $OPERADOR 		= Session::get('SESS_USUA_CODIGO');
		$PERS_CODIGO 	= Session::get('SESS_PERS_CODIGO');

        $ARRAY          = array();
        unset($parametros);
        $parametros[] = array('@ACCION',2);    
        $parametros[] = array('@OPCI_CODIGO',$OPCI_CODIGO);
		$parametros[] = array('@USUA_CODIGO',$USUA_CODIGO);
        $parametros[] = array('@ACCE_ESTADO',$ACCE_ESTADO);
        $parametros[] = array('@ACCE_OPERADOR',$OPERADOR);
        $parametros[] = array('@ACCE_ESTACION',$ESTACION);
        $dbResult = ejec_store_procedure_sql("ACCESOS.SP_ACCESOS",$parametros);

        if($dbResult[0]->RESULT<>0):
            $ARRAY['accion'] = "success";
			$ARRAY['smg']="Se registro correctamente!";
		else:
			$ARRAY['accion'] = "error";
			$ARRAY['smg']="Problema al guardar el registro!";
		endif;

        return json_encode($ARRAY);
	}
	public function modalarea(Request $request){
		$USUA_CODIGO	= $request->get('USUA_CODIGO');

		unset($parametros);
        $parametros[] = array('@ACCION',1);
        $dbResult = ejec_store_procedure_sql("GENERAL.SP_AREAS",$parametros);
		
		$page_data['USUA_CODIGO']=$USUA_CODIGO;
		$page_data['dbArea']=$dbResult;
		$returnHTML = view('seguridad.frmarea',$page_data)->render();// render para ajax
        return $returnHTML;
		exit(0);
	}

	public function selectUsuaArea(Request $request){
		$USUA_CODIGO	= $request->get('USUA_CODIGO');

		unset($parametros);
        $parametros[] = array('@ACCION',1);
		$parametros[] = array('@USUA_CODIGO',$USUA_CODIGO);
        $dbResult = ejec_store_procedure_sql("GENERAL.SP_USUA_AREAS",$parametros);

		return json_encode($dbResult);
	}
	public function grabarUsuaArea(Request $request){
		$USUA_CODIGO	= $request->get('USUA_CODIGO');
		$AREA_CODIGO	= $request->get('AREA_CODIGO');
		$ESTACION 		= $_SERVER['REMOTE_ADDR'];
        $OPERADOR 		= Session::get('SESS_USUA_CODIGO');

		unset($parametros);
        $parametros[] = array('@ACCION',2);
		$parametros[] = array('@USUA_CODIGO',$USUA_CODIGO);
		$parametros[] = array('@AREA_CODIGO',$AREA_CODIGO);
		$parametros[] = array('@USUA_A_OPERADOR',$OPERADOR);
		$parametros[] = array('@USUA_A_ESTACION',$ESTACION);
        $dbResult = ejec_store_procedure_sql("GENERAL.SP_USUA_AREAS",$parametros);

		$ARRAY          = array();
		if(!empty($dbResult)):
            $ARRAY['accion'] = "success";
			$ARRAY['smg']="Se registro correctamente!";
		else:
			$ARRAY['accion'] = "error";
			$ARRAY['smg']="Problema al guardar el registro!";
		endif;

        echo json_encode($ARRAY);

	}

	public function eliminarUsuarioArea(Request $request){
		$USUA_A_CODIGO	= $request->get('USUA_A_CODIGO');
		$USUA_A_ESTADO  = $request->get('USUA_A_ESTADO');

		unset($parametros);
        $parametros[] = array('@ACCION',4);
		$parametros[] = array('@USUA_A_CODIGO',$USUA_A_CODIGO);
		$parametros[] = array('@USUA_A_ESTADO',$USUA_A_ESTADO);
        $dbResult = ejec_store_procedure_sql("GENERAL.SP_USUA_AREAS",$parametros);

		$ARRAY          = array();
		if(!empty($dbResult)):
            $ARRAY['accion'] = "success";
			$ARRAY['smg']="Se registro correctamente!";
		else:
			$ARRAY['accion'] = "error";
			$ARRAY['smg']="Problema al guardar el registro!";
		endif;

        echo json_encode($ARRAY);
	}

	public function cambiarArea(Request $request){
		$AREA_CODIGO	= $request->get('AREA_CODIGO');
		$OPERADOR 		= Session::get('SESS_USUA_CODIGO');

		unset($parametros);
        $parametros[] = array('@ACCION',1);
		$parametros[] = array('@AREA_CODIGO',$AREA_CODIGO);
        $dbResult = ejec_store_procedure_sql("GENERAL.SP_AREAS",$parametros);
		$AREA_NOMBRE = $dbResult[0]->AREA_NOMBRE;
		session([
			'SESS_AREA_CODIGO' =>$AREA_CODIGO,
			'SESS_AREA_NOMBRE' =>$AREA_NOMBRE
		]);

		#CAMBIAMOS LA PRIODIDAD PARA EL PROXIMO LOGIN
		unset($parametros);
        $parametros[] = array('@ACCION',6);
		$parametros[] = array('@AREA_CODIGO',$AREA_CODIGO);
		$parametros[] = array('@USUA_A_CODIGO',$OPERADOR);
        $dbResult = ejec_store_procedure_sql("GENERAL.SP_USUA_AREAS",$parametros);


		$ARRAY          = array();
		$ARRAY['accion'] = "success";
		$ARRAY['smg']="Correcto";
		return json_encode($ARRAY);

	}

	public function perfil(){
		    
        $page_data = ['page_title'=>'Perfil de seguridad'];
        /*$page_data['header_js'] = array(
        	'plugins/toastr/build/toastr.min.js',
        	'plugins/datatables/jquery.dataTables.min.js',
			'plugins/datatables/dataTables.bootstrap5.min.js',
			'plugins/datatables/dataTables.responsive.min.js',
			'plugins/datatables/responsive.bootstrap4.min.js',
			'plugins/treeview/jstree.min.js',
			'plugins/treeview/jquery.treeview.init.js',
			'js/js_perfil.js'

        );*/
	
		#DATOS USUARIO
		$USUA_CODIGO = Session::get('SESS_USUA_CODIGO');
		unset($parametros);
        $parametros[] = array('@ACCION',1);        
        $parametros[] = array('@USUA_CODIGO',$USUA_CODIGO);
        $dbResult = ejec_store_procedure_sql("ACCESOS.SP_USUARIOS",$parametros);

		#DATOS PERSONA
		unset($parametros);
        $parametros[] = array('@ACCION',1);        
        $parametros[] = array('@PERS_CODIGO',$dbResult[0]->PERS_CODIGO);
        $dbPers = ejec_store_procedure_sql("GENERAL.SP_PERSONA",$parametros);
		
		$page_data['dataUser'] = json_encode($dbResult);
		$page_data['dataPers'] = json_encode($dbPers);
		
		$returnHTML = view('seguridad.perfil',$page_data)->render();// render para ajax
        return $returnHTML; #response()->json( array('success' => true, 'html'=>$returnHTML) );
		exit(0);
	}

	public function selectContactos(Request $request){
		$CONTC_CODIGO = $request->get('CONTC_CODIGO');

		$PERS_CODIGO = Session::get('SESS_PERS_CODIGO');
		#DATOS CONTACTO
		unset($parametros);
		$parametros[] = array('@ACCION',1);        
		$parametros[] = array('@PERS_CODIGO',$PERS_CODIGO);
		$parametros[] = array('@CONTC_CODIGO',$CONTC_CODIGO);
		$dbContact = ejec_store_procedure_sql("GENERAL.SP_CONTACTOS",$parametros);

		return json_encode($dbContact);
	}
	public function selectContactosIndivudual(Request $request){
		$PERS_CODIGO = $request->get('PERS_CODIGO');

		#DATOS CONTACTO
		unset($parametros);
		$parametros[] = array('@ACCION',1);        
		$parametros[] = array('@PERS_CODIGO',$PERS_CODIGO);
		$dbContact = ejec_store_procedure_sql("GENERAL.SP_CONTACTOS",$parametros);

		return response()->json($dbContact);
	}
	public function grabarContactos(Request $request){
		$CONTC_CODIGO	= $request->get('CONTC_CODIGO');
		$TIPO_D_CODIGO	= $request->get('TIPO_D_CODIGO');
		$CONTC_DATOS	= $request->get('CONTC_DATOS');
		
        $ESTACION 		= $_SERVER['REMOTE_ADDR'];
        $OPERADOR 		= Session::get('SESS_USUA_CODIGO');
		$PERS_CODIGO 	= Session::get('SESS_PERS_CODIGO');
		$CODIGO 	= Session::get('SESS_CODIGO');

        $ACCION 		= (empty($CONTC_CODIGO)) ? 2 : 3; //Insert ó Update 
        $ARRAY          = array();

        unset($parametros);
        $parametros[] = array('@ACCION',$ACCION);    
        $parametros[] = array('@CONTC_CODIGO',$CONTC_CODIGO);
		$parametros[] = array('@PERS_CODIGO',$PERS_CODIGO);
        $parametros[] = array('@TIPO_D_CODIGO',$TIPO_D_CODIGO);
        $parametros[] = array('@CONTC_DATOS',$CONTC_DATOS);
        $parametros[] = array('@CONTC_OPERADOR',$OPERADOR);
        $parametros[] = array('@CONTC_ESTACION',$ESTACION);
        $parametros[] = array('@CONTC_ESTADO',1);
        $dbResult = ejec_store_procedure_sql("GENERAL.SP_CONTACTOS",$parametros);

        if(!empty($dbResult)):
            $ARRAY['accion'] = "success";
			$ARRAY['smg']="Se registro correctamente!";
			$ARRAY['codigo'] = $dbResult[0]->RESULT;
		else:
			$ARRAY['accion'] = "error";
			$ARRAY['smg']="Problema al guardar el registro!";
			$ARRAY['codigo'] = 0;
		endif;

		$data = array();

        $data['codigo'] = $CODIGO;
        $data['tipo_contacto'] = $TIPO_D_CODIGO;
        $data['valor'] = $CONTC_DATOS;
        $data['operador'] = $OPERADOR;
        $data['estacion'] = $ESTACION;
        $data['fecha'] = date('Ymd h:i:s');

        #SE GUADAR EN SATMUN XP
        if(!empty($CODIGO)):
            #guardarContactoSatmunXP($data);
        endif;

        return json_encode($ARRAY);
	}

	public function eliminarContactos(Request $request){
		$CONTC_CODIGO	= $request->get('CONTC_CODIGO');
		$CONTC_ESTADO	= $request->get('CONTC_ESTADO');

		unset($parametros);
        $parametros[] = array('@ACCION',4);    
        $parametros[] = array('@CONTC_CODIGO',$CONTC_CODIGO);
        $parametros[] = array('@CONTC_ESTADO',$CONTC_ESTADO);
        $dbResult = ejec_store_procedure_sql("GENERAL.SP_CONTACTOS",$parametros);

        if(!empty($dbResult)):
            $ARRAY['accion'] = "success";
			$ARRAY['smg']="Se actualizo correctamente!";
		else:
			$ARRAY['accion'] = "error";
			$ARRAY['smg']="Problema al guardar el registro!";
		endif;

        return json_encode($ARRAY);
	}

	public function selectTipoContactos(){

		unset($parametros);
        $parametros[] = array('@ACCION',1);        
        $db = ejec_store_procedure_sql("GENERAL.SP_TIPO_CONTACTOS",$parametros);

		return json_encode($db);
	}
	function viewDocumentacion(){
		$page_data['header_js'] = array('plugins/highlight/highlight.min.js','js/js_admin_actualizar.js');
		$page_data['header_css'] = array('plugins/highlight/default.min.css');

        $page_data['page_directory'] = 'seguridad';
    	$page_data['page_name'] = 'documentacion';
    	$page_data['page_title'] = 'Documentacion';
        return view('index',$page_data);
	}
	public function guardarClave(Request $request){
		$USUA_PASSWORD	= $request->post('USUA_PASSWORD');
		$OPERADOR 		= Session::get('SESS_USUA_CODIGO');

		unset($parametros);
        $parametros[] = array('@ACCION',6);    
        $parametros[] = array('@USUA_PASSWORD',$USUA_PASSWORD);
        $parametros[] = array('@USUA_CODIGO',$OPERADOR);
        $dbResult = ejec_store_procedure_sql("ACCESOS.SP_USUARIOS",$parametros);

        if(!empty($dbResult)):
            $ARRAY['accion'] = "success";
			$ARRAY['smg']="Se actualizo correctamente!";
		else:
			$ARRAY['accion'] = "error";
			$ARRAY['smg']="Problema al guardar el registro!";
		endif;
		
		Session::flush();
        return json_encode($ARRAY);
	}
	public function claveView(){
        $page_data = ['page_title'=>'Clave de seguridad'];
		
		$returnHTML = view('seguridad.clave',$page_data)->render();
        return $returnHTML;
		exit(0);
	}
	// public function viewPerfil(){
	// 	$page_data['header_js'] = array();
	// 	$page_data['header_css'] = array();

    //     $page_data['page_directory'] = 'seguridad';
    // 	$page_data['page_name'] = 'perfil';
    // 	$page_data['page_title'] = 'Mi Perfil';
    //     return view('index',$page_data);
	// }
}