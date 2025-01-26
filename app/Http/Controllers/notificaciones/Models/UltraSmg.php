<?php

namespace App\Http\Controllers\notificaciones\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Storage;

class UltraSmg extends Model
{    
    protected $table = 'notificacion.ULTRAMSG';        
        
    protected $dateFormat = 'Y-m-d H:i:s';
    // protected $primaryKey = 'ID';
    // public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'ID',
        'REFERENCEID',
        'FROM',
        'TO',
        'BODY',
        'PRIORITY',
        'STATUS',
        'ACK',
        'TYPE',
        'CREATED_AT',
        'SENT_AT',
        'METADATA',
        'INSTANCIA'
    ];

    function historial()
    {
        return $this->hasOne(Historial::class, 'HIST_IDENVIADO', 'ID');
    }
}