<?php
use GuzzleHttp\Client;

function prueba(){
    return "...";
}

function ejec_store_procedure_sql($nombrestore,$arraydatos)
{		
}
function ejec_store_procedure_sql_sims($nombrestore,$arraydatos)
{		
}

function ejec_pide_sunat_api($tipo,$documento){
}

function like_match($pattern, $subject)
{
    $pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
    return (bool) preg_match("/^{$pattern}$/i", $subject);
}

function escape_like($string){
    $search = array('%', '_');
    $replace   = array('\%', '\_');
    return str_replace($search, $replace, $string);
}

function subirArchivo($archivo, $rutaDestino) {
    // Comprobamos si el archivo ha sido subido correctamente
    if ($archivo["error"] == UPLOAD_ERR_OK) {
      // Obtenemos el nombre del archivo
      $nombreArchivo = $archivo["name"];

      $array = explode(".",$nombreArchivo);
      $ext  = $array[count($array)-1];
      $nombreArchivo = random_int(1, 999999999).".".$ext;
      // Indicamos la ruta de destino
      $rutaCompleta = $rutaDestino . $nombreArchivo;
      // Intentamos mover el archivo al destino
      if (move_uploaded_file($archivo["tmp_name"], $rutaCompleta)) {
          session(['file_tmp_name' => $nombreArchivo]);
        return true;
      } else {
          session(['file_tmp_name' => '']);
        return false;
      }
    } else {
      return false;
    }
}

function enviar_correo($email, $html, $asuntoPersonalizado = 'Plataforma Virtual - Municipalidad de Ancón',$adjuntos = []){
        #LA CONFIGURACION DE CORREO DE DONDE SE ENVIA ESTA EN .ENV
        $cabecera = "<table style='font-family: Roboto, sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f1f0f0; margin: 0;'>
                        <tr style='font-family: Roboto, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'>
                            <td style='font-family: Roboto, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;' valign='top'></td>
                            <td width='600' style='font-family: Roboto, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;' valign='top'>
                                <div class='content' style='font-family: Roboto, sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;'>
                                    <table class='main' width='100%' cellpadding='0' cellspacing='0' style='font-family: Roboto, sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;'>
                                        <tr style='font-family: Roboto, sans-serif; font-size: 14px; margin: 0;'>
                                            <td class='content-wrap' style='font-family: Roboto, sans-serif; box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; margin: 0;padding: 30px; box-shadow: 0 3px 15px rgba(30,32,37,.06); ;border-radius: 7px; background-color: #fff;' valign='top'>
                                                <meta itemprop='name' content='Correo de Plataforma' style='font-family: Roboto, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;' />
                                                <table width='100%' cellpadding='0' cellspacing='0' style='font-family: Roboto, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'>
                                                    <tr style='font-family: Roboto, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;'>
                                                        <td class='content-block' style='font-family: Roboto, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;' valign='top'>
                                                            <div style='margin-bottom: 15px;color:#1761fd;'>
                                                                Municipalidad de Ancón
                                                            </div>
                                                        </td>
                                                    </tr><tr><td>";

                                            $footer = "</td></tr><tr style='font-family: Roboto, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; border-top: 1px solid #e9ebec;'>
                                            <td class='content-block' style='font-family: Roboto, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0; padding-top: 15px' valign='top'>
                                                <div style='display: flex; align-items: center;'>
                                                    <div style='margin-left: 8px;'>
                                                        <span>Atte.</span><br>
                                                        <span style='font-weight: 600;'>".config('app.SISTEMA')."</span>
                                                        <p style='font-size: 13px; margin-bottom: 0px; margin-top: 3px; color: #878a99;'>Municipalidad de Ancón</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <div style='text-align: center; margin: 0px auto;'>
                            <p style='font-family: Roboto, sans-serif; font-size: 14px;color: #98a6ad; margin: 0px;padding: 6px;'>Este mensaje de correo electrónico se ha enviado desde una dirección exclusivamente para envíos. No responda a este mensaje.</p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>";
        
        $body = $cabecera.$html.$footer;

        $mensaje = new \stdClass();
        $mensaje->receptor = $email;
        $mensaje->contenido = $body;
      
        Mail::send([], [], function ($message) use ($mensaje, $asuntoPersonalizado, $adjuntos) {
          $message->to($mensaje->receptor)
            ->subject($asuntoPersonalizado)
            ->setBody($mensaje->contenido, 'text/html');
            
            foreach ($adjuntos as $adjunto) {
                $message->attach($adjunto);
            }
        });
}

function user_tipo_dispositivo(){
    $USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
    // Utilizar una expresión regular para determinar si es un dispositivo móvil
    if (preg_match('/android|webos|iphone|ipad|ipod|blackberry|windows phone/i', $USER_AGENT)) {
            $DEVICE_TYPE = "MOVIL";
    } else {
            $DEVICE_TYPE = "WEB";
    }
    return  $DEVICE_TYPE;
}

function consumirAPI($url, $data) {
    $client = new Client();
    $response = $client->request('POST', $url, [
        'form_params' => $data
    ]);
    return $response->getBody()->getContents();
}

function ejec_pide_asiento_api(){
}