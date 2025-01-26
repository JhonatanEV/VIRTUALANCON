<?php

namespace App\Http\Controllers\notificaciones;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Http\Controllers\notificaciones\Models\Bandeja;

class NotificacionesController extends Controller
{   
    public function insertarBandeja(Request $request){
        $data    =  $request->json()->all();

        $messages = [
            'required'  => 'El :attribute es obligatorio',
            'string'    => 'El :attribute debe tener formato de texto',
            'max'       => 'El :attribute no puede ser mayor que :max.',
            'integer'   => 'El :attribute debe ser entero',
            'correo'   => 'El :attribute debe ser un correo valido',
        ];

        $rules = [
            'tipo'      => 'required|integer',
            'operador'  => 'required',
            'estacion'  => 'required',
            'cod_sistema'  => 'required',
        ];
        
        $tipo    = isset($data['tipo'])?$data['tipo']:1;
        $url     = isset($data['url'])?$data['url']:'';
        
        

        switch ($tipo) {
            case 1:#chat
                $rules['para'] = 'required|max:9';
                $rules['mensaje'] = 'required|max:4000';
            break;
            case 2:#image
                $rules['para'] = 'required|max:9';
                $rules['mensaje'] = 'required|max:4000';
                $rules['url'] = 'required';
            break;
            case 3:#sticker
                $rules['para'] = 'required|max:9';
                $rules['url'] = 'required';
            break;
            case 4:#document
                $rules['para'] = 'required|max:9';
                $rules['mensaje'] = 'required|max:4000';
                $rules['filename'] = 'required';
                $rules['url'] = 'required';
            break;
            case 5:#audio
                $rules['para'] = 'required|max:9';
                $rules['url'] = 'required';
            break;
            case 6:#video
                $rules['para'] = 'required|max:9';
                $rules['mensaje'] = 'required|max:4000';
                $rules['url'] = 'required';
            break;
            case 7:#contact
                $rules['para'] = 'required|max:9';
                $rules['mensaje'] = 'required|max:4000';
            break;
            case 8:#location
                $rules['para'] = 'required|max:9';
                $rules['mensaje'] = 'required|max:4000';
                $rules['latitud'] = 'required';
                $rules['longitud'] = 'required';
            break;
            case 9:#mail
                #$rules['correo'] = 'required|email:rfc';
                $rules['mensaje'] = 'required|max:4000';
            break;

            default:
                return response()->json(['errors' =>'Tipo enviado es incorrecto'], 400);
            break;
        }

        $mensaje    = isset($data['mensaje']) ? $data['mensaje'] : '';
        $filename   = isset($data['filename']) ? $data['filename'] : '';
        $latitud    = isset($data['latitud']) ? $data['latitud'] : '';
        $longitud   = isset($data['longitud']) ? $data['longitud'] : '';
        $identificador = isset($data['identificador']) ? $data['identificador'] : '';
        
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        try {
            if(isset($url) && !empty($url)):
                
                $client = new Client([
                    'verify' => false,
                ]);
                $response = $client->head($url);
                $statusCode = $response->getStatusCode();
            
                if ($statusCode != 200) {
                    return response()->json(['errors' => 'La URL no existe', 'url' => $url], 400);
                }
            endif;
        } catch (ClientException $e) {
            return response()->json(['errors' => 'Error al acceder a la URL', 'message' => $e->getMessage()], 500);
        }
        
        try {

            $dataInsertarArray = [
                'TIPO_CODIGO'=> $data['tipo'],
                'SIS_CODIGO'=> $data['cod_sistema'],
                'BAND_PARA'=> $data['para'],
                'BAND_MENSAJE'=> $mensaje,
                'BAND_FILENAME'=> $filename,
                'BAND_URL'=> $url,
                'BAND_LATITUD'=> $latitud,
                'BAND_LONGITUD'=> $longitud,
                'BAND_ESTADO'=> 0,
                'BAND_PRIORIDAD'=> 0,
                'BAND_CREADO'=> date('Y-m-d H:i:s'),
                'BAND_OPERADOR'=> $data['operador'],
                'BAND_ESTACION'=> $data['estacion'],
                'BAND_IDENTIFICADOR'=> $identificador,
            ];

            $dbcodigo = Bandeja::insertGetId($dataInsertarArray, 'BAND_CODIGO');

            if ($dbcodigo <> 0) :
                return response()->json(['status'=>true,'success' => 'Se registro correctamente, se procedera enviar el mensaje','codigo'=>$dbcodigo]);
            else:
                return response()->json(['status'=>false,'error' => 'Ocurrio un problema al registrar el mensaje','codigo'=>0]);
            endif;

        
        } catch (\Exception $e) {
            return response()->json(['status'=>false, 'error' => $e->getMessage()], 500);
        }

    }
}