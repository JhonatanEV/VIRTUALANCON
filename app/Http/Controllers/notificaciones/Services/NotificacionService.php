<?php

namespace App\Http\Controllers\notificaciones\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\General\Notificacion;
use Carbon\Carbon;

class NotificacionService
{
    function store($request)
    {
        try {
            DB::beginTransaction();
            
            $notificacion = new Notificacion();
            $notificacion->NOTIF_TITULO    = $request['TITULO'];
            $notificacion->NOTIF_CONTENIDO = $request['DES_CONTENIDO'];
            $notificacion->NOTIF_EMISOR    = $request['EMISOR_USUARIO'];
            $notificacion->NOTIF_DESTINO   = $request['DESTINO_USUARIO'];
            $notificacion->NOTIF_LEIDO     = 0;
            $notificacion->NOTIF_FECING    = Carbon::now();
            $notificacion->NOTIF_ESTADO    = 1;
            $notificacion->save();
        
            return $notificacion;
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
    
    function envio_whatsapp_notificacion($numero, $data=[], $type='chat')
    {
        $instancia = config('services.ultramsg.instancia');
        $token = config('services.ultramsg.token');

        $commonParams = array(
            'token' => $token,
            'to' => $numero,
            'priority' => $data['priority'] ?? 10,
        );

        $specificParams = array();
        switch ($type) {
            case 'chat':
                $specificParams['body'] = $data['body'];
                break;
            case 'image':
                $specificParams['image'] = $data['image'];
                $specificParams['caption'] = $data['caption'];
                break;
            case 'sticker':
                $specificParams['sticker'] = $data['sticker'];
                break;
            case 'document':
                $specificParams['filename'] = $data['filename'];
                $specificParams['document'] = $data['document'];
                $specificParams['caption'] = $data['caption'];
                break;
            case 'audio':
                $specificParams['audio'] = $data['audio'];
                break;
            case 'contact':
                $specificParams['contact'] = $data['contact'];
                break;
            case 'location':
                $specificParams['address'] = $data['address'];
                $specificParams['lat'] = $data['lat'];
                $specificParams['lng'] = $data['lng'];
                break;
            default:
                return "Tipo de mensaje no válido";
        }
        $params = array_merge($commonParams, $specificParams);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ultramsg.com/".$instancia."/messages/".$type,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        return $response;
    }

    function enviar_correo_notificacion($email, $html, $adjuntos = [])
    {
        $body = view('emails.notificacion', ['html' => $html])->render();

        $mensaje = new \stdClass();
        $mensaje->receptor = $email;
        $mensaje->contenido = $body;

        $sent = Mail::send([], [], function ($message) use ($mensaje, $adjuntos) {
            $message->to($mensaje->receptor)
                ->subject('Notificación - Municipalidad Distrital de Ancón')
                ->setBody($mensaje->contenido, 'text/html');

            /*foreach ($adjuntos as $adjunto) {
                $nombreArchivo = basename($adjunto);

                $opcionesContexto = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ];

                $contexto = stream_context_create($opcionesContexto);
                $contenido = file_get_contents($adjunto, false, $contexto);
                $archivoGuardado = Storage::disk('temp')->put($nombreArchivo, $contenido);
                $url = Storage::disk('temp')->url($nombreArchivo);   

                $message->attach($url);
            }*/
        });

        return $sent;
    }

    function get_respuesta_ultramsg($paramestros){
        $instancia = config('services.ultramsg.instancia');
        $token = config('services.ultramsg.token');

        $commonParams=array(
            'token' => $token
        );
        $params = array_merge($commonParams, $paramestros);

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.ultramsg.com/".$instancia."/messages?" .http_build_query($params),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        return $err;
        } else {
        return $response;
        }
    }
}
