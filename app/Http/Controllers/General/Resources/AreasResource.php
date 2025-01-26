<?php

namespace App\Http\Controllers\General\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class AreasResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'area_codigo' => $this->AREA_CODIGO,
            'area_sub_codigo' => $this->AREA_SUB_CODIGO,
            'area_nombre' => $this->AREA_NOMBRE,
            'area_tipo' => $this->AREA_TIPO,
            'area_abrev' => $this->AREA_ABREV,
            'area_orden' => $this->AREA_ORDEN,
            'area_estado' => $this->AREA_ESTADO,
        ];
    }
}
