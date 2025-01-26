<?php

namespace App\Http\Controllers\Seguridad\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Seguridad\Models\Opciones;

class Permisos extends Model
{
    protected $table = 'virtual.PERMISOS';
    protected $primaryKey = 'PERM_CODIGO';
    public $timestamps = false;

    protected $fillable = [
        'PERM_CODIGO',
        'PERF_CODIGO',
        'OPCI_CODIGO',
        'PERM_ESTADO'
    ];

    public function opciones()
    {
        return $this->hasOne(Opciones::class, 'OPCI_CODIGO', 'OPCI_CODIGO')->where('OPCI_ESTADO', 1);
    }
}