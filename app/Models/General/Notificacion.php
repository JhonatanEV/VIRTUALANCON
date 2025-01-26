<?php

namespace App\Models\General;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'GENERAL.NOTIFICACION';
    protected $primaryKey = 'NOTIF_CODIGO';
    public $timestamps = false;

    protected $fillable = [
        'NOTIF_TITULO',
        'NOTIF_CONTENIDO',
        'NOTIF_EMISOR',
        'NOTIF_DESTINO',
        'NOTIF_URL',
        'NOTIF_LEIDO',
        'NOTIF_FECING',
        'NOTIF_ESTADO'
    ];

    protected $casts = [
        'NOTIF_CODIGO' => 'int',
        'NOTIF_LEIDO' => 'int',
        'NOTIF_FECING' => 'datetime',
        'NOTIF_ESTADO' => 'int'
    ];
}