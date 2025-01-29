<?php
namespace App\Http\Controllers\pagalo;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\pagalo\Models\Contrib;
use App\Http\Controllers\pagalo\Models\PagosLineaCheckout;
use App\Http\Controllers\pagalo\Models\PagosLineaCtaCte;
use App\Http\Controllers\pagalo\Models\IngCaja;
use App\Models\General\Persona;
use App\Models\Accesos\Usuarios;
use App\Http\Controllers\pagalo\Services\PdfReciboServices;
use Illuminate\Http\Request;
use App\Services\VisaService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Notifications\ReciboNotification;
use Illuminate\Support\Facades\Notification;

class PagosEnLineaController extends Controller
{   
    protected $visaServiceOnline;
    protected $visaCredentialss;
    protected $pdfService;
    public function __construct()
    {
        $this->visaCredentialss;#config('visa.current_credentials')();
        
        $this->visaServiceOnline = new VisaService($this->visaCredentialss);
        
        $this->pdfService = new PdfReciboServices();
    }
    public function viewPagoLinea()
    {
        //si no tiene codigo de contribuyente enviar a la vista de registro
        // if(empty(Session::get('SESS_CODIGO_CONTRI'))){

            
        //     $page_data['titulo_principal'] = 'Pago en Línea de Tributos';
        //     $page_data['page_directory'] = 'pagalo.pago_linea';
        //     $page_data['page_name'] = 'validar_contribuyente';
        //     $page_data['page_title'] = 'Pago en línea';
        //     $page_data['breadcrumbone'] = 'Pago en línea';
        //     $page_data['breadcrumb'] = 'Validar contribuyente';
        //     return view('index',$page_data);
        // }

        $page_data['header_js'] = array(
			'plugins/datatables/jquery.dataTables.min.js',
			'plugins/datatables/dataTables.bootstrap5.min.js',
			'plugins/datatables/dataTables.responsive.min.js',
            'plugins/datatables/responsive.bootstrap4.min.js',
			'plugins/datatables/dataTables.rowGroup.min.js',
			'plugins/datatables/buttons.colVis.min.js',
            'plugins/twbs-pagination/twbs/jquery.twbsPagination.js',
            'plugins/multicheck/jquery.multi-select.js',
            'js/js_pago_linea_inicio.js'
		);

        $page_data['header_css'] = array(
        'plugins/datatables/dataTables.bootstrap5.min.css',
        'plugins/datatables/buttons.bootstrap5.min.css',
        'plugins/datatables/responsive.bootstrap4.min.css',
        'plugins/datatables/rowGroup.dataTables.min.css',
        'plugins/multicheck/example-styles.css'
        );

        $codigo = Session::get('SESS_PERS_CONTR_CODIGO'); #'0000255';#0000255 Session::get('SESS_CODIGO_CONTRI')
        
        // unset($parametros);
        // $parametros[] = array('@pfacodcontr',$codigo); #Session::get('SESS_CODIGO_CONTRI')
        // $AllEcuenta = ejec_store_procedure_sql_sims("DBO.sp_ctacte_pagosonline_2024",$parametros);

        // $contrib = Contrib::where('FACODCONTR', $codigo)->first();

        $page_data['allEcuenta'] = [];
        $page_data['contribuyente'] = [];
        $page_data['titulo_principal'] = 'Pago en Línea de Tributos Predial y Arbitrios';
        $page_data['page_directory'] = 'pagalo.pago_linea';
        $page_data['page_name'] = 'index';
        $page_data['page_title'] = 'Pago en línea';
        $page_data['breadcrumbone'] = 'Págalo Ancón';
        $page_data['breadcrumb'] = 'Pago en Línea de Tributos';
        #return view('layouts.app', compact('page_data'));
        return view('index',$page_data);
    }
    public function procesarSeleccion(Request $request){
        try {
            $data = $request->data;
            $data = json_decode($data, true);

            if(empty($data)){
                return response()->json(['error' => 'No se ha seleccionado ningún tributo', 'data' => null, 'code' => 400], 400);
            }

            $monto = 0;
            $codigo = Session::get('SESS_CODIGO_CONTRI');

            $arrayInsert = [];
            foreach($data as $key => $value){
                $monto += is_numeric($value['TOTAL']) ? floatval($value['TOTAL']) : 0;

                $DIRANEXO = trim($value['DOMICILIO_PREDIO']) ?? '';
                $DIRANEXO = str_replace(',', '', $DIRANEXO);
                $DIRANEXO = preg_replace('/\s+/', ' ', $DIRANEXO);

                $arrayInsert[] = [
                    'FACODCONTR' => $codigo,
                    'FACODTRIBU' => $value['FACODTRIBU'] ?? NULL,
                    'FADESTRIBU' => trim($value['FADESTRIBU']) ?? NULL,
                    'FAANOTRIBU' => trim($value['FAANOTRIBU']) ?? NULL,
                    'FAANEXO'    => trim($value['FAANEXO']) ?? NULL,
                    'FANRORECIB' => trim($value['FANRORECIB']) ?? NULL,
                    'FAPERIODO'  => trim($value['FAPERIODO']) ?? NULL,
                    'FACODAREA'  => trim($value['FACODAREA']) ?? NULL,
                    'FNIMP01'    => is_numeric($value['FNIMP01']) ? floatval($value['FNIMP01']) : 0,
                    'FNIMP02'    => is_numeric($value['FNIMP02']) ? floatval($value['FNIMP02']) : 0,
                    'FNIMP03'    => is_numeric($value['FNIMP03']) ? floatval($value['FNIMP03']) : 0,
                    'FNIMP04'    => is_numeric($value['FNIMP04']) ? floatval($value['FNIMP04']) : 0,
                    'FNIMP05'    => is_numeric($value['FNIMP05']) ? floatval($value['FNIMP05']) : 0,
                    'FNGASADMIN' => is_numeric($value['FNGASADMIN']) ? floatval($value['FNGASADMIN']) : 0,
                    'FNMORA'     => is_numeric($value['FNMORA']) ? floatval($value['FNMORA']) : 0,
                    'FASITRECIB' => trim($value['FASITRECIB']) ?? NULL,
                    'MARCA'      => NULL,
                    'VNFIMP01'   => 0,
                    'VNFIMP02'   => 0,
                    'VNFIMP03'   => 0,
                    'VNFIMP04'   => 0,
                    'VNFIMP05'   => 0,
                    'VNFGASADMIN'=> 0,
                    'FNCOSPROCE' => is_numeric($value['COSTAS']) ? floatval($value['COSTAS']) : 0,
                    'VNFCOSPROCE'=> 0,
                    'DIRANEXO'   => $DIRANEXO ?? '',
                    'FECVENC'    => trim($value['FECVENC']),
                    'MONTO'      => is_numeric($value['TOTAL']) ? floatval($value['TOTAL']) : 0,
                    'DESCUENTO'  => 0,
                    'TOTAL'      => is_numeric($value['TOTAL']) ? floatval($value['TOTAL']) : 0,
                    'FEC_OPERACION' => date('Y-m-d H:i:s'),
                ];
            }
            
            #$monto = str_replace(',', '', $monto);
            #NIUBIZ
            $purchaseNumber = $this->visaServiceOnline->generatePurchaseNumber().'3'; #pagotributo;
            #FIN
        
            
            DB::beginTransaction();

            $checkout = new PagosLineaCheckout();
            $checkout->FAMONTO = $monto;
            $checkout->FANROOPERACION = $purchaseNumber;
            #$checkout->FATOKEN = $token;
            $checkout->FACODCONTR = $codigo;
            $checkout->FARESPUESTAPAGO = 'PENDIENTE';
            $checkout->FAREQUESTPAGO = $request->FAREQUESTPAGO;
            $checkout->save();
            
            //NRO_OPERACION a $arrayInsert
            foreach($arrayInsert as $key => $value){
                $arrayInsert[$key]['NRO_OPERACION'] = $purchaseNumber;
                $arrayInsert[$key]['FACODCHECKOUT'] = $checkout->FACODCHECKOUT;
            }

            $columnsCount = 39; 
            $maxParameters = 2100;
            $batchSize = intdiv($maxParameters, $columnsCount);

            foreach (array_chunk($arrayInsert, $batchSize) as $batch) {
                $ctaCte = new PagosLineaCtaCte();
                $ctaCte->insert($batch);
            }

            DB::commit();


            //APLICAR DESCUENTO
            unset($parametros);
            $parametros[] = array('@PFACODCHECKOUT',$checkout->FACODCHECKOUT);
            $parametros[] = array('@PNRO_OPERACION',$purchaseNumber);
            $parametros[] = array('@PFACODCONTR',$codigo);
            $dataDescuento = ejec_store_procedure_sql_sims("DBO.SP_PAGOS_ONLINE_DESCUENTO",$parametros);

            $total = 0;
            foreach($dataDescuento as $datas){
                $total += floatval($datas->TOTAL);
            }
            $total = number_format($total, 2, '.', '');
            $checkout->FAMONTO = $total;
            $checkout->save();

            return response()->json([
                'success' => 'Pago registrado correctamente', 
                'data' => $dataDescuento, 
                'codCheckout' => $checkout->FACODCHECKOUT,
                'amount'=>$total,
                'nro_operacion'=>$purchaseNumber,
                'purchasenumber'=>$purchaseNumber,
                'code' => 200
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Error al registrar el pago', 'data' => $th->getMessage(), 'code' => 500], 500);
        }

    }
    public function validarCuentaParaPago(Request $request){

        $codigo = Session::get('SESS_CODIGO_CONTRI');
        $FACODCHECKOUT = $request->codCheckout;
        $purchaseNumber = $request->purchasenumber;
        $total = $request->amount;
        try {
            //APLICAR VALIDACIONES
            unset($parametros);
            $parametros[] = array('@PFACODCHECKOUT',$FACODCHECKOUT);
            $parametros[] = array('@PNRO_OPERACION',$purchaseNumber);
            $parametros[] = array('@PFACODCONTR',$codigo);
            $dataCorrecto = ejec_store_procedure_sql_sims("DBO.SP_PAGOS_ONLINE_REVISION_2024",$parametros);
            
            #\Log::channel('pagoonlinea')->debug('Data valida deuda: '.json_encode($dataCorrecto));

            if(isset($dataCorrecto[0]->VALIDAPAGO) && $dataCorrecto[0]->VALIDAPAGO == 'S'){

                $token = $this->visaServiceOnline->generateToken();

                $checkout = PagosLineaCheckout::where('FACODCHECKOUT', $FACODCHECKOUT)->first();
                $checkout->FATOKEN = $token;
                $checkout->save();
                
                $sesion = $this->visaServiceOnline->generateSesion($total, $token, 
                [
                    'MDD4'  =>  Session::get('SESS_USUA_CORREO'),
                    'MDD21' =>  0,
                    'MDD32' =>  Session::get('SESS_PERS_DOCUMENTO'),
                    'MDD75' =>  'Registrado',
                    'MDD77' =>  intval(Session::get('SESS_DIAS'))
                ]);
                
                return response()->json([
                    'mensaje' => 'Pago registrado correctamente', 
                    'data' => [], 
                    'codCheckout' => $FACODCHECKOUT,
                    'merchantid'=>$this->visaCredentialss['merchant_id'],
                    'amount'=>$total,
                    'nro_operacion'=>$purchaseNumber,
                    'token'=>$token,
                    'sessionKey'=>$sesion,
                    'purchasenumber'=>$purchaseNumber,
                    'channel'=>'web',
                    'code' => 200,
                    'pers_nombre' => Session::get('SESS_PERS_NOMBRE'),
                    'pers_apellido' => Session::get('SESS_PERS_APATERNO'),
                    'pers_correo' => Session::get('SESS_USUA_CORREO'),
                ], 200);
            }else{
                return response()->json(['mensaje' => $dataCorrecto[0]->VALIDAPAGO ?? 'Hubo movimiento en la CUENTA, Vuelva a Marcar', 'data' => [], 'code' => 404, 'status' => false], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => 'Error al validar la cuenta', 'data' => $th->getMessage(), 'code' => 500], 500);
        }

    }
    public function validarContribuyente(Request $request){
        $documento = $request->documento;
        $codigo = $request->codigo;
        $codigo = str_pad($codigo, 7, "0", STR_PAD_LEFT);

        $contrib = Contrib::where('FANRODOCUM', $documento)
        ->where('FACODCONTR', $codigo)
        ->where('FACODESTAD', 'AN')
        ->first();

        if($contrib){
            
            $data =[
                'codigo' => $contrib->FACODCONTR,
                'contribuyente' => trim($contrib->FANOMCONTR),
                'documento' => trim($contrib->FANRODOCUM),
            ];
            return response()->json(['mensaje' => 'Contribuyente encontrado', 'data' => $data, 'code' => 200, 'status' => true], 200);
        }else{
            return response()->json(['mensaje' => 'Contribuyente no encontrado', 'data' => null, 'code' => 404, 'status' => false], 200);
        }
    }
    public function confirmarContribuyente(Request $request){
        $documento = $request->documento;
        #$codigo = $request->codigo;
        #$codigo = str_pad($codigo, 7, "0", STR_PAD_LEFT);

        $contrib = Contrib::where('FANRODOCUM', $documento)
        //->where('FACODCONTR', $codigo)
        ->where('FACODESTAD', 'AN')
        ->first();

        if($contrib){
        
            $persona = Persona::where('PERS_CODIGO', Session::get('SESS_PERS_CODIGO'))->first();
            $persona->PERS_CONTR_CODIGO = $contrib->FACODCONTR;
            $persona->save();

            $usuario = Usuarios::where('USUA_CODIGO', Session::get('SESS_USUA_CODIGO'))->first();
            $usuario->PERF_CODIGO = 2; #contribuyente
            $usuario->save();

            Session::put('SESS_CODIGO_CONTRI', $contrib->FACODCONTR);
            Session::put('SESS_PERF_CODIGO', 2);

            $otroControlador = new LoginController();
            $navbar = $otroControlador->navbar2();

            return response()->json(['mensaje' => 'Contribuyente asignado', 'data' => $contrib, 'code' => 200, 'status' => true], 200);
        }else{
            return response()->json(['mensaje' => 'Contribuyente no encontrado', 'data' => null, 'code' => 404, 'status' => false], 200);
        }
    }

    public function finalizarPago(Request $request, $codigo){
        
        $amount = $request->amount;
        $purchasenumber = $request->purchasenumber;
        $transactionToken = $request->transactionToken;
        $codCheckout = $request->codCheckout;
        $amount = str_replace(',', '', $request->amount);
        
        try {
            $token = $this->visaServiceOnline->generateToken();
            $data = $this->visaServiceOnline->generateAuthorization($amount, $purchasenumber, $transactionToken, $token);

            if(empty($data)){
                $page_data['page_directory'] = 'pagalo.pago_linea';
                $page_data['page_name'] = 'error';
                $page_data['page_title'] = 'Pago en línea';
                $page_data['breadcrumbone'] = 'Págalo';
                $page_data['breadcrumb'] = 'Error al realizar el pago';
                return view('index',$page_data);
            }
            #\Log::channel('pagoonlinea')->debug('Data Json Exitoso: '.json_encode($data));
            if (isset($data->dataMap)):
                $ACTION_CODE = $data->dataMap->ACTION_CODE; #: "000",
                $codigo = Session::get('SESS_CODIGO_CONTRI');

                $dataJson = $data->dataMap;

                \Log::channel('pagoonlinea')->debug('Data Exitoso: '.json_encode($dataJson));

                if($ACTION_CODE=='000'):

                    $TRANSACTION_DATE = $dataJson->TRANSACTION_DATE ?? '';
                    $TRANSACTION_DATE = $TRANSACTION_DATE[4].$TRANSACTION_DATE[5]."/".$TRANSACTION_DATE[2].$TRANSACTION_DATE[3]."/".$TRANSACTION_DATE[0].$TRANSACTION_DATE[1]." ".$TRANSACTION_DATE[6].$TRANSACTION_DATE[7].":".$TRANSACTION_DATE[8].$TRANSACTION_DATE[9].":".$TRANSACTION_DATE[10].$TRANSACTION_DATE[11];
                    $dataJson->PURCHASENUMBER = $purchasenumber;
                    $dataJson->TRANSACTION_DATE = $TRANSACTION_DATE;
                    
                    $checkout = PagosLineaCheckout::where('FACODCHECKOUT', $codCheckout)->first();
                    $checkout->FARESPUESTAPAGO = 'COMPLETADO';
                    $checkout->FAREQUESTPAGO = json_encode($dataJson);
                    $checkout->save();

                    #Generamos recibo en SIMS
                    
                    try {
                        unset($parametros);
                        $parametros[] = array('@pFACODCHECKOUT',$codCheckout);
                        $parametros[] = array('@pFaoperacion',$purchasenumber);
                        $parametros[] = array('@pfacodcontr',$codigo);
                        $resRecibo = ejec_store_procedure_sql_sims("DBO.sp_pagoslinea_cancela_2024",$parametros);

                        #\Log::channel('pagoonlinea')->debug('Recibo Store PagoOnline: '.json_encode($resRecibo));

                        $page_data['page_directory'] = 'pagalo.pago_linea';
                        $page_data['page_title'] = 'Pago en línea';
                        $page_data['breadcrumbone'] = 'Págalo';

                        if(isset($resRecibo[0]->resultado) && $resRecibo[0]->resultado == 1):

                            $pdfOutputs = [];
                            foreach ($resRecibo as $recibo) {
                                $pdfOutput = $this->pdfService->generateRecibo($recibo->FANROOPERA, 'S');
                                $pdfOutputs[] = [
                                    'content' => $pdfOutput,
                                    'filename' => 'recibo_' . $recibo->FANROOPERA . '.pdf'
                                ];
                            }

                            Notification::route('mail', Session::get('SESS_USUA_CORREO'))
                                ->notify((new ReciboNotification(json_encode($dataJson), $pdfOutputs))->delay(now()->addMinute(1)));

                            $page_data['page_name'] = 'recibo';
                            $page_data['breadcrumb'] = 'Pago realizado correctamente';
                            $page_data['jsonData'] = json_encode($dataJson);
                            return view('index',$page_data);
                            
                        else:
                            
                            \Log::channel('pagoonlinea')->debug('Recibo No generado: '.json_encode($resRecibo));

                            $page_data['page_name'] = 'error_recibo';
                            $page_data['breadcrumb'] = 'Error al realizar el pago';
                            $page_data['jsonData'] = json_encode($dataJson);
                            return view('index',$page_data);
                        endif;

                    } catch (\Throwable $th) {

                        Notification::route('mail', Session::get('SESS_USUA_CORREO'))
                        ->notify((new ReciboNotification(json_encode($dataJson), []))->delay(now()->addMinute(1)));

                        $page_data['page_name'] = 'recibo';
                        $page_data['breadcrumb'] = 'Pago realizado correctamente';
                        $page_data['jsonData'] = json_encode($dataJson);
                        return view('index',$page_data);


                        \Log::channel('pagoonlinea')->debug('Error Recibo PagoOnline: '.json_encode($th->getMessage()));
                    }
                    
                else:
                    $checkout = PagosLineaCheckout::where('FACODCHECKOUT', $codCheckout)->first();
                    $checkout->FARESPUESTAPAGO = 'RECHAZADO';
                    $checkout->FAREQUESTPAGO = json_encode($data);
                    $checkout->save();
                    
                    \Log::channel('pagoonlinea')->debug('Data Rechazado: '.json_encode($dataJson));

                    $page_data['page_directory'] = 'pagalo.pago_linea';
                    $page_data['page_name'] = 'error_pago';
                    $page_data['page_title'] = 'Pago en línea';
                    $page_data['breadcrumbone'] = 'Págalo';
                    $page_data['breadcrumb'] = 'Error al realizar el pago';
                    $page_data['jsonData'] = json_encode($data);
                    $page_data['PURCHASENUMBER'] = $purchasenumber;
                    return view('index',$page_data);
                endif;
            else:
                if(isset($data->data)):
                    $dataJson = $data->data;

                    \Log::channel('pagoonlinea')->debug('Data Error Tarjeta: '.json_encode($dataJson));

                    $checkout = PagosLineaCheckout::where('FACODCHECKOUT', $codCheckout)->first();
                    $checkout->FARESPUESTAPAGO = 'RECHAZADO';
                    $checkout->FAREQUESTPAGO = json_encode($dataJson);
                    $checkout->save();

                    $page_data['page_directory'] = 'pagalo.pago_linea';
                    $page_data['page_name'] = 'error_pago';
                    $page_data['page_title'] = 'Pago en línea';
                    $page_data['breadcrumbone'] = 'Págalo';
                    $page_data['breadcrumb'] = 'Error al realizar el pago';
                    $page_data['jsonData'] = json_encode($dataJson);
                    $page_data['PURCHASENUMBER'] = $purchasenumber;
                    return view('index',$page_data);

                else:
                    $page_data['page_directory'] = 'pagalo.pago_linea';
                    $page_data['page_name'] = 'error';
                    $page_data['page_title'] = 'Pago en línea';
                    $page_data['breadcrumbone'] = 'Págalo';
                    $page_data['breadcrumb'] = 'Error al realizar el pago';
                    return view('index',$page_data);
                endif;


            endif;

        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al registrar el pago', 'data' => $th->getMessage(), 'code' => 500], 500);
        }
    }

    public function viewMisRecibos(){
        $codigo = Session::get('SESS_PERS_CONTR_CODIGO');
        // $recibos = IngCaja::where('FACODCONTR', $codigo)
        // ->where('FANROCAJA', 'PO') #SOLO PAGOS EN LINEA
        // ->OrderBy('FDFECCAJA','DESC')
        // ->OrderBy('FANROOPERA','DESC')
        // ->get();
        
        $page_data['recibos'] = [];
        $page_data['titulo_principal'] = 'Mis recibos';
        $page_data['page_directory'] = 'pagalo.pago_linea';
        $page_data['page_name'] = 'mis_recibos';
        $page_data['page_title'] = 'Mis recibos';
        $page_data['breadcrumbone'] = 'Págalo Ancón';
        $page_data['breadcrumb'] = 'Mis recibos';
        return view('index',$page_data);
    }
}