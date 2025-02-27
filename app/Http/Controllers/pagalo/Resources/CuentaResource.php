<?php
namespace App\Http\Controllers\Pagalo\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class CuentaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'codigo' => $this->cidpers,
            'nro_recibo' => $this->nro_recibo ?? '',
            'cod_pred' => $this->cidpred,
            'anexo' => $this->anexo ?? '',
            'direc_pred' => $this->direccion_predio ?? '',
            'anio' => $this->cperanio,
            'periodo' => $this->cperiod,
            'cod_tributo' => $this->ctiping,
            'nom_tributo' => trim($this->vdescri),
            'abrev_tributo' => trim($this->tipo_tribu),
            'fecha_vencimiento' => $this->dfecven,
            'fecha_calculo' => $this->fecha_calculo,
            'situacion' => $this->situacion ?? '',
            'estado' => $this->estado ?? '',
            'mora' => $this->mora,
            'reajuste' => $this->reajuste,
            'imp_insol' => $this->saldo_fijo,
            'costo_emis' => $this->costo_emis,
            'gasto_admin' => $this->gasto_admin ?? 0,
            'descuento' => $this->descuento ?? 0,
            'sub_total' => floatval($this->total),
            'total' => floatval($this->total),
            'llave' => trim($this->llave),
            'idsigma_agrupados' => $this->idsigma_agrupados,
            'codigo_operacion' => $this->codigo_operacion
        ];
    }
}