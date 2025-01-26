<?php
namespace App\Models\Virtual;

use Illuminate\Database\Eloquent\Model;

class MesadePartes extends Model
{
    protected $table = 'VIRTUAL.MESA_PARTES';
    protected $primaryKey = 'MESA_CODIGO';
    public $timestamps = false;
    protected $fillable = [
        'MESA_TIPOPER',
        'MESA_DOCUMENTO',
        'MESA_NOMBRES',
        'MESA_PATERNO',
        'MESA_MATERNO',
        'MESA_RUC',
        'MESA_RAZONSOCIAL',
        'MESA_DIRECCION',
        'MESA_CORREO',
        'MESA_CELULAR',
        'MESA_NRODOC',
        'MESA_ASUNTO',
        'MESA_NOMBRE_FILE',
        'MESA_FOLIO',
        'MESA_DEP',
        'MESA_PRO',
        'MESA_DIS',
        'MESA_FECHING',
        'MESA_OPERADOR',
        'MESA_ESTADO'
    ];
}
