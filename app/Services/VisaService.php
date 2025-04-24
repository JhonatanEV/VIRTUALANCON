<?php
namespace App\Services;
use App\Helpers\NiubizHelper;
use GuzzleHttp\Client;
class VisaService
{   
    protected $visaCredentials;

    public function __construct()
    {   
        $this->visaCredentials = NiubizHelper::getCurrentCredentials();
    }

    function generateToken() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->visaCredentials['url_security'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
            "Accept: */*",
            'Authorization: '.'Basic '.base64_encode($this->visaCredentials['user'].":".$this->visaCredentials['password'])
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function generateSesion($amount, $token, $parametros=[], $dataMap=[]) {
        $session = array(
            'channel' => 'web',
            'amount' => $amount,
            'antifraud' => array(
                'clientIp' => $_SERVER['REMOTE_ADDR'],
                'merchantDefineData' => $parametros,
            ),
            'dataMap' => $dataMap,
        );
        $json = json_encode($session);
        $response = json_decode($this->postRequest($this->visaCredentials['url_session'], $json, $token));
        return $response->sessionKey;
    }

    function generateAuthorization($amount, $purchaseNumber, $transactionToken, $token, $parametros=[]) {
        $data = array(
            'captureType' => 'manual',
            'channel' => 'web',
            'countable' => true,
            'order' => array(
                'amount' => $amount,
                'currency' => 'PEN',
                'purchaseNumber' => $purchaseNumber,
                'tokenId' => $transactionToken
            ),
            'dataMap' => $parametros
        );
        $json = json_encode($data);
        $session = json_decode($this->postRequest($this->visaCredentials['url_authorization'], $json, $token));
        return $session;
    }

    function postRequest($url, $postData, $token) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                'Authorization: '.$token,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => $postData
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function generatePurchaseNumber(){

        $archivo = public_path('purchase_numbers/purchaseNumber.txt');
        $purchaseNumber = 222;

        if (file_exists($archivo)) {
            $fp = fopen($archivo, 'r+');
        
            if (flock($fp, LOCK_EX)) {  // Bloquear el archivo para escritura
                $purchaseNumber = fgets($fp, 100);
                ++$purchaseNumber;
        
                ftruncate($fp, 0);  // Borrar el contenido existente
                rewind($fp);  // Mover el puntero del archivo al inicio
                fwrite($fp, $purchaseNumber, 100);
        
                flock($fp, LOCK_UN);  // Liberar el bloqueo
            }
        
            fclose($fp);
        } else {
            $purchaseNumber = 1;
            file_put_contents($archivo, $purchaseNumber);
        }

        return $purchaseNumber;
    }
    public function extractTransactionData($data){
        return [
            'ACTION_CODE' => $data->dataMap->ACTION_CODE ?? '',
            'TERMINAL' => $data->dataMap->TERMINAL ?? '',
            'BRAND_ACTION_CODE' => $data->dataMap->BRAND_ACTION_CODE ?? '',
            'BRAND_HOST_DATE_TIME' => $data->dataMap->BRAND_HOST_DATE_TIME ?? '',
            'TRACE_NUMBER' => $data->dataMap->TRACE_NUMBER ?? '',
            'CARD_TYPE' => $data->dataMap->CARD_TYPE ?? '',
            'ECI_DESCRIPTION' => $data->dataMap->ECI_DESCRIPTION ?? '',
            'SIGNATURE' => $data->dataMap->SIGNATURE ?? '',
            'CARD' => $data->dataMap->CARD ?? '',
            'MERCHANT' => $data->dataMap->MERCHANT ?? '',
            'STATUS' => $data->dataMap->STATUS ?? '',
            'ACTION_DESCRIPTION' => $data->dataMap->ACTION_DESCRIPTION ?? '',
            'ID_UNICO' => $data->dataMap->ID_UNICO ?? '',
            'AMOUNT' => $data->dataMap->AMOUNT ?? '',
            'BRAND_HOST_ID' => $data->dataMap->BRAND_HOST_ID ?? '',
            'AUTHORIZATION_CODE' => $data->dataMap->AUTHORIZATION_CODE ?? '',
            'YAPE_ID' => $data->dataMap->YAPE_ID ?? '',
            'CURRENCY' => $data->dataMap->CURRENCY ?? '',
            'TRANSACTION_DATE' => $this->formatTransactionDate($data->dataMap->TRANSACTION_DATE ?? ''),
            'ACTION_CODE' => $data->dataMap->ACTION_CODE ?? '',
            'ECI' => $data->dataMap->ECI ?? '',
            'ID_RESOLUTOR' => $data->dataMap->ID_RESOLUTOR ?? '',
            'BRAND' => $data->dataMap->BRAND ?? '',
            'ADQUIRENTE' => $data->dataMap->ADQUIRENTE ?? '',
            'BRAND_NAME' => $data->dataMap->BRAND_NAME ?? '',
            'PROCESS_CODE' => $data->dataMap->PROCESS_CODE ?? '',
            'TRANSACTION_ID' => $data->dataMap->TRANSACTION_ID ?? '',
            'TOKENID' => $data->order->tokenId ?? '',
            'PURCHASENUMBER' => $data->order->purchaseNumber ?? '',
            'INSTALLMENT' => $data->order->installment ?? '',
            'AUTHORIZEDAMOUNT' => $data->order->authorizedAmount ?? '',
            'AUTHORIZATIONCODE' => $data->order->authorizationCode ?? '',
            'ACTIONCODE' => $data->order->actionCode ?? '',
            'TRACENUMBER' => $data->order->traceNumber ?? '',
            'TRANSACTIONDATE' => $data->order->transactionDate ?? '',
            'TRANSACTIONID' => $data->order->transactionId ?? '',
        ];
    }
    public function extractTransactionFaild($data){

        return [
            'ACTION_CODE' => $data->data->ACTION_CODE ?? '' ,
            'CURRENCY' => $data->data->CURRENCY ?? '' ,
            'TERMINAL' => $data->data->TERMINAL ?? '' ,
            'TRANSACTION_DATE' => $this->formatTransactionDate($data->data->TRANSACTION_DATE ?? '') ,
            'BRAND' => $data->data->BRAND ?? '' ,
            'TRACE_NUMBER' => $data->data->TRACE_NUMBER ?? '' ,
            'CARD_TYPE' => $data->data->CARD_TYPE ?? '' ,
            'ECI' => $data->data->ECI ?? '' ,
            'ECI_DESCRIPTION' => $data->data->ECI_DESCRIPTION ?? '' ,
            'SIGNATURE' => $data->data->SIGNATURE ?? '' ,
            'CARD' => $data->data->CARD ?? '' ,
            'MERCHANT' => $data->data->MERCHANT ?? '' ,
            'STATUS' => $data->data->STATUS ?? '' ,
            'ADQUIRENTE' => $data->data->ADQUIRENTE ?? '' ,
            'ACTION_DESCRIPTION' => $data->data->ACTION_DESCRIPTION ?? '' ,
            'ID_UNICO' => $data->data->ID_UNICO ?? '' ,
            'AMOUNT' => $data->data->AMOUNT ?? '' ,
            'PROCESS_CODE' => $data->data->PROCESS_CODE ?? '' ,
            'TRANSACTION_ID' => $data->data->TRANSACTION_ID ?? '' ,
        ];
    }
    public function formatTransactionDate($date)
    {
        if (!$date || strlen($date) < 12) {
            return '';
        }

        return sprintf(
            '%s/%s/%s %s:%s:%s',
            $date[4] . $date[5],
            $date[2] . $date[3],
            $date[0] . $date[1],
            $date[6] . $date[7],
            $date[8] . $date[9],
            $date[10] . $date[11]
        );
    }
}
