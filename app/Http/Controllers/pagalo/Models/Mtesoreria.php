<?php
namespace App\Http\Controllers\pagalo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mtesoreria extends Model
{
    protected $table = 'tesoreria.mtesore';

    protected $primaryKey = 'idsigma';

    public $keyType = 'string';

    public $timestamps = false;
    public $incrementing = false;
    
    protected $fillable = [
        'idsigma',
        'cidecta',
        'cnumcom',
        'nmontot',
        'dfecpag',
        'nestado',
        'vusernm',
        'vhostnm',
        'ddatetm',
        'cidpers',
        'cidpred',
        'cperanio',
        'ctiprec',
        'cperiod',
        'ncantid',
        'imp_insol',
        'fact_reaj',
        'imp_reaj',
        'fact_mora',
        'imp_mora',
        'costo_emis',
        'vobserv',
        'ctippag',
        'cnroope',
        'cidapertura',
        'cnumope'
    ];
}