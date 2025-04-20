<?php
namespace App\Http\Controllers\pagalo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\pagalo\Models\Mconten;
class EstadoCuenta extends Model
{
    protected $table = 'tesoreria.mestcta';

    protected $primaryKey = 'idsigma';

    public $keyType = 'string';

    public $timestamps = false;

    public $incrementing = true;
    
    protected $fillable = [
        'id',
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

    public function mconten()
    {
        return $this->belongsTo(Mconten::class, 'ctiping', 'idsigma');
    }
}