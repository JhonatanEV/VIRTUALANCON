<?php
namespace App\Http\Controllers\pagalo\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroPago extends Model
{
    protected $table = 'virtual.REGISTRO_PAGO';

    protected $primaryKey = 'ID';

    public $timestamps = false;

    public $incrementing = true;
    
    protected $fillable = [
        'cidpers',
        'cidpred',
        'ctiping',
        'ctiprec',
        'cperanio',
        'cperiod',
        'idsigma',
        'imp_insol',
        'costo_emis',
        'dfecven',
        'reajuste',
        'factor_mora_d',
        'mora_d',
        'fecha_registro',
        'codigo_operacion',
        'pushernumber'
    ];
}