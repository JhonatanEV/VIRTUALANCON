<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Seguridad\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Url;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SeguridadController extends Controller
{
    public function __construct()
    {
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
	}

    public function selectCmbMenuOpciones(Request $request){
	}

    public function editarOpciones(Request $request){
	}

    public function eliminarOpcion(Request $request){
    }

    public function guardarOpciones(Request $request){
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
	}

    public function eliminarRoles(Request $request){
    }
    public function selectLeyendasOpcion(Request $request){
    }

	public function grabarRoles(Request $request){
	}
	
    public function selectLeyendasSubOpcion(Request $request){
    }

    public function grabarOpcionRoles(Request $request){
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
    }
	
    public function grabarPersona(Request $request){
    }
    public function eliminarPersona(Request $request){
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
    }

    public function grabarUsuario(Request $request){
    }

	public function accesosUsuario(Request $request){
	}
	public function grabarAccesoUsuario(Request $request){
	}
	public function modalarea(Request $request){
	}

	public function selectUsuaArea(Request $request){
	}
	public function grabarUsuaArea(Request $request){
	}

	public function eliminarUsuarioArea(Request $request){
	}

	public function cambiarArea(Request $request){
	}

	public function perfil(){
	}

	public function selectContactos(Request $request){
	}
	public function selectContactosIndivudual(Request $request){
	}
	public function grabarContactos(Request $request){
	}

	public function eliminarContactos(Request $request){
	}

	public function selectTipoContactos(){
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
		$usua_codigo 		= Session::get('SESS_USUA_CODIGO');

		$usuario = Usuarios::findOrFail($usua_codigo);
		$usuario->USUA_PASSWORD = Usuarios::hashPassword($USUA_PASSWORD);
		$usuario->save();
		#remove all session
		Session::flush();
		redirect()->route('login');
		return response()->json(['success' => true]);
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