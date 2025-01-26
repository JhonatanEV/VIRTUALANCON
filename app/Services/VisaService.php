<?php
namespace App\Services;
use Illuminate\Support\Facades\Config;

class VisaService
{   
    protected $visaCredentials;

    public function __construct($visaCredentials = null)
    {   
        $this->visaCredentials =  $visaCredentials;# ?? config('visa.current_credentials')();
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

    function generateSesion($amount, $token, $parametros=[]) {
        $session = array(
            'amount' => $amount,
            'antifraud' => array(
                'clientIp' => $_SERVER['REMOTE_ADDR'],
                'merchantDefineData' => $parametros,
            ),
            'channel' => 'web',
        );
        $json = json_encode($session);
        $response = json_decode($this->postRequest($this->visaCredentials['url_session'], $json, $token));
        return $response->sessionKey;
    }

    function generateAuthorization($amount, $purchaseNumber, $transactionToken, $token) {
        $data = array(
            'antifraud' => null,
            'captureType' => 'manual',
            'channel' => 'web',
            'countable' => true,
            'order' => array(
                'amount' => $amount,
                'currency' => 'PEN',
                'purchaseNumber' => $purchaseNumber,
                'tokenId' => $transactionToken
            ),
            'recurrence' => null,
            'sponsored' => null
        );
        $json = json_encode($data);
        #\Log::channel('niubiz')->debug('Authorization Request: '.$json);
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
    function generatePurchaseNumberPO(){

        $archivo = public_path('purchase_numbers/purchaseNumberPO.txt');
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
}
