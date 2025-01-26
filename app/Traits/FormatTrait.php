<?php

namespace App\Traits;

use Carbon\Carbon;

trait FormatTrait
{

    function formatDate($valor, $format = 'd/m/Y')
    {
        return $valor ? Carbon::parse($valor)->format($format) : $valor;
    }

    function formatHour($valor, $format = 'H:i')
    {
        return $valor ? Carbon::parse($valor)->format($format) : $valor;
    }

    function formatDateHour($valor, $format = 'd/m/Y H:i')
    {
        return $valor ? Carbon::parse($valor)->format($format) : $valor;
    }

    function formatText($valor)
    {
        return mb_strtoupper($valor, 'UTF-8');
    }

    function formatNameFile($valor)
    {
        $valor = preg_replace('/\\.[^.\\s]{3,4}$/', '', $valor); // quita la extensión

        $valor = preg_replace('([^A-Za-z0-9])', '', $valor); // deja solo letras y numeros

        return $valor;
    }

    function formatLengthNameFile($valor, $length = 180)
    {

        if (strlen($valor) > $length) {
            return substr($valor, 0, $length);
        }

        return $valor;
    }
}
