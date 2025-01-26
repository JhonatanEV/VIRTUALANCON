<?php

namespace App\Http\Controllers\Seguridad\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Seguridad\Models\Opciones;

class Accesos extends Model
{
    protected $table = 'virtual.ACCESOS';
    protected $primaryKey = 'ACCE_CODIGO';
    public $timestamps = false;

    protected $fillable = [
        'OPCI_CODIGO',
        'USUA_CODIGO',
        'ACCE_ESTADO',
        'ACCE_FECHING',
        'ACCE_OPERADOR',
        'ACCE_ESTACION',
    ];

    protected $casts = [
        'ACCE_CODIGO' => 'int',
        'OPCI_CODIGO' => 'int',
        'USUA_CODIGO' => 'int',
        'ACCE_ESTADO' => 'int',
        'ACCE_OPERADOR' => 'int',
    ];

    public function opciones()
    {
        return $this->belongsTo(Opciones::class, 'OPCI_CODIGO', 'OPCI_CODIGO');
    }
    public function scopeActivosPorUsuario($query, $usuarioCodigo)
    {
        return $query->where('ACCE_ESTADO', 1)
                    ->where('USUA_CODIGO', $usuarioCodigo)
                    ->with(['opciones' => function ($query) {
                        $query->where('OPCI_ESTADO', 1)->orderBy('OPCI_ORDER');
                    }]);
    }

}