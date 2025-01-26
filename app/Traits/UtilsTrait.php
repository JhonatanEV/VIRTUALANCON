<?php

namespace App\Traits;

trait UtilsTrait
{
    protected  function getIpCliente()
    {
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            return $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
            return $_SERVER["HTTP_X_FORWARDED"];
        } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
            return $_SERVER["HTTP_FORWARDED"];
        } else {
            return $_SERVER["REMOTE_ADDR"];
        }
    }

    function formatBytes($size, $precision = 2)
    {
        if ($size == 0) {
            return $size;
        }

        $base = log($size, 1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }

    function completarCadena($cadena, $longitud, $caracter = '0', $izquierda = true)
    {
        if (strlen($cadena) >= $longitud) {
            return $cadena;
        }

        $cadena = str_pad($cadena, $longitud, $caracter, STR_PAD_LEFT);

        return $cadena;
    }
}
