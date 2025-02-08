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
use App\Http\Controllers\pagalo\Repositories\EstadoCuentaRespository;
use App\Http\Controllers\pagalo\Models\Response;

class PagosEnLineaController extends Controller
{   
    protected $visaServiceOnline;
    protected $visaCredentialss;
    protected $pdfService;
    public function __construct()
    {
        $this->visaServiceOnline = new VisaService();
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

        $codigo = Session::get('SESS_PERS_CONTR_CODIGO');
        $codigo = str_pad($codigo, 10, "0", STR_PAD_LEFT);

        $estadoCuentaRespository = new EstadoCuentaRespository();
        $page_data['allEcuenta'] = $estadoCuentaRespository->getData($codigo);

        $page_data['contribuyente'] = [];
        $page_data['titulo_principal'] = 'Pago en Línea de Tributos Predial y Arbitrios';
        $page_data['page_directory'] = 'pagalo.pago_linea';
        $page_data['page_name'] = 'index';
        $page_data['page_title'] = 'Pago en línea';
        $page_data['breadcrumbone'] = 'Págalo Ancón';
        $page_data['breadcrumb'] = 'Pago en Línea de Tributos';
        return view('index',$page_data);
    }
    public function procesarSeleccion(Request $request){
        try {
            $data = $request->data;
            $data = json_decode($data, true);

            if(empty($data)){
                return response()->json(['error' => 'No se ha seleccionado ningún tributo', 'data' => null, 'code' => 400], 400);
            }

            $monto = $request->total;
            $codigo = Session::get('SESS_CODIGO_CONTRI');
            $arrayInsert = [];
            
            #$monto = str_replace(',', '', $monto);
            #NIUBIZ
            $purchaseNumber = $this->visaServiceOnline->generatePurchaseNumber().'1'; #pagotributo;
            #FIN
            DB::beginTransaction();

            $response = new Response();
            $response->PURCHASENUMBER = $purchaseNumber;
            $response->AMOUNT = $monto;
            $response->JSON_PROCESO = json_encode($data);
            $response->FECH_ING = date('Y-m-d H:i:s');
            $response->save();

            DB::commit();

            return response()->json([
                'success' => 'Pago registrado correctamente', 
                'data' => $data, 
                'codCheckout' => $response->PURCHASENUMBER,
                'amount'=>$monto,
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
            $token = $this->visaServiceOnline->generateToken();
            
            $sesion = $this->visaServiceOnline->generateSesion($total, $token, 
            [
                'MDD4'  =>  Session::get('SESS_PERS_CORREO'),
                'MDD21' =>  0,
                'MDD32' =>  Session::get('SESS_PERS_DOCUMENTO'),
                'MDD75' =>  'Registrado',
                'MDD77' =>  intval(Session::get('SESS_DIAS'))
            ]);
            
            return response()->json([
                'mensaje' => 'Pago registrado correctamente', 
                'data' => [], 
                'codCheckout' => $purchaseNumber,
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
                'pers_correo' => Session::get('SESS_PERS_CORREO'),
            ], 200);
            
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

                            Notification::route('mail', Session::get('SESS_PERS_CORREO'))
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

                        Notification::route('mail', Session::get('SESS_PERS_CORREO'))
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