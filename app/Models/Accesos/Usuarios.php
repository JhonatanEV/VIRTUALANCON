<?php

namespace App\Models\Accesos;
use Illuminate\Database\Eloquent\Model;
use App\Models\General\Persona;
use Illuminate\Support\Facades\Hash;

class Usuarios extends Model
{
    protected $table = 'virtual.USUARIOS';

    protected $primaryKey = 'USUA_CODIGO';

    public $keyType = 'int';

    public $timestamps = false;

    public $incrementing = true;

    protected $hidden = [
        'USUA_PASSWORD',
    ];
    public static function hashPassword($value)
    {
        return  Hash::make($value);
    }
    public function persona(){
        return $this->belongsTo(Persona::class, 'PERS_CODIGO', 'PERS_CODIGO');
    }
}
