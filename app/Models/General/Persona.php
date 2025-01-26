<?php

namespace App\Models\General;
use Illuminate\Database\Eloquent\Model;
use App\Models\General\Contactos;
class Persona extends Model
{
    protected $table = 'virtual.PERSONA';

    protected $primaryKey = 'PERS_CODIGO';

    public $keyType = 'int';

    public $timestamps = false;

    public $incrementing = true;

    public function contactos(){
        return $this->hasMany(Contactos::class, 'PERS_CODIGO', 'PERS_CODIGO');
    }
    public function correo(){
        return $this->belongsTo(Contactos::class, 'PERS_CODIGO', 'PERS_CODIGO')
                    ->where('TIPO_D_CODIGO', 15)
                    ->where('CONTC_ESTADO', 1)
                    ->select('CONTC_DATOS');
    }
    public function celular(){
        return $this->belongsTo(Contactos::class, 'PERS_CODIGO', 'PERS_CODIGO')
                    ->where('TIPO_D_CODIGO', 8)
                    ->where('CONTC_ESTADO', 1)
                    ->select('CONTC_DATOS');
    }
}
