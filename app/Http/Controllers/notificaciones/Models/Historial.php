<?php

namespace App\Http\Controllers\notificaciones\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Storage;

class Historial extends Model
{    
    protected $table = 'notificacion.HISTORIAL';        
        
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $primaryKey = 'HIST_CODIGO';
    public $incrementing = true;
    public $timestamps = false;
    
    protected $fillable = [
        'HIST_BAND_CODIGO',
        'HIST_MENSAJE',
        'HIST_FEC_ENVIADO',
        'HIST_SEND',
        'HIST_MESSAGE',
        'HIST_IDENVIADO'
    ];

    function ultra()
    {
        return $this->hasOne(UltraSmg::class, 'ID', 'HIST_IDENVIADO');
    }
}