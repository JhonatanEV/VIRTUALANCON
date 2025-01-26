<?php
namespace App\Http\Controllers\pagalo\Models;

use Illuminate\Database\Eloquent\Model;

class PagosLineaCheckout extends Model
{
    protected $connection = 'sqlsrv_rentas';
    protected $table = 'dbo.PAGOSLINEA_CHECKOUT';

    protected $primaryKey = 'FACODCHECKOUT';

    public $timestamps = false;

    public $incrementing = true;
    
    protected $fillable = [
        'FACODMONEDA',
        'FAMONTO',
        'FANROOPERACION',
        'FAMETPAGO',
        'FAFECPAGO',
        'FATOKEN',
        'FACODCOMERCIO',
        'FACODADQUISICION',
        'FACODVERIFICA',
        'FACODCONTR',
        'FARESPUESTAPAGO',
        'FAREQUESTPAGO'
    ];
}