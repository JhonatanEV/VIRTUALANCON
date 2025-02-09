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
            $codigo = Session::get('SESS_CODIGO_CONTRI');
            $arrayInsert = [];
            
            #$monto = str_replace(',', '', $monto);
            #NIUBIZ
            $purchaseNumber = $this->visaServiceOnline->generatePurchaseNumber().'1'; #pagotributo;
            #FIN
            DB::beginTransaction();

            $response = new NiubizResponse();
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
        $total = str_replace(',', '', $total);
        $total = (float)number_format($total, 2, '.', '');

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
                'merchantid'=> NiubizHelper::getCurrentCredentials()['merchant_id'],
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
                            'json' => json_encode(json_decode($NiubizResponse->JSON_PROCESO))
                        ];
                        try {
                                $reciboResponse = $this->generarPago($params);
                                $recibo = $reciboResponse->getData();
                                Log::info('recibo: '.json_encode($recibo));
                                
                                $transactionData['NRO_PEDIDO'] = $recibo['emitido'] ?? '000000';
                        } catch (\Throwable $th) {
                            Log::error('Error al generar recibo: '.$th->getMessage());
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
        $json = $params['json'];

        return response()->json(['emitido' => '0000000'], 200);
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