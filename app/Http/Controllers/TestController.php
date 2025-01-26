<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Notifications\ReciboNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\pagalo\Services\PdfReciboServicesTest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TestController extends Controller
{ 
    protected $pdfService;

    public function __construct()
    {
        #$this->pdfService = new PdfReciboServicesTest();
    }
    public function index(){
        //$this->generarPagoCancha();
    }
    function indextaller(){
        $nroPedido ='02100800';
        unset($parametros);
        $parametros[] = array('@ACCION',1);
        $parametros[] = array('@MATRI_NRO_ORDEN',$nroPedido);
        $resData = ejec_store_procedure_sql("TALLER.SP_MATRICULA",$parametros);
        $value = $resData[0];
        
        if(!empty($value->ALUM_CORREO)):
            $html = "Número de Pedido: <strong>".$nroPedido."</strong><br>
                    Alumno: <strong>".$value->ALUM_NOMBRES."</strong><br>
                    Taller: <strong>".$value->C_APER_NOMBRE."</strong><br>
                    Horario: <strong>".$value->HORA_INI_FORMAT." a ".$value->HORA_FIN_FORMAT."</strong><br>
                    Periodo: <strong>".$value->PROG_MES."</strong><br>
                    Día(s): <strong>".$value->PROG_DIA."</strong><br>
                    Local: <strong>".$value->LOCAL_NOMBRE."</strong><br><hr>
                    Pagado con: <strong>455788******1553</strong><br>
                    Monto pagado: <strong>S/ 80.00</strong><br>
                    Fecha y hora de reserva: <strong>02/01/2025 10:09:02</strong><br>
                    Estado: <strong>".$value->ESTA_NOMBRES."</strong><br>
            ";

            $codigoSecret = base64_encode(openssl_encrypt($nroPedido, 'AES-128-ECB', 'fgdreery#424a'));
            $dataUrl = url('reserva/talleres/consulta/'.$codigoSecret);
            $qr = storage_path('app/public/talleres/'.$codigoSecret.'.png');

            if(!file_exists($qr)){
                QrCode::format('png')->size(200)->generate($dataUrl, $qr);
            }
            $html .= "<div style='text-align: center;'><h4 style='margin: 1px 0 -1px 0;'>Código de tu reserva</h4><img src='".url('storage/talleres/'.$codigoSecret.'.png')."' style=''></div><br>";
            
            enviar_correo($value->ALUM_CORREO, $html,'Pago Online - Reserva de Taller');

        endif;
    }
    function indextest(){
        #enviar_correo('juctan.espinoza@gmail.com', 'Test mail otro');

        $pdfOutputs = [];
        /*
        [2024-12-03 22:42:39] local.DEBUG: Data Exitoso: {"TERMINAL":"00000001","BRAND_ACTION_CODE":"00","BRAND_HOST_DATE_TIME":"241203224236","TRACE_NUMBER":"913437","CARD_TYPE":"C","ECI_DESCRIPTION":"Transaccion autenticada","SIGNATURE":"e1d1df6b-15fc-4b3e-b7f2-493262aecafe","CARD":"533958******7081","MERCHANT":"651020066","STATUS":"Authorized","ACTION_DESCRIPTION":"Aprobado y completado con exito","ID_UNICO":"955243389374816","AMOUNT":"324.45","BRAND_HOST_ID":"649219","AUTHORIZATION_CODE":"T01524","YAPE_ID":"","CURRENCY":"0604","TRANSACTION_DATE":"241203224236","ACTION_CODE":"000","CVV2_VALIDATION_RESULT":"M","ECI":"02","ID_RESOLUTOR":"MCS8RDFPM1203","BRAND":"mastercard","ADQUIRENTE":"570010","BRAND_NAME":"MC","PROCESS_CODE":"000000","TRANSACTION_ID":"955243389374816"}  

        */
        $dataJson = [
            'TERMINAL' => '00000001',
            'BRAND_ACTION_CODE' => '00',
            'BRAND_HOST_DATE_TIME' => '241203224236',
            'TRACE_NUMBER' => '913437',
            'CARD_TYPE' => 'C',
            'ECI_DESCRIPTION' => 'Transaccion autenticada',
            'SIGNATURE' => 'e1d1df6b-15fc-4b3e-b7f2-493262aecafe',
            'CARD' => '533958******7081',
            'MERCHANT' => '651020066',
            'STATUS' => 'Authorized',
            'ACTION_DESCRIPTION' => 'Aprobado y completado con exito',
            'ID_UNICO' => '955243389374816',
            'AMOUNT' => '324.45',
            'BRAND_HOST_ID' => '649219',
            'AUTHORIZATION_CODE' => 'T01524',
            'YAPE_ID' => '',
            'CURRENCY' => '0604',
            'TRANSACTION_DATE' => '241203224236',
            'ACTION_CODE' => '000',
            'CVV2_VALIDATION_RESULT' => 'M',
            'ECI' => '02',
            'ID_RESOLUTOR' => 'MCS8RDFPM1203',
            'BRAND' => 'mastercard',
            'ADQUIRENTE' => '570010',
            'BRAND_NAME' => 'MC',
            'PROCESS_CODE' => '000000',
            'TRANSACTION_ID' => '955243389374816'
        ];

        /*
        $TRANSACTION_DATE = $TRANSACTION_DATE[4].$TRANSACTION_DATE[5]."/".$TRANSACTION_DATE[2].$TRANSACTION_DATE[3]."/".$TRANSACTION_DATE[0].$TRANSACTION_DATE[1]." ".$TRANSACTION_DATE[6].$TRANSACTION_DATE[7].":".$TRANSACTION_DATE[8].$TRANSACTION_DATE[9].":".$TRANSACTION_DATE[10].$TRANSACTION_DATE[11];
        $dataJson->PURCHASENUMBER = '208143;
        $dataJson->TRANSACTION_DATE = $TRANSACTION_DATE;
        */

        //add PURCHASENUMBER AND TRANSACTION_DATE in dataJson
        $date = '241203224236';
        $dataJson['PURCHASENUMBER'] = '208143';
        $dataJson['TRANSACTION_DATE'] = $date[4].$date[5]."/".$date[2].$date[3]."/".$date[0].$date[1]." ".$date[6].$date[7].":".$date[8].$date[9].":".$date[10].$date[11];



        $resRecibo = [
            (object) ['FANROOPERA' => '002379'],
            (object) ['FANROOPERA' => '002380'],
        ];
        

        foreach ($resRecibo as $recibo) {
            $pdfOutput = $this->pdfService->generateRecibo($recibo->FANROOPERA, 'S', '0064285');
            $pdfOutputs[] = [
                'content' => $pdfOutput,
                'filename' => 'recibo_' . $recibo->FANROOPERA . '.pdf'
            ];
        }

        // Notification::route('mail', 'raquelhuaman@live.com')
        //                         ->notify((new ReciboNotification(json_encode($dataJson), $pdfOutputs))->delay(now()->addMinute(1)));

        return response()->json(['message' => 'Notificación enviada']);

        /*$fecha_emision = Carbon::now()->format('d/m/Y h:i:s A');
        $TRAMI_ASUNTO = 'SOLICITUD DE CONSTANCIA DE TRABAJO';
        $PERS_NOMBRES = 'UGARTE BOLUARTE KRUPSKAYA ROSA LUZ';
        $nroPedido = '14091630';
        $TRANSACTION_DATE = '2021-09-21 16:30:00';
        try {
            unset($parametros);
            $parametros[] = array('@ACCION',1);
            $parametros[] = array('@RESE_NROPERACION','14091630');
            $resData = ejec_store_procedure_sql("CANCHA.SP_RESERVA",$parametros);
            
            $horarios_reservados_wsp = '';
            $horarios_reservados_mail = '';
            $n=1;

            $arrayData = json_decode(json_encode($resData),true);
            foreach($arrayData as $value){
                $horarios_reservados_wsp .= '🕰️ - '.$value['HORA_INICIO_FORMATO'].' - '.$value['HORA_FINAL_FORMATO'].'\n';
                $horarios_reservados_mail .= '🕰️ - '.$value['HORA_FECHA'].' -> '.$value['HORA_INICIO_FORMATO'].' - '.$value['HORA_FINAL_FORMATO'].'<br>';
            }
            
            $html = "Estimado(a) ".$PERS_NOMBRES.",<br><br>
                    Número de Pedido: ".$nroPedido."<br>
                    Pagado con: <strong>MI TARJETA</strong><br>
                    Monto pagado: <strong>S/ 120.52</strong><br>
                    Local: <strong>".$resData[0]->LOCAL_NOMBRE."</strong><br>
                    Campo: <strong>".$resData[0]->CAMP_NOMBRE."</strong><br>
                    Fecha y hora de reserva: <strong>".$TRANSACTION_DATE."</strong><br>
                    Horarios reservados: <br><strong>".$horarios_reservados_mail."</strong><br>
            ";

            $codigoSecret = base64_encode(openssl_encrypt($nroPedido, 'AES-128-ECB', 'fgdreery#424a'));
            
            $html .= "<div style='text-align: center;'><h4 style='margin: 1px 0 -1px 0;'>Código de tu reserva</h4><img src='".url('storage/alquiler/'.$codigoSecret.'.png')."' style=''></div><br>";
            
            enviar_correo('juctan.espinoza@gmail.com', $html,'Pago Online - Reserva de Cancha');


        } catch (\Throwable $th) {
            //throw $th;
        }*/
    }

    public function generarPagoCancha(){

        $nroPedido ='06125701';
        $PERS_NOMBRES = 'VEGA RANILLA ALEX ANTHONY';
        $TRANSACTION_DATE ='06/01/2025 12:58:04';
        $CARD = '455788******5317';
        $AMOUNT = '64.89';
        $PERS_CORREO ='vegaranillaalexanthony@gmail.com';


        unset($parametros);
        $parametros[] = array('@ACCION',1);
        $parametros[] = array('@RESE_NROPERACION',$nroPedido);
        $resData = ejec_store_procedure_sql("CANCHA.SP_RESERVA",$parametros);
    
        // foreach($resData as $value){
        //     #Generamos un recibo en SIMS
        //     unset($parametros);
        //     $parametros[] = array('@PS_FANROOPERAWEB',$nroPedido);
        //     $parametros[] = array('@PS_FANOMUSUAR',$PERS_NOMBRES);
        //     $parametros[] = array('@PS_FATIPDOCU','DNI');
        //     $parametros[] = array('@PS_FANRODOCU','06806873');
        //     $parametros[] = array('@PS_FACODAREA','6022'); #AREA DEPORTIVA
        //     $parametros[] = array('@PS_FACODRUBRO',$value->HORA_CODPAGO);
        //     $parametros[] = array('@PDE_FNIMPORTE',$value->HORA_PRECIO);
        //     $resRecibo = ejec_store_procedure_sql_sims("DBO.INSERTAR_PAGOWEB_TALLER",$parametros);
        //     $OPERACION = $resRecibo[0]->FAOPERACION;

        //     if($OPERACION<>'000000'){

        //         unset($parametros);
        //         $parametros[] = array('@ACCION',5);
        //         $parametros[] = array('@RESE_NROPERACION',$nroPedido);
        //         $parametros[] = array('@RESE_CODIGO',$value->RESE_CODIGO);
        //         $parametros[] = array('@RESE_FECHA_PAGO',date('Y-m-d H:i:s'));
        //         $parametros[] = array('@RESE_MONTO_PAGO',$value->HORA_PRECIO);
        //         $parametros[] = array('@RESE_CAJERO_PAGO','PT');
        //         $parametros[] = array('@RESE_NROPERA_PAGO',$OPERACION);
        //         $parametros[] = array('@R_ESTA_CODIGO',2);#Pagado
        //         #$parametros[] = array('@PURCHASENUMBER',$purchasenumber);
        //         $resActualizado = ejec_store_procedure_sql("CANCHA.SP_RESERVA",$parametros);

        //         #Marcamos como reservado al los horarios
        //         unset($parametros);
        //         $parametros[] = array('@ACCION',5);
        //         $parametros[] = array('@HORA_ESTADO',2); #pagado / reservado
        //         $parametros[] = array('@RESE_NROPERACION',$nroPedido);
        //         $parametros[] = array('@HORA_CODIGO',$value->HORA_CODIGO);
        //         ejec_store_procedure_sql("CANCHA.SP_HORARIO",$parametros);
        //     }else{

        //         unset($parametros);
        //         $parametros[] = array('@ACCION',5);
        //         $parametros[] = array('@HORA_ESTADO',4); #observado
        //         $parametros[] = array('@RESE_NROPERACION',$nroPedido);
        //         $parametros[] = array('@HORA_CODIGO',$value->HORA_CODIGO);
        //         ejec_store_procedure_sql("CANCHA.SP_HORARIO",$parametros);
        //     }
        // }

        $horarios_reservados_wsp = '';
        $horarios_reservados_mail = '';
        $n=1;

        $arrayData = json_decode(json_encode($resData),true);
        foreach($arrayData as $value){
            $horarios_reservados_wsp .= '🕰️ - '.$value['HORA_INICIO_FORMATO'].' - '.$value['HORA_FINAL_FORMATO'].'\n';
            $horarios_reservados_mail .= '🕰️ - '.$value['HORA_FECHA'].' -> '.$value['HORA_INICIO_FORMATO'].' - '.$value['HORA_FINAL_FORMATO'].'<br>';
        }
        
        if(!empty($PERS_CORREO)):
            $html = "Estimado(a) ".$PERS_NOMBRES.",<br><br>
                    Número de Pedido: ".$nroPedido."<br>
                    Pagado con: <strong>".$CARD."</strong><br>
                    Monto pagado: <strong>S/ ".$AMOUNT."</strong><br>
                    Local: <strong>".$resData[0]->LOCAL_NOMBRE."</strong><br>
                    Campo: <strong>".$resData[0]->CAMP_NOMBRE."</strong><br>
                    Fecha y hora de reserva: <strong>".$TRANSACTION_DATE."</strong><br>
                    Horarios reservados: <strong>".$horarios_reservados_mail."</strong><br>
            ";

            $codigoSecret = base64_encode(openssl_encrypt($nroPedido, 'AES-128-ECB', 'fgdreery#424a'));
            $dataUrl = url('reserva/consulta/'.$codigoSecret);
            $qr = storage_path('app/public/alquiler/'.$codigoSecret.'.png');

            if(!file_exists($qr)){
                //Crear QR en formato PNG
                QrCode::format('png')->size(200)->generate($dataUrl, $qr);
            }
            $html .= "<div style='text-align: center;'><h4 style='margin: 1px 0 -1px 0;'>Código de tu reserva</h4><img src='".url('storage/alquiler/'.$codigoSecret.'.png')."' style=''></div><br>";
            
            enviar_correo($PERS_CORREO, $html,'Pago Online - Reserva de Cancha');
        endif;
    }
}