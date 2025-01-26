<?php

namespace App\Http\Controllers\notificaciones\Models;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{   
    protected $connection = 'public';
    protected $table = 'public.NOTIFICACION';

    protected $primaryKey = 'COD_NOTIFICACION';

    public $keyType = 'int';

    public $timestamps = false;

    public $incrementing = true;

    protected $fillable = [
        'COD_EMP',
        'COD_SEDE',
        'TITULO',
        'DES_CONTENIDO',
        'EMISOR_USUARIO',
        'DESTINO_USUARIO',
        'URL',
        'LEIDO',
        'FEC_NOTIFICA',
        'IND_ESTADO',
    ];

}
