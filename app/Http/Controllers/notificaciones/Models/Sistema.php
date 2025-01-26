<?php

namespace App\Http\Controllers\notificaciones\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\notificaciones\Models\Bandeja;
use Illuminate\Support\Facades\DB;

class Sistema extends Model
{    
    protected $table = 'NOTIFICACION.SISTEMA';        
        
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $primaryKey = 'SIS_CODIGO';
    public $incrementing = true;
    public $timestamps = false;

    public function cantidad_enviados()
    {
        return Bandeja::where('SIS_CODIGO', $this->SIS_CODIGO)->where('BAND_ESTADO', '1')->count();
    }
    public function cantidad_pendientes()
    {
        return Bandeja::where('SIS_CODIGO', $this->SIS_CODIGO)->where('BAND_ESTADO', '0')->count();
    }
    public function getNewId()
    {
        $id = DB::table('NOTIFICACION.SISTEMA')->max('SIS_CODIGO');
        return $id + 1;
    }
}