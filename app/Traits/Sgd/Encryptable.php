<?php

use Illuminate\Support\Facades\Crypt;

namespace App\Traits\Sgd;

use Illuminate\Support\Facades\Crypt;

trait Encryptable
{
    /**
     * Encrypt the given value.
     *
     * @param  string  $value
     * @return string
     */
    public function encrypt($value)
    {
        // Hashear la clave con SHA-1

        $clave = sha1(config('sgd.secret_key_password'), true);

        // Cifrar el texto en AES-128-ECB y convertirlo a hexadecimal
        $cifrado = openssl_encrypt($value, 'AES-128-ECB', $clave, OPENSSL_RAW_DATA);
        $texto_cifrado_hex = bin2hex($cifrado);
        return strtoupper($texto_cifrado_hex);
    }

    /**
     * Decrypt the given value.
     *
     * @param  string  $value
     * @return string
     */
    public function decrypt($value)
    {
    }
}
