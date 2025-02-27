<?php
namespace App\Http\Controllers\pagalo;

use App\Helpers\NiubizHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Titania\Models\Contribuyente;
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
use App\Http\Controllers\pagalo\Models\Response as NiubizResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\pagalo\Models\EstadoCuenta;
use App\Http\Controllers\pagalo\Models\RegistroPago;
use App\Http\Controllers\pagalo\Models\Dtesoreria;
use App\Http\Controllers\pagalo\Models\Mtesoreria;
use App\Traits\UtilsTrait;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PagosEnLineaController extends Controller
{   
    use UtilsTrait;
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
        
        $page_data['contribuyente'] = Contribuyente::where('idsigma', $codigo)->first();
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
            $codigo = Session::get('SESS_PERS_CONTR_CODIGO');
            #$monto = str_replace(',', '', $monto);
            #NIUBIZ
            $purchaseNumber = $this->visaServiceOnline->generatePurchaseNumber().'1'; #pagotributo;
            #FIN
            DB::beginTransaction();

            $response = new NiubizResponse();
            $response->PURCHASENUMBER = $purchaseNumber;
            $response->AMOUNT = $monto;
            #$response->JSON_PROCESO = json_encode($data);
            $response->FECH_ING = date('Y-m-d H:i:s');
            $response->save();

            $codigo_operacion = '00000000000000000000';

            foreach ($data as $item) {
                // Extraer los idsigma_agrupados
                $idsigma_agrupados = explode(',', $item['idsigma_agrupados']);

                RegistroPago::whereIn('idsigma', $idsigma_agrupados)
                    ->where('codigo_operacion', $item['codigo_operacion'])
                    ->update(['pushernumber' => $purchaseNumber]);
                
                $codigo_operacion = $item['codigo_operacion'];
            }

            DB::commit();

            return response()->json([
                'success' => 'Pago registrado correctamente', 
                'data' => $data, 
                'codCheckout' => $codigo_operacion,
                'amount'    => $monto,
                'nro_operacion' => $codigo_operacion,
                'purchasenumber'=> $purchaseNumber,
                'code' => 200
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Error al registrar el pago', 'data' => $th->getMessage(), 'code' => 500], 500);
        }

    }
    public function validarCuentaParaPago(Request $request){

        $codigo = Session::get('SESS_PERS_CONTR_CODIGO');
        $FACODCHECKOUT = $request->codCheckout;
        $purchaseNumber = $request->purchasenumber;
        $total = $request->amount;
        $total = str_replace(',', '', $total);
        $total = (float)number_format($total, 2, '.', '');

        try {            
            
            $params = [
                'codigo' => $codigo,
                'contribuyente' => '',
                'transactionData' => [
                    'AMOUNT' => $total,
                    'TRANSACTION_DATE' => Carbon::now()->format('Y-m-d H:i:s'),
                    'ACTION_CODE' => '000',
                    'STATUS' => 'APROBADO',
                    'TRANSACTION_ID' => '00000000000000000000',
                    'NRO_PEDIDO' => '00000000000000000000'
                ],
                'codigo_operacion' => $FACODCHECKOUT,
                'purchaseNumber' => $purchaseNumber,
                //'json' => json_encode(json_decode($NiubizResponse->JSON_PROCESO))
            ];
            try {
                    $reciboResponse = $this->generarPago($params);
                    
                    Log::info('reciboResponse: '.json_encode($reciboResponse));

            } catch (\Throwable $th) {
                Log::error('Error al generar recibo 1: '.$th->getMessage());
            }
            
            return response()->json(['mensaje' => 'Pago registrado correctamente', 'data' => [], 'code' => 200], 200);
            
            #*************************************** FIN PRUEBA ***************************************

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
                'codCheckout' => $FACODCHECKOUT,
                'merchantid'=> NiubizHelper::getCurrentCredentials()['merchant_id'],
                'amount'=>$total,
                'nro_operacion'=>$FACODCHECKOUT,
                'token'=>$token,
                'sessionKey'=>$sesion,
                'purchasenumber'=>$purchaseNumber,
                'channel'=>'web',
                'code' => 200,
                //'pers_nombre' => Session::get('SESS_PERS_NOMBRE'),
                //'pers_apellido' => Session::get('SESS_PERS_APATERNO'),
                'pers_correo' => Session::get('SESS_PERS_CORREO'),
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => 'Error al validar la cuenta', 'data' => $th->getMessage(), 'code' => 500], 500);
        }

    }

    public function finalizarPago(Request $request, $codigo_operacion){
        
        $amount = $request->amount;
        $purchasenumber = $request->purchasenumber;
        $transactionToken = $request->transactionToken;
        #$amount = str_replace(',', '', $request->amount);
        
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
            if (isset($data->dataMap)):
                $ACTION_CODE = $data->dataMap->ACTION_CODE; #: "000",
                $codigo = Session::get('SESS_PERS_CONTR_CODIGO');

                $transactionData = $this->visaServiceOnline->extractTransactionData($data);

                $NiubizResponse = NiubizResponse::where('PURCHASENUMBER', $transactionData['PURCHASENUMBER'])->firstOrFail();
                $NiubizResponse->ACTION_CODE = $transactionData['ACTION_CODE'];
                $NiubizResponse->TRANSACTION_ID = $transactionData['TRANSACTION_ID'];
                $NiubizResponse->TRANSACTIONDATE = $transactionData['TRANSACTION_DATE'];
                $NiubizResponse->JSON_NIUBIZ = json_encode($data);
                $NiubizResponse->STATUS = $transactionData['STATUS'];
                $NiubizResponse->AMOUNT = floatval($transactionData['AMOUNT']) ?? 0;
                $NiubizResponse->save();

                if($ACTION_CODE=='000'):

                    $contribuyente = Contribuyente::where('idsigma', $codigo)->first();

                    try {
                        $params = [
                            'codigo' => $codigo,
                            'contribuyente' => $contribuyente,
                            'transactionData' => $transactionData,
                            'codigo_operacion' => $codigo_operacion,
                            'purchaseNumber' => $purchasenumber,
                            //'json' => json_encode(json_decode($NiubizResponse->JSON_PROCESO))
                        ];
                        try {
                                $reciboResponse = $this->generarPago($params);
                                
                                Log::info('reciboResponse: '.json_encode($reciboResponse));

                                $recibo = $reciboResponse->getData();
                                $recibo = json_decode(json_encode($recibo), true);
                                #Log::info('recibo: '.json_encode($recibo));
                                
                                $transactionData['NRO_PEDIDO'] = $recibo['emitido'] ?? '000000';
                        } catch (\Throwable $th) {
                            Log::error('Error al generar recibo 1: '.$th->getMessage());
                        }
                        $page_data['page_directory'] = 'pagalo.pago_linea';
                        $page_data['page_title'] = 'Pago en línea';
                        $page_data['breadcrumbone'] = 'Págalo';

                        Notification::route('mail', Session::get('SESS_PERS_CORREO'))
                                ->notify((new ReciboNotification(json_encode($transactionData), $pdfOutputs = []))->delay(now()->addMinute(1)));

                        $page_data['page_name'] = 'recibo';
                        $page_data['breadcrumb'] = 'Pago realizado correctamente';
                        $page_data['jsonData'] = json_encode($transactionData);
                        return view('index',$page_data);

                    } catch (\Throwable $th) {

                        Notification::route('mail', Session::get('SESS_PERS_CORREO'))
                        ->notify((new ReciboNotification(json_encode($transactionData), []))->delay(now()->addMinute(1)));

                        $page_data['page_name'] = 'recibo';
                        $page_data['breadcrumb'] = 'Pago realizado correctamente';
                        $page_data['jsonData'] = json_encode($transactionData);
                        return view('index',$page_data);
                    }
                    
                else:
                    
                    Log::channel('pagoonlinea')->debug('Data Rechazado: '.json_encode($transactionData));

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

                    Log::channel('pagoonlinea')->debug('Data Error Tarjeta: '.json_encode($dataJson));

                    $transactionData = $this->visaServiceOnline->extractTransactionFaild($data);
                    $NiubizResponse = NiubizResponse::where('PURCHASENUMBER',  $purchasenumber)->firstOrFail();
                    $NiubizResponse->ACTION_CODE = $transactionData['ACTION_CODE'];
                    $NiubizResponse->TRANSACTIONDATE = $transactionData['TRANSACTION_DATE'];
                    $NiubizResponse->JSON_NIUBIZ = json_encode($data);
                    $NiubizResponse->STATUS = $transactionData['STATUS'];
                    $NiubizResponse->AMOUNT = floatval($transactionData['AMOUNT']) ?? 0;
                    $NiubizResponse->save();

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
    public function generarPago($params){
        $codigo = $params['codigo'];
        $contribuyente = $params['contribuyente'];
        $transactionData = $params['transactionData'];
        $codigo_operacion = $params['codigo_operacion'];
        $purchaseNumber = $params['purchaseNumber'];
        #$json = $params['json'];

        try {
            #$data = json_decode($json, true);

            DB::beginTransaction();

            #************************************* Cambiar estado de cuenta *************************************
            $registrosPago = RegistroPago::where('codigo_operacion', $codigo_operacion)
                ->where('pushernumber', $purchaseNumber)
                ->where('cidpers', $codigo)
                ->get();

            if ($registrosPago->isEmpty()) {
                throw new \Exception('No se encontraron registros en RegistroPago para actualizar.');
            }

            $fecha_pago = Carbon::now();
            $fecha_pago = $fecha_pago->format('Y-m-d H:i:s');

            $nroCaja = '0049'; #caja pagos en linea
            $nroRecibo = 0;

            $resultado = DB::select("SELECT tesoreria.obt_nro_recibo(?) AS nro_recibo", [$nroCaja]);
            if (!empty($resultado))
                $nroRecibo = $resultado[0]->nro_recibo;

            Log::info('nroRecibo: '.$nroRecibo);

            foreach ($registrosPago as $registro) {
                EstadoCuenta::where('idsigma', $registro->idsigma)
                    ->where('nestado', '0')
                    ->where('cidpers', $codigo)
                    ->update([
                        'nestado' => '1',
                        'dfecpag' => $fecha_pago,
                        'vobserv' => $purchaseNumber,
                        'fact_mora' => $registro->factor_mora_d,
                        'imp_mora' => $registro->mora_d
                    ]);

                    #genera recibo detalle
                    $mtesoreria = new Mtesoreria();
                    #$mtesoreria->idsigma = $codigo;
                    $mtesoreria->cidecta = $registro->idsigma;
                    $mtesoreria->cnumcom = $nroRecibo;
                    $mtesoreria->nmontot = $transactionData['AMOUNT'];
                    $mtesoreria->dfecpag = $fecha_pago;
                    $mtesoreria->nestado = '1';
                    $mtesoreria->vusernm = $nroCaja;
                    $mtesoreria->vhostnm = $this->getIpCliente();
                    $mtesoreria->ddatetm = $fecha_pago;
                    $mtesoreria->cidpers = $codigo;
                    $mtesoreria->cidpred = $registro->cidpred;
                    $mtesoreria->cperanio = $registro->cperanio;
                    $mtesoreria->ctiprec = $registro->ctiprec;
                    $mtesoreria->cperiod = $registro->cperiod;
                    $mtesoreria->ncantid = 1;
                    $mtesoreria->imp_insol = $registro->imp_insol;
                    $mtesoreria->fact_reaj = $registro->reajuste;
                    $mtesoreria->imp_reaj = $registro->reajuste;
                    $mtesoreria->fact_mora = $registro->factor_mora_d;
                    $mtesoreria->imp_mora = $registro->mora_d;
                    $mtesoreria->costo_emis = $registro->costo_emis;
                    $mtesoreria->vobserv = $purchaseNumber;
                    $mtesoreria->ctippag = '1000001864';
                    $mtesoreria->cnroope = $purchaseNumber;
                    $mtesoreria->cidapertura = '0000000000';
                    $mtesoreria->cnumope = $nroRecibo;
                    $mtesoreria->save();
            }

            Log::info('Fin tabla mtesoreria');

            #Elimina los registros de RegistroPago
            RegistroPago::where('codigo_operacion', $codigo_operacion)
                ->whereNull('pushernumber')
                ->where('cidpers', $codigo)
                ->delete();

            Log::info('Fin tabla RegistroPago');
            #************************************* Fin Cambiar estado de cuenta *************************************
            #genera recibo cabecera
            $dtesoreria = new Dtesoreria();
            $dtesoreria->idsigma = Str::uuid();
            $dtesoreria->cnumcom = $nroRecibo;
            $dtesoreria->ciduser = 'PAGALO';
            $dtesoreria->cidpers = $codigo;
            $dtesoreria->nnroope = $purchaseNumber;
            $dtesoreria->dfecpag = $fecha_pago;
            $dtesoreria->dnrodoc = Session::get('SESS_PERS_DOCUMENTO');
            $dtesoreria->ctippag = '1000001864'; #Efectivo
            $dtesoreria->nestado = 1;
            $dtesoreria->nmontot = $transactionData['AMOUNT'];
            $dtesoreria->vhostnm = $this->getIpCliente();
            $dtesoreria->vusernm = $nroCaja;
            $dtesoreria->ddatetm = $fecha_pago;
            $dtesoreria->cnumope = $nroRecibo;
            $dtesoreria->save();
        
            Log::info('Fin tabla dtesoreria');
            DB::commit();

        } catch (\Exception $th) {
            DB::rollBack();
            Log::error('Error al generar recibo 2: '.$th->getMessage());
        }
        
        return response()->json(['emitido' => $nroRecibo ], 200);
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