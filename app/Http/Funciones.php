<?php
/*
Al crear nueva funcion, ejecute el comando "composer update" en terminal de este proyecto
.Antes de ejecutar agregar a composer.json
"autoload": {
        "files":[
            "app/Http/Funciones.php"
        ],
    },
*/
use GuzzleHttp\Client;
use App\Http\Controllers\notificaciones\Models\Bandeja;

function prueba(){
    $var = "Prueba funcion";
    return $var;
}

function ejec_store_procedure_sql($nombrestore,$arraydatos)
{		
    $caddatos = '';
    if($arraydatos != '' || $arraydatos != null){
        if(count($arraydatos) > 0){
            for($i=0;$i<count($arraydatos);$i++){
                    $nomvar = $arraydatos[$i][0];
                    $valvar = $arraydatos[$i][1];					
                $caddatos.= $nomvar."='".$valvar."',";
            }
            $caddatos = substr($caddatos,0,strlen($caddatos)-1);
        }
    }
    $cadins = 'EXEC '.$nombrestore.' '.$caddatos;
    try {
        $query = DB::select($cadins);
        return $query;
    } catch (Exception $e) {
        return $e;
    }

}
function ejec_store_procedure_sql_sims($nombrestore,$arraydatos)
{		
    $caddatos = '';
    if($arraydatos != '' || $arraydatos != null){
        if(count($arraydatos) > 0){
            for($i=0;$i<count($arraydatos);$i++){
                    $nomvar = $arraydatos[$i][0];
                    $valvar = $arraydatos[$i][1];					
                $caddatos.= $nomvar."='".$valvar."',";
            }
            $caddatos = substr($caddatos,0,strlen($caddatos)-1);
        }
    }
    $cadins = 'SET NOCOUNT ON; EXEC '.$nombrestore.' '.$caddatos;
    try {
        $sqlsrv_sims = DB::connection('sqlsrv_rentas');
        $query = $sqlsrv_sims->select($cadins);
        return $query;
    } catch (Exception $e) {
        return $e;
    }

}
function ejec_store_procedure_sql_intranet($nombrestore,$arraydatos)
{		
    $caddatos = '';
    if($arraydatos != '' || $arraydatos != null){
        if(count($arraydatos) > 0){
            for($i=0;$i<count($arraydatos);$i++){
                    $nomvar = $arraydatos[$i][0];
                    $valvar = $arraydatos[$i][1];					
                $caddatos.= $nomvar."='".$valvar."',";
            }
            $caddatos = substr($caddatos,0,strlen($caddatos)-1);
        }
    }
    $cadins = 'EXEC '.$nombrestore.' '.$caddatos;
    try {
        $sqlsrv_sims = DB::connection('sqlsrv_intra');
        $query = $sqlsrv_sims->select($cadins);
        return $query;
    } catch (Exception $e) {
        return $e;
    }

}

function ejec_store_procedure_sql_sims_dev($nombrestore,$arraydatos)
{		
    $caddatos = '';
    if($arraydatos != '' || $arraydatos != null){
        if(count($arraydatos) > 0){
            for($i=0;$i<count($arraydatos);$i++){
                    $nomvar = $arraydatos[$i][0];
                    $valvar = $arraydatos[$i][1];					
                $caddatos.= $nomvar."='".$valvar."',";
            }
            $caddatos = substr($caddatos,0,strlen($caddatos)-1);
        }
    }
    $cadins = 'SET NOCOUNT ON; EXEC '.$nombrestore.' '.$caddatos;
    try {
        $sqlsrv_sims = DB::connection('sqlsrv_rentas_dev');
        $query = $sqlsrv_sims->select($cadins);
        return $query;
    } catch (Exception $e) {
        return $e;
    }

}
function ejec_store_procedure_sql_sgd($nombrestore,$arraydatos)
{		
    $caddatos = '';
    if($arraydatos != '' || $arraydatos != null){
        if(count($arraydatos) > 0){
            for($i=0;$i<count($arraydatos);$i++){
                    $nomvar = $arraydatos[$i][0];
                    $valvar = $arraydatos[$i][1];					
                $caddatos.= $nomvar."='".$valvar."',";
            }
            $caddatos = substr($caddatos,0,strlen($caddatos)-1);
        }
    }
    $cadins = 'SET NOCOUNT ON; EXEC '.$nombrestore.' '.$caddatos;
    try {
        $sqlsrv_satmunxp = DB::connection('sqlsrv_sgd');
        $query = $sqlsrv_satmunxp->select($cadins);
        return $query;
    } catch (Exception $e) {
        return $e;
    }
}
function ejec_store_procedure_sql_rentas($nombrestore,$arraydatos)
{		
    $caddatos = '';
    if($arraydatos != '' || $arraydatos != null){
        if(count($arraydatos) > 0){
            for($i=0;$i<count($arraydatos);$i++){
                    $nomvar = $arraydatos[$i][0];
                    $valvar = $arraydatos[$i][1];					
                $caddatos.= $nomvar."='".$valvar."',";
            }
            $caddatos = substr($caddatos,0,strlen($caddatos)-1);
        }
    }
    $cadins = 'SET NOCOUNT ON; EXEC '.$nombrestore.' '.$caddatos;
    try {
        $sqlsrv_satmunxp = DB::connection('sqlsrv_rentas');
        $query = $sqlsrv_satmunxp->select($cadins);
        return $query;
    } catch (Exception $e) {
        return $e;
    }
}

function ejec_store_procedure_sql_sgd_file($nombrestore, $arraydatos, $identificador)
{
    $parametros = array();
    $caddatos = '';

    foreach ($arraydatos as $parametro) {
        $nombre = $parametro[0];
        $valor = $parametro[1];

        if ($nombre === $identificador) {
            $parametros[] = [$valor, PDO::PARAM_LOB];
        } else {
            $caddatos .= $nombre . "='" . $valor . "',";
        }
    }

    $caddatos = rtrim($caddatos, ',');

    $cadins = 'SET NOCOUNT ON; EXEC ' . $nombrestore . ' ' . $caddatos;

    try {
        $sqlsrv_sgd = DB::connection('sqlsrv')->getPdo();
        $query = $sqlsrv_sgd->prepare($cadins);

        foreach ($parametros as $parametro) {
            $query->bindParam($parametro[0], $parametro[1], PDO::PARAM_LOB);
        }

        $query->execute();

        return true; // Retorna true si la ejecución fue exitosa
    } catch (Exception $e) {
        return false; // Retorna false si ocurrió un error
    }
}



function ejec_store_procedure_sql_multiple($nombrestore,$arraydatos){

    $caddatos = '';
    if($arraydatos != '' || $arraydatos != null){
        if(count($arraydatos) > 0){
            for($i=0;$i<count($arraydatos);$i++){
                    $nomvar = $arraydatos[$i][0];
                    $valvar = $arraydatos[$i][1];
                $caddatos.= $nomvar."='".$valvar."',";
            }
            $caddatos = substr($caddatos,0,strlen($caddatos)-1);
        }
    }
    $cadins = 'EXEC '.$nombrestore.' '.$caddatos;
    //$stmt = sqlsrv_query($this->db->conn_id, $cadins);
    $stmt = DB::select($cadins);
    $resultsets=array();
    
    do{
        $array=array();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC )) {
                $array[]=$row;
        }
        $resultsets[]=$array;
    }while(sqlsrv_next_result($stmt));


    return $resultsets;
}

function ejec_pide_sunat_api($tipo,$documento){
    $DATA = [];

    switch ($tipo) {
        case 'DNI':
            
                $CREDENCIALES=array(
                    1=>array('usuario'=>'41456859','clave' => '41456859') ,
                );
        
                $INT=1;
                $DATOS_PERSONA = '';
                $DATA['STATUS'] = 0;
                do {
                    $URL = "https://ws2.pide.gob.pe/Rest/RENIEC/Consultar?nuDniConsulta=".$documento."&nuDniUsuario=".$CREDENCIALES[$INT]['usuario']."&nuRucUsuario=20131372346&password=".$CREDENCIALES[$INT]['clave']."&out=json";
                    $CONSULTA       = file_get_contents($URL);
                    $CONSULTA_DNI   = json_decode($CONSULTA);
                    
                    $CO_RESULTADO = $CONSULTA_DNI->consultarResponse->return->coResultado;
                    
                    if(!isset($CONSULTA_DNI->consultarResponse->return->datosPersona)){
                        $INT++;
                    }else{
                        $DATOS_PERSONA=$CONSULTA_DNI->consultarResponse->return->datosPersona;
                        $DE_RESULTADO=$CONSULTA_DNI->consultarResponse->return->deResultado;
                        $INT=0;
                        $DATA['STATUS'] = 1;
                    }
                } while ($INT=0);
                
                $DATA['DOCUMENTO'] = $documento;
                $DATA['APE_PATERNO'] = !empty($DATOS_PERSONA->apPrimer) ? $DATOS_PERSONA->apPrimer : '';
                $DATA['APE_MATERNO'] = !empty($DATOS_PERSONA->apSegundo) ? $DATOS_PERSONA->apSegundo: '';
                $DATA['NOMBRE_COMPLETO'] = !empty($DATOS_PERSONA->prenombres) ? $DATOS_PERSONA->prenombres : '';
                $DATA['DIRECCION'] = !empty($DATOS_PERSONA->direccion) ? $DATOS_PERSONA->direccion : '';
                $DATA['UBIGEO'] = !empty($DATOS_PERSONA->ubigeo) ? $DATOS_PERSONA->ubigeo : '';
                $DATA['FOTO'] = !empty($DATOS_PERSONA->foto) ? 'data:image/gif;base64,'.$DATOS_PERSONA->foto : '';
                $DATA['ESTADO_CIVIL'] = !empty($DATOS_PERSONA->estadoCivil) ? $DATOS_PERSONA->estadoCivil : '';
                
            break;
        
        case 'RUC':

            
            try {
                $url="https://ws3.pide.gob.pe/Rest/Sunat/DatosPrincipales?numruc=".$documento;
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_HTTPGET, true);    
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                $rpta = curl_exec($ch);
                curl_close($ch);

                $rpta = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $rpta);
                $xml = simplexml_load_string($rpta); 
                //var_export($xml);
                //var_export($xml->soapenvBody->multiRef);
                $desc_tipovia = $xml->soapenvBody->multiRef->desc_tipvia;
                $desc_nombvia = $xml->soapenvBody->multiRef->ddp_nomvia; 
                $desc_tipozona = $xml->soapenvBody->multiRef->desc_tipzon; 
                $desc_nomzona =  $xml->soapenvBody->multiRef->ddp_nomzon;
                $numero = $xml->soapenvBody->multiRef->ddp_numer1; 
                $departamento = $xml->soapenvBody->multiRef->desc_dep; 
                $provincia = $xml->soapenvBody->multiRef->desc_prov;
                $distrito = $xml->soapenvBody->multiRef->desc_dist; 
                $razonsocial = $xml->soapenvBody->multiRef->ddp_nombre;

                $tipovia = empty($desc_tipovia)?'':$desc_tipovia.' ';
                $nombvia = empty($desc_nombvia)?'':$desc_nombvia.' ';
                $tipozona = empty($desc_tipozona)?'':$desc_tipozona.' ';
                $nomzona =  empty($desc_nomzona)?'':$desc_nomzona.' ';
                $referencia = $xml->soapenvBody->multiRef->ddp_refer1;  
                $referencia = ($referencia=='-')?'':'('.$referencia.')';
    
                $domicilio = $tipovia.' '.$nombvia;
                $numero = (trim($numero)=='-')?'':$numero; 
                $interior = $xml->soapenvBody->multiRef->ddp_inter1;
                $lote = $xml->soapenvBody->multiRef->ddp_lllttt;
                $denominacion = $tipozona.' '.$nomzona.' '.$referencia;
                $ubig = $departamento.'/'.$provincia.'/'.$distrito;

                //$razonsocial = implode($razonsocial, ",");

                $DATA['DOCUMENTO'] = $documento;
                $DATA['NOMBRE_COMPLETO']= trim($razonsocial);
                $DATA['DIRECCION']  = trim($domicilio.' '.$numero.' '.$denominacion);
                $DATA['UBIGEO']     = trim($ubig);
                $DATA['APE_PATERNO']= '';
                $DATA['APE_MATERNO']= '';
                $DATA['FOTO']       = '';
                $DATA['ESTADO_CIVIL']= '';
                $DATA['STATUS'] = 1;
            } catch (Exception $exc) {
                $DATA['STATUS'] = 0;
            }
           
            break;
    }

    return json_encode(['STATUS' => 1,'DATA' => $DATA]);
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

function enviar_correo($email, $html, $asuntoPersonalizado = 'Municipalidad de Ancón',$adjuntos = []){
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
                                                            <div style='margin-bottom: 15px;'>
                                                                <img src='https://www.muniancon.gob.pe/nuevoportal/assets/img/logo_negro_horizontal-8.png' height=50>
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

        try {
            Bandeja::create([
                'TIPO_CODIGO' => 9,
                'SIS_CODIGO' => 1,
                'BAND_PARA' => $email,
                'BAND_MENSAJE' => $body,
                'BAND_PRIORIDAD' => 1,
                'BAND_CREADO' => date('Y-m-d H:i:s')
            ]);
        } catch (\Throwable $th) {
            \Log::error('Error al enviar correo: '.$th->getMessage());
        }
}

function envio_whatsapp_chat($numero,$mensaje){
    
    $params=array(
        'token' => '3rcn6k8v1useywib',
        'to' => $numero, //Debe contener codigo como +51939663792
        'body' => $mensaje
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.ultramsg.com/instance54165/messages/chat",
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
}

function envio_whatsapp_imagen($numero,$url_img,$mensaje){
    
    $params=array(
        'token' => 'zfxks3l0i31zg081',
        'to' => $numero, //Debe contener codigo como +51939663792
        'image' => $url_img,
        'caption' => $mensaje
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.ultramsg.com/instance30083/messages/image",
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
}

function envio_whatsapp_documento($numero,$url_file,$mensaje){
    
    $params=array(
        'token' => 'zfxks3l0i31zg081',
        'to' => $numero, //Debe contener codigo como +51939663792
        'filename' => basename($url_file),
        'document' => $url_file,
        'caption' => $mensaje
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.ultramsg.com/instance30083/messages/document",
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
}

function envio_whatsapp_video($numero,$url_video,$mensaje){
    
    $params=array(
        'token' => 'zfxks3l0i31zg081',
        'to' => $numero, //Debe contener codigo como +51939663792
        'video' => $url_file,
        'caption' => $mensaje
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.ultramsg.com/instance30083/messages/video",
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
/*
function zona_registral(){
$zona = [{'zona'=>'01', 'oficina'=>'01', 'nombre'=>'LIMA', 'estado': 1},
    {'zona'=>'01', 'oficina'=>'02', 'nombre'=>'CALLAO', 'estado': 1},
    {'zona'=>'01', 'oficina'=>'03', 'nombre'=>'HUARAL', 'estado': 1},
    {'zona'=>'01', 'oficina'=>'04', 'nombre'=>'HUACHO', 'estado': 1},
    {'zona'=>'01', 'oficina'=>'05', 'nombre'=>'CAÑETE', 'estado': 1},
    {'zona'=>'01', 'oficina'=>'06', 'nombre'=>'BARRANCA', 'estado': 1},
    {'zona'=>'02', 'oficina'=>'01', 'nombre'=>'HUANCAYO', 'estado': 1},
    {'zona'=>'02', 'oficina'=>'02', 'nombre'=>'HUANUCO', 'estado': 1},
    {'zona'=>'02', 'oficina'=>'04', 'nombre'=>'PASCO', 'estado': 1},
    {'zona'=>'02', 'oficina'=>'05', 'nombre'=>'SATIPO', 'estado': 1},
    {'zona'=>'02', 'oficina'=>'06', 'nombre'=>'LA MERCED', 'estado': 1},
    {'zona'=>'02', 'oficina'=>'07', 'nombre'=>'TARMA', 'estado': 1},
    {'zona'=>'02', 'oficina'=>'08', 'nombre'=>'TINGO MARIA', 'estado': 1},
    {'zona'=>'02', 'oficina'=>'09', 'nombre'=>'HUANCAVELICA', 'estado': 1},
    {'zona'=>'03', 'oficina'=>'01', 'nombre'=>'AREQUIPA', 'estado': 1},
    {'zona'=>'03', 'oficina'=>'02', 'nombre'=>'CAMANA', 'estado': 1},
    {'zona'=>'03', 'oficina'=>'03', 'nombre'=>'CASTILLA - APLAO', 'estado': 1},
    {'zona'=>'03', 'oficina'=>'04', 'nombre'=>'ISLAY - MOLLENDO', 'estado': 1},
    {'zona'=>'04', 'oficina'=>'01', 'nombre'=>'HUARAZ', 'estado': 1},
    {'zona'=>'04', 'oficina'=>'02', 'nombre'=>'CASMA', 'estado': 1},
    {'zona'=>'04', 'oficina'=>'03', 'nombre'=>'CHIMBOTE', 'estado': 1},
    {'zona'=>'05', 'oficina'=>'01', 'nombre'=>'PIURA', 'estado': 1},
    {'zona'=>'05', 'oficina'=>'02', 'nombre'=>'SULLANA', 'estado': 1},
    {'zona'=>'05', 'oficina'=>'03', 'nombre'=>'TUMBES', 'estado': 1},
    {'zona'=>'06', 'oficina'=>'01', 'nombre'=>'CUSCO', 'estado': 1},
    {'zona'=>'06', 'oficina'=>'02', 'nombre'=>'ABANCAY', 'estado': 1},
    {'zona'=>'06', 'oficina'=>'03', 'nombre'=>'MADRE DE DIOS', 'estado': 1},
    {'zona'=>'06', 'oficina'=>'04', 'nombre'=>'QUILLABAMBA', 'estado': 1},
    {'zona'=>'06', 'oficina'=>'05', 'nombre'=>'SICUANI', 'estado': 1},
    {'zona'=>'06', 'oficina'=>'06', 'nombre'=>'ESPINAR', 'estado': 1},
    {'zona'=>'06', 'oficina'=>'07', 'nombre'=>'ANDAHUAYLAS', 'estado': 1},
    {'zona'=>'07', 'oficina'=>'01', 'nombre'=>'TACNA', 'estado': 1},
    {'zona'=>'07', 'oficina'=>'02', 'nombre'=>'ILO', 'estado': 1},
    {'zona'=>'07', 'oficina'=>'03', 'nombre'=>'JULIACA', 'estado': 1},
    {'zona'=>'07', 'oficina'=>'04', 'nombre'=>'MOQUEGUA', 'estado': 1},
    {'zona'=>'07', 'oficina'=>'05', 'nombre'=>'PUNO', 'estado': 1},
    {'zona'=>'08', 'oficina'=>'01', 'nombre'=>'TRUJILLO', 'estado': 1},
    {'zona'=>'08', 'oficina'=>'02', 'nombre'=>'CHEPEN', 'estado': 1},
    {'zona'=>'08', 'oficina'=>'03', 'nombre'=>'HUAMACHUCO', 'estado': 1},
    {'zona'=>'08', 'oficina'=>'04', 'nombre'=>'OTUZCO', 'estado': 1},
    {'zona'=>'08', 'oficina'=>'05', 'nombre'=>'SAN PEDRO', 'estado': 1},
    {'zona'=>'09', 'oficina'=>'01', 'nombre'=>'MAYNAS', 'estado': 1},
    {'zona'=>'10', 'oficina'=>'01', 'nombre'=>'ICA', 'estado': 1},
    {'zona'=>'10', 'oficina'=>'02', 'nombre'=>'CHINCHA', 'estado': 1},
    {'zona'=>'10', 'oficina'=>'03', 'nombre'=>'PISCO', 'estado': 1},
    {'zona'=>'10', 'oficina'=>'04', 'nombre'=>'NAZCA', 'estado': 1},
    {'zona'=>'11', 'oficina'=>'01', 'nombre'=>'CHICLAYO', 'estado': 1},
    {'zona'=>'11', 'oficina'=>'02', 'nombre'=>'CAJAMARCA', 'estado': 1},
    {'zona'=>'11', 'oficina'=>'03', 'nombre'=>'JAEN', 'estado': 1},
    {'zona'=>'11', 'oficina'=>'04', 'nombre'=>'BAGUA', 'estado': 1},
    {'zona'=>'11', 'oficina'=>'05', 'nombre'=>'CHACHAPOYAS', 'estado': 1},
    {'zona'=>'11', 'oficina'=>'06', 'nombre'=>'CHOTA', 'estado': 1},
    {'zona'=>'12', 'oficina'=>'01', 'nombre'=>'MOYOBAMBA', 'estado': 1},
    {'zona'=>'12', 'oficina'=>'02', 'nombre'=>'TARAPOTO', 'estado': 1},
    {'zona'=>'12', 'oficina'=>'03', 'nombre'=>'JUANJUI', 'estado': 1},
    {'zona'=>'12', 'oficina'=>'04', 'nombre'=>'YURIMAGUAS', 'estado': 1},
    {'zona'=>'13', 'oficina'=>'01', 'nombre'=>'PUCALLPA', 'estado': 1},
    {'zona'=>'14', 'oficina'=>'01', 'nombre'=>'AYACUCHO', 'estado': 1},
    {'zona'=>'14', 'oficina'=>'02', 'nombre'=>'HUANTA', 'estado': 1}]

}*/