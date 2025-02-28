<?php
namespace App\Http\Controllers\pagalo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AperturaCaja extends Model
{
    protected $table = 'tesoreria.aperturacaja';

    protected $primaryKey = 'idsigma';

    public $keyType = 'string';

    public $timestamps = false;
    public $incrementing = false;

    // public function codapeturacajero($cajero){
    //     $codApertura = AperturaCaja::where('cnrocaj', $cajero)
    //     ->first();

    //     if (empty($codApertura)) {
    //         return '0000000001';
    //     }
    //     return $codApertura->idsigma;
    // }

    public function codapeturacajero($cajero)
    {
        $cajero = substr($cajero, -2);

        $fechaActual = now()->toDateString();

        $codApertura = AperturaCaja::where('cnrocaj', $cajero)
            ->whereDate('dfecpro', $fechaActual)
            ->first();

        // Si no existe, crear un nuevo registro
        if (empty($codApertura)) {
            $nuevoIdsigma = AperturaCaja::max('idsigma');
            $nuevoIdsigma = str_pad((intval($nuevoIdsigma) + 1), 10, '0', STR_PAD_LEFT);

            $apertura = AperturaCaja::where('cnrocaj', $cajero)->first();

            $codApertura = new AperturaCaja();
            $codApertura->idsigma = $nuevoIdsigma;
            $codApertura->cnrocaj = $cajero;
            $codApertura->ciduser = $apertura->ciduser;
            $codApertura->nmonval = 0;
            $codApertura->dfecpro = now();
            $codApertura->nestado = 1; #1 = Abierto, 2 = Cerrado
            $codApertura->save();
        }

        return $codApertura->idsigma;
    }
    
}