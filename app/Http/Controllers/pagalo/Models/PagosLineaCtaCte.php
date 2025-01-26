<?php
namespace App\Http\Controllers\pagalo\Models;

use Illuminate\Database\Eloquent\Model;

class PagosLineaCtaCte extends Model
{
    protected $connection = 'sqlsrv_rentas';
    protected $table = 'dbo.PAGOSLINEA_CTACTE';

    protected $primaryKey = 'ID';

    public $timestamps = false;

    public $incrementing = true;
    protected $fillable = [
        'FACODCONTR',
        'FACODTRIBU',
        'FADESTRIBU',
        'FAANOTRIBU',
        'FAANEXO',
        'FANRORECIB',
        'FAPERIODO',
        'FNIMP01',
        'FNIMP02',
        'FNIMP03',
        'FNIMP04',
        'FNGASADMIN',
        'FNMORA',
        'FASITRECIB',
        'MARCA',
        'VCTIPOBENE',
        'VNFIMP01',
        'VNFIMP02',
        'VNFIMP03',
        'VNFIMP04',
        'FASUBTRIBU',
        'FABUSQUEDA',
        'FNIMP05',
        'VNFIMP05',
        'FACONRECIB',
        'FADESRECIB',
        'FACODAREA',
        'VNFGASADMIN',
        'FNCOSPROCE',
        'VNFCOSPROCE',
        'DIRANEXO',
        'FECVENC',
        'MONTO',
        'DESCUENTO',
        'TOTAL',
        'FEC_OPERACION',
        'NRO_OPERACION',
        'FACODCHECKOUT'
    ];
}