<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\General\Persona;
use App\Models\Accesos\Usuarios;
use App\Http\Controllers\Titania\Models\Contribuyente;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct()
    {
    }
    
    public function index(){
        if (session()->has('SESS_ACTIVE')) {
            return redirect('main');
        }
        $data = ['page_title'=>'Login'];
        return view('login',$data);
    }

	public function recuperarAcceso(){
		$data = ['page_title'=>'Recuperar acceso'];

        return view('recuperar-acceso',$data);
	}

	public function crearCuenta(){
		$data = ['page_title'=>'Crear nueva cuenta'];	

       return view('crear-cuenta',$data);
	}

	public function validarPersona(Request $request){
		$TIPO = $request->get('TIPO');
		$DOCUMENTO = $request->get('DOCUMENTO');		
		$PIDE = ejec_pide_sunat_api($TIPO,$DOCUMENTO);

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
		
		//var_dump($PIDE['DATA']);
		return $PIDE;
	}
	public function buscarPersona(Request $request){

		$tipo = $request->get('TIPO');
		$arrayTipo = array('DNI'=>1,'RUC'=>2,'CE'=>3);
		$tipo = $arrayTipo[$tipo];


		$persona = Persona::where('PERS_DOCUMENTO',$request->get('DOCUMENTO'))
		->where('PERS_TIPODOC',$tipo)
		->first();
		
		$usuario = Usuarios::where('USUA_USERNAME',$request->get('DOCUMENTO'))->first();

		$array = array();
		if($usuario){
			$array['status'] = 0;
			$array['codigo'] = 0;
			$array['mensaje'] = 'El usuario ya existe registrado en la plataforma.';

			return response()->json($array);
		}
		
		if($persona){
			$array['status'] = 1;
			$array['codigo'] = $persona->PERS_CODIGO;
			$array['nombre'] = $persona->PERS_NOMBRE;
			$array['apaterno'] = $persona->PERS_APATERNO;
			$array['amaterno'] = $persona->PERS_AMATERNO;
			$array['direccion'] = $persona->PERS_DIRECCION;
			$array['sexo'] = $persona->PERS_SEXO;
			$array['foto'] = '';
			$array['correo'] = $persona->PERS_CORREO;
			$array['telefono'] = $persona->PERS_TELEFONO;
			$array['celular'] = $persona->PERS_CELULAR;
		}else{

			$PIDE = ejec_pide_sunat_api($request->get('TIPO'),$request->get('DOCUMENTO'));
			$PIDE = json_decode($PIDE,TRUE);

			if($PIDE['DATA']['STATUS']==1){
				$array['status'] = 1;
				$array['codigo'] = 0;
				$array['nombre'] = $PIDE['DATA']['NOMBRE_COMPLETO'];
				$array['apaterno'] = $PIDE['DATA']['APE_PATERNO'];
				$array['amaterno'] = $PIDE['DATA']['APE_MATERNO'];
				$array['direccion'] = $PIDE['DATA']['DIRECCION'];
				$array['sexo'] = '';
				$array['foto'] = '';
				$array['correo'] = '';
				$array['telefono'] = '';
				$array['celular'] = '';
			}
		}

		return response()->json($array);

	}
	public function guardarCuenta(Request $request){

		$ESTACION 		= $_SERVER["SERVER_ADDR"];
		$OPERADOR 		= Session::get('SESS_USUA_CODIGO');
		$ARRAY 			= array();
		$PERS_NOMBRE = str_replace("'", "", $request->pers_nombre);

		try {
			DB::beginTransaction();

			$usuario = Usuarios::where('USUA_USERNAME',$request->pers_documento)->first();
			if($usuario){
				$ARRAY['status'] = false;
				$ARRAY['codigo'] = 0;
				$ARRAY['mensaje'] = 'El usuario ya existe registrado en la plataforma.';
				return response()->json($ARRAY);
			}
			$persona = new Persona();
			if(!empty($request->codigo)):
				$codigo = str_pad($request->codigo, 7, "0", STR_PAD_LEFT);
				$persona->PERS_CONTR_CODIGO = $codigo;
			endif;
			
			$persona->PERS_DIRECCION = $request->pers_direccion;
			$persona->PERS_DOCUMENTO = $request->pers_documento;
			$persona->PERS_ESTADO = 1;
			$persona->PERS_NOMBRE = $PERS_NOMBRE;
			$persona->PERS_NOMCOM = $PERS_NOMBRE;
			$persona->PERS_CORREO = $request->pers_correo;
			$persona->PERS_CELULAR = $request->pers_celular;
			$persona->PERS_OPERADOR = $OPERADOR;
			$persona->PERS_TIPODOC = $request->pers_tipodoc;
			$persona->PERS_FECING = Carbon::now();
			$persona->save();


			$usuario = new Usuarios();
			$usuario->USUA_USERNAME = $request->pers_documento;
			$usuario->USUA_PASSWORD = Usuarios::hashPassword($request->usua_password);
			$usuario->USUA_ESTADO = 1;
			$usuario->PERF_CODIGO = 3;
			$usuario->PERS_CODIGO = $persona->PERS_CODIGO;
			$usuario->USUA_FECHING = Carbon::now();
			$usuario->save();

			$CORREO = "";
			if($persona):
				if(isset($persona->PERS_CORREO)):
					$mensaje = "Estimado(a) <b>".$persona->PERS_NOMCOM."</b>,<br>Bienvenido a la Plataforma Virtual de la Municipalidad Distrital de Ancón.<br><br>Para acceder a la plataforma, por favor ingrese con los siguientes datos:<br><br>Usuario: ".$persona->pers_documento."<br>Contraseña: ".$request->pers_documento."<br><br>Atentamente,<br>Municipalidad Distrital de Ancón";
					#enviar_correo($CORREO, $mensaje);
				endif;
			endif;

			$ARRAY['status'] = true;
			$ARRAY['codigo'] = $persona->PERS_CODIGO;
			$ARRAY['mensaje'] = 'El usuario se ha registrado correctamente.';

			DB::commit();
			return response()->json($ARRAY);
		} catch (\Throwable $th) {
			DB::rollBack();
			$ARRAY['status'] = false;
			$ARRAY['codigo'] = 0;
			$ARRAY['mensaje'] = $th->getMessage();
			return response()->json($ARRAY);
		}
	}


	public function validarContribuyente(Request $request){
		$dataJson = $request->json()->all();
		
		$array = array();
		if(!empty($dataJson['codigo'])):
			$codigo = str_pad($dataJson['codigo'], 10, "0", STR_PAD_LEFT);

			$contribuyente = Contribuyente::where('idsigma',$codigo)
			->where('vnrodoc',$dataJson['documento'])
			->where('nestado',1)
			->first();

			if($contribuyente){
				$array['status'] = true;
				$array['codigo'] = $contribuyente->idsigma;
				$array['nombre'] = $contribuyente->vnombre;
				$array['direccion'] = $contribuyente->cdenomi;
			}else{
				$array['status'] = false;
				$array['codigo'] = 0;
				$array['mensaje'] = 'El contribuyente no se encuentra registrado en la plataforma.';
			}
		else:
			$array['status'] = false;
			$array['codigo'] = 0;
			$array['mensaje'] = 'El código del contribuyente no puede estar vacío.';
		endif;
		
		return response()->json($array);
	}
	public function buscarContribuyente(Request $request){
		try {
			$tipo = $request->get('TIPO');
			$documento = $request->get('DOCUMENTO');
			if($tipo=='DNI'){
				$documento = str_pad($request->get('DOCUMENTO'), 8, "0", STR_PAD_LEFT);
			}else if($tipo=='RUC'){
				$documento = str_pad($request->get('DOCUMENTO'), 11, "0", STR_PAD_LEFT);
			}

			$contribuyente = Contribuyente::where('vnrodoc',$documento)
			->where('nestado',1)
			->first();

			$array = array();
			if($contribuyente){
				$array['status'] = true;
				$array['codigo'] = $contribuyente->idsigma;
				$array['nombre'] = $contribuyente->vnombre;
				$array['direccion'] = $contribuyente->cdenomi;
			}else{
				$array['status'] = false;
				$array['codigo'] = 0;
				$array['mensaje'] = 'El contribuyente no se encuentra registrado en la plataforma.';
			}

			return response()->json($array,200);
		} catch (\Throwable $th) {
			return response()->json($th,500);
		}
	}
    public function logout () { 
       // auth()->logout();
		Session::flush();
        return redirect('/login');
    }
}