<?php

namespace App\Http\Controllers\notificaciones\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Storage;

class Tipo extends Model
{    
    protected $table = 'notificacion.TIPO';        
        
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $primaryKey = 'TIPO_CODIGO';
    public $incrementing = true;
    public $timestamps = false;

    public function bandejas()
    {
        return $this->hasMany(Bandeja::class, 'BAND_TIPO_CODIGO', 'TIPO_CODIGO');
    }
}