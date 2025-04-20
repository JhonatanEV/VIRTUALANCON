<?php
namespace App\Http\Controllers\pagalo\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class RegistroPago extends Model
{
    protected $table = 'virtual.REGISTRO_PAGO';

    protected $primaryKey = 'id';

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
        'descuento',
        'fecha_registro',
        'codigo_operacion',
        'pushernumber'
    ];

    public static function aplicarDescuentosSeleccionados($purchaseNumber)
    {
        $registros = self::where('pushernumber', $purchaseNumber)->get();
        Log::info('Inicio descuento');
        if ($registros->isEmpty()) return;

        $cidpers = $registros->first()->cidpers;
        $codigoOperacion = $registros->first()->codigo_operacion;
        
        $beneficioAplica = self::beneficioAplicable($cidpers, $codigoOperacion, $purchaseNumber);
        Log::info('beneficioAplica');

        foreach ($registros as $registro) {
            $anio = intval($registro->cperanio);
            $descuento = 0;

            if (!$beneficioAplica) {
                $registro->descuento = 0;
                $registro->save();
                continue;
            }

            if ($registro->ctiping === '0000000273') { // Impuesto Predial
                $descuento = $registro->mora_d; // 100% intereses
            }

            if ($registro->ctiping === '0000000278') { // Arbitrios
                if ($anio === 2024) {
                    $tasaInsoluto = 0.20;
                } elseif (in_array($anio, [2022, 2023])) {
                    $tasaInsoluto = 0.30;
                } elseif (in_array($anio, [2019, 2020, 2021])) {
                    $tasaInsoluto = 0.50;
                } elseif ($anio <= 2018) {
                    $tasaInsoluto = 0.90;
                } else {
                    $tasaInsoluto = 0.0;
                }
            
                $descuentoInsoluto = $registro->imp_insol * $tasaInsoluto;
                $descuentoInteres = $registro->mora_d;
                $descuento = $descuentoInsoluto + $descuentoInteres;
            }

            $registro->descuento = round($descuento, 2);
            $registro->save();
        }
    }
    public static function beneficioAplicable($cidpers, $codigoOperacion, $purchaseNumber)
    {
        #1. Validar vigencia de la ordenanza
        $fechaLimite = Carbon::createFromFormat('Y-m-d', '2025-04-30');
        $hoy = Carbon::now();

        if ($hoy->greaterThan($fechaLimite)) {
            Log::info("No aplica beneficio: fuera de fecha límite ({$hoy->toDateString()})");
            return false;
        }
        #2. Verificar si el contribuyente tiene alguna deuda de predial 2025 pendiente
        $deudaPendiente = self::where('cidpers', $cidpers)
            ->where('codigo_operacion', $codigoOperacion)
            #->where('ctiping', '0000000273') // Predial
            ->whereIn('ctiping', ['0000000273', '0000000278']) // Predial y Arbitrios
            ->where('cperanio', '2025')
            ->get();

        if ($deudaPendiente->isEmpty()) {
            #No tiene deudas del predial 2025 → ya pagó antes → beneficio válido
            Log::info("Beneficio aplica: ya no tiene deuda pendiente del predial 2025.");
            return true;
        }

        #3. Verificar si ha seleccionado toda su deuda de predial 2025
        $seleccionado = self::where('cidpers', $cidpers)
            ->where('codigo_operacion', $codigoOperacion)
            // ->where('ctiping', '0000000273') // Predial
            ->whereIn('ctiping', ['0000000273', '0000000278']) // Predial y Arbitrios
            ->where('cperanio', '2025')
            ->where('pushernumber', $purchaseNumber)
            ->get();

        if ($seleccionado->isEmpty()) {
            #Tiene deuda 2025 y no ha seleccionado nada
            return false;
        }

        #4. Comparar registros
        $ids_total = $deudaPendiente->pluck('idsigma')->sort()->values();
        $ids_seleccionados = $seleccionado->pluck('idsigma')->sort()->values();

        $aplica = $ids_total == $ids_seleccionados;

        Log::info("Beneficio aplica por selección completa: " . ($aplica ? 'sí' : 'no'));

        return $aplica;
    }
}