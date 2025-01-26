<?php

namespace App\Http\Controllers\notificaciones\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\notificaciones\Models\Tipo;

class Bandeja extends Model
{    
    protected $table = 'NOTIFICACION.BANDEJA';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $primaryKey = 'BAND_CODIGO';
    public $incrementing = true;
    public $timestamps = false;
    
    protected $fillable = [
        'TIPO_CODIGO',
        'SIS_CODIGO',
        'BAND_SISTEMA',
        'BAND_MODULO',
        'BAND_PARA',
        'BAND_MENSAJE',
        'BAND_FILENAME',
        'BAND_URL',
        'BAND_LATITUD',
        'BAND_LONGITUD',
        'BAND_ESTADO',
        'BAND_PRIORIDAD',
        'BAND_CREADO',
        'BAND_OPERADOR',
        'BAND_ESTACION',
        'BAND_IDENTIFICADOR',
        'BAND_ENVIADO',
    ];
    function tipo()
    {
        return $this->belongsTo(Tipo::class, 'TIPO_CODIGO', 'TIPO_CODIGO');
    }
}